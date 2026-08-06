<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.transaksi', compact('transaksi'));
    }

    // Update status transaksi
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,selesai,batal'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = $request->status;
        $transaksi->save();

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui!');
    }

    // Check for new transactions (for real-time notification)
    public function checkNewTransactions(Request $request)
    {
        $lastCheckTime = $request->input('last_check');
        
        $newTransactions = Transaksi::with('user')
            ->where('created_at', '>', $lastCheckTime)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'has_new' => $newTransactions->count() > 0,
            'count' => $newTransactions->count(),
            'transactions' => $newTransactions
        ]);
    }
}
