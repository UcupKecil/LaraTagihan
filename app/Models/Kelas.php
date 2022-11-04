<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penghuni;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
    	'nama_kelas',
    	'deskripsi',
    ];

    public function penghuni()
    {
    	return $this->hasMany(Penghuni::class);
    }
}
