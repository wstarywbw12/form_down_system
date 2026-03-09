<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // tambah kolom role
            $table->enum('role', ['user', 'admin'])->default('user')->after('password');

            // ubah email menjadi nullable
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // hapus role
            $table->dropColumn('role');

            // kembalikan email tidak nullable
            $table->string('email')->nullable(false)->change();
        });
    }
};