<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downtime extends Model
{
    use HasFactory;

    protected $table = 'downtimes';
    
    protected $fillable = [
        'id',
        'user_id',
        'leader',
        'line',
        'badge',
        'raised_operator',
        'raised_ipqc',
        'molding_machine',
        'defect_category',
        'maintenance_repair',
        'problem_defect',        
        'root_cause',
        'action_taken',
        'production_verify',
        'qc_approve',
        'tanggal_submit',
        'jam_submit',
        'tanggal_start',
        'jam_start',        
        'tanggal_finish',
        'jam_finish',
        'status'
    ];

    protected $casts = [
        'tanggal_submit' => 'date',
        'jam_submit' => 'datetime',
        'tanggal_start' => 'date',
        'jam_start' => 'datetime',
        'tanggal_finish' => 'date',
        'jam_finish' => 'datetime'
    ];

    public function getTanggalSubmitFormattedAttribute(): string
    {
        return $this->tanggal_submit 
            ? $this->tanggal_submit->format('d-M-Y') 
            : 'N/A';
    }

    // Accessor for formatted time
    public function getJamSubmitFormattedAttribute(): string
    {
        return $this->jam_submit 
            ? $this->jam_submit->setTimezone(config('app.timezone'))->format('H:i') 
            : 'N/A';
    }

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

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'molding_machine', 'id');
    }

    public function defect()
    {
        return $this->belongsTo(Defect::class, 'defect_category', 'id');
    }

    
}
