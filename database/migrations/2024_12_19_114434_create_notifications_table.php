?<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id'); // Pastikan tipe data sama dengan kolom `id` di tabel `users`
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('data');
            $table->timestamps();

            // Pastikan foreign key sesuai dengan tabel `users`
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
