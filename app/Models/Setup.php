<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Setup extends Model
{
    use HasFactory;

    protected $table = 'setup';

    // Combine fillable fields from both models
    protected $fillable = [
        // Original Setup fields
        'id',
        'user_id',
        'leader',
        'line',
        'schedule_datetime',
        'part_number',
        'qty_product',
        'customer',
        'mould_type',
        'mould_category',
        'marking_type',
        'mould_cavity',
        'cable_grip_size',
        'molding_machine',
        'job_request',
        'tanggal_submit',
        'jam_submit',
        'tanggal_start',
        'jam_start',
        

        // FinishSetup additional fields
        'issued_date',
        'asset_no_bt',
        'maintenance_name',
        'setup_problem',
        'mould_type_mtc',
        'marking_type_mtc',
        'cable_grip_size_mtc',
        'ampere_rating',

        'marking',
        'relief',
        'mismatch',
        'pin_bar_connector',
        'qc_approve',
        'tanggal_finish',
        'jam_finish',
        'status'
    ];
   
    // Combine cast types
    protected $casts = [
        'schedule_datetime' => 'datetime',
        'issued_date' => 'datetime',
        'qty_product' => 'integer',
        'tanggal_submit' => 'date',
        'jam_submit' => 'datetime',
        'tanggal_start' => 'date',
        'jam_start' => 'datetime',
        'tanggal_finish' => 'date',
        'jam_finish' => 'datetime'
    ];
   
    // Accessor for formatted submit date
    public function getTanggalSubmitFormattedAttribute(): string
    {
        return $this->tanggal_submit
            ? $this->tanggal_submit->format('d-M-Y')
            : 'N/A';
    }
   
    // Accessor for formatted submit time
    public function getJamSubmitFormattedAttribute(): string
    {
        return $this->jam_submit
            ? $this->jam_submit->setTimezone(config('app.timezone'))->format('H:i')
            : 'N/A';
    }
   
    // Accessor for formatted start date
    public function getTanggalStartFormattedAttribute(): string
    {
        return $this->tanggal_start
            ? $this->tanggal_start->format('d-M-Y')
            : 'N/A';
    }

    public function getJamStartFormattedAttribute(): string
    {
        return $this->jam_start
            ? $this->jam_start->format('H:i')
            : 'N/A';
    }

    // New accessor for finish date
    public function getTanggalFinishFormattedAttribute(): string
    {
        return $this->tanggal_finish
            ? $this->tanggal_finish->format('d-M-Y')
            : 'N/A';
    }

    // Accessor for formatted finish time

    public function getJamFinishFormattedAttribute(): string
    {
        return $this->jam_finish
            ? $this->jam_finish->setTimezone(config('app.timezone'))->format('H:i')
            : 'N/A';
    }


    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
   
    // Relationship with Mesin
    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'molding_machine', 'id');
    }
    
   
}