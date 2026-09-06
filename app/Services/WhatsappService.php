<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public static function kirimPesan($target, $pesan)
    {
        $token = env('FONNTE_TOKEN');

        if (empty($token) || empty($target)) {
            Log::warning('WA Dibatalkan: Token FONNTE_TOKEN atau OWNER_WA_NUMBER belum diatur di .env');
            return false;
        }

        try {
            // withoutVerifying() dan verify => false mematikan verifikasi SSL cURL lokal Windows
            $response = Http::withoutVerifying()
                ->withOptions([
                    'verify' => false,
                    'timeout' => 15,
                ])
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->post('https://api.fonnte.com/send', [
                    'target'      => (string)$target,
                    'message'     => $pesan,
                    'countryCode' => '62',
                ]);

            Log::info('Respon Fonnte: ' . $response->body());

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Gagal mengirim WhatsApp Fonnte: ' . $e->getMessage());
            return false;
        }
    }
}
