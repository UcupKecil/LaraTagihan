<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penghuni;

class Bukti extends Model
{
    use HasFactory;
    protected $table = 'konfirmasi';

    protected $fillable = [
    	'cover',
    	'deskripsi',
        'penghuni_id',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}
