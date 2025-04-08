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
        Schema::create('setup', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->string('leader')->nullable();
            $table->string('line')->nullable();
            $table->dateTime('schedule_datetime')->nullable();
            $table->string('part_number')->nullable();
            $table->integer('qty_product')->nullable();
            $table->string('customer')->nullable();
            $table->string('mould_type')->nullable();
            $table->string('mould_category')->nullable();
            $table->string('marking_type')->nullable();
            $table->string('mould_cavity')->nullable();
            $table->string('cable_grip_size')->nullable();
            $table->string('molding_machine')->nullable();
            $table->text('job_request')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('asset_no_bt')->nullable();
            $table->string('maintenance_name')->nullable();
            $table->text('setup_problem')->nullable();
            $table->string('mould_type_mtc')->nullable();
            $table->string('marking_type_mtc')->nullable();
            $table->string('cable_grip_size_mtc')->nullable();
            $table->string('ampere_rating')->nullable();
            $table->string('marking')->nullable();
            $table->string('relief')->nullable();
            $table->string('mismatch')->nullable();
            $table->string('pin_bar_connector')->nullable();
            $table->string('qc_approve')->nullable();
            $table->date('tanggal_submit')->nullable();
            $table->time('jam_submit')->nullable();
            $table->date('tanggal_start')->nullable();
            $table->time('jam_start')->nullable();
            $table->date('tanggal_finish')->nullable();
            $table->time('jam_finish')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setup');
    }
};