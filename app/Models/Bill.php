<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;
use App\Models\Penghuni;
use Carbon\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bill';

    protected $fillable = [
    	'kode_bill',
        'penghuni_id',
    	'nik',
    	'tanggal_bill',
    	'bulan_bill',
    	'tahun_bill',
    	'jumlah_bill',
    ];

    public function getTanggalBayarAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getJumlahBayarAttribute($value)
    {
        return "Rp ".number_format($value, 0, 2, '.');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}
