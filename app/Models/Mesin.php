<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory;
    protected $table = 'mesin';
    protected $fillable = [
        'id',
        'molding_mc'];
    public $timestamps = false;
    protected static function boot()
{
    parent::boot();
    static::addGlobalScope('order', function ($query) {
        $query->orderBy('id', 'asc');
    });
}
}