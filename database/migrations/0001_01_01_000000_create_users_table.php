<?php
// database/migrations/xxxx_xx_xx_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('badge')->unique();
            $table->string('nama');
            $table->string('level_user');
            $table->string('email')->unique();
            $table->string('no_tlpn');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'leader', 'teknisi','ipqc'])->default('teknisi');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};