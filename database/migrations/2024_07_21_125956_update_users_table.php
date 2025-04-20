<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('email', 'username');
            $table->enum('role', ['Admin', 'Petugas', 'Dokter', 'Kasir'])->default('Petugas')->after('password');
            $table->dropColumn('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('username', 'email');
            $table->dropColumn('role', ['Admin', 'Security',])->default('Security');
            $table->dropColumn('id_residential')->nullable();
            $table->dropColumn('access')->default(true);
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
