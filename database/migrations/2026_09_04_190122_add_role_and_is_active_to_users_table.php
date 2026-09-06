<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ubah kolom role menjadi VARCHAR(50) agar bisa menampung 'owner', 'kasir', dll.
        if (Schema::hasColumn('users', 'role')) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'kasir'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('kasir')->after('email');
            });
        }

        // 2. Tambah kolom is_active jika belum ada
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('role');
            });
        }

        // 3. Set user ID 1 sebagai owner dan aktif
        DB::table('users')->where('id', 1)->update([
            'role' => 'owner',
            'is_active' => true
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
