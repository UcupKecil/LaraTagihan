<?php

namespace App\Imports;

use App\Models\Pembayaran;
use Maatwebsite\Excel\Concerns\ToModel;

class PembayaranImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pembayaran([
            'kode_pembayaran'     => $row[1],
            'petugas_id'    => $row[2],
            'penghuni_id'    => $row[3],
            'nik'    => $row[4],
            'tanggal_bayar'    => $row[5],
            'bulan_bayar'    => $row[6],
            'tahun_bayar'    => $row[7],
            'jumlah_bayar'    => $row[8],


            //
        ]);
    }
}
