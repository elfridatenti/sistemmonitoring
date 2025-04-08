<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    
        use HasFactory;
        protected $table = 'defects';
        protected $fillable = [
            'id',
            'defect_category'];
        public $timestamps = false;

      
    
}
