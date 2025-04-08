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
        Schema::create('downtimes', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->string('leader')->nullable();
            $table->string('line')->nullable();
            $table->unsignedInteger('badge')->nullable();
            $table->string('raised_operator')->nullable();
            $table->string('raised_ipqc')->nullable();
            $table->string('molding_machine')->nullable();   
            $table->string('defect_category')->nullable();
            $table->text('problem_defect')->nullable();
            $table->string('root_cause')->nullable();
            $table->string('action_taken')->nullable();
            $table->string('maintenance_repair')->nullable();
            $table->string('production_verify')->nullable();
            $table->string('qc_approve')->nullable();
            $table->date('tanggal_submit')->nullable();
            $table->time('jam_submit')->nullable();
            
            // New columns for start and finish
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
        Schema::dropIfExists('downtimes');
    }
};  