<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penghuni;

class Ipl extends Model
{
    use HasFactory;

    protected $table = 'ipl';

    protected $fillable = [
    	'tahun',
    	'nominal',
    ];

    public function penghuni()
    {
    	return $this->hasMany(Penghuni::class);
    }
}
