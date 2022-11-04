<?php

namespace Database\Seeders;
use App\Models\Penghuni;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $superadmin1 = Penghuni::create([
            'user_id' => 3,
            'kode_penghuni' => 'PHNR'.Str::upper(Str::random(5)),
            'nik' => 11111,
            'nama_penghuni' => 'Penghuni1',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas_id' => 1,
        ]);

        $superadmin1 = Penghuni::create([
            'user_id' => 6,
            'kode_penghuni' => 'PHNR'.Str::upper(Str::random(5)),
            'nik' => 22222,
            'nama_penghuni' => 'Penghuni2',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas_id' => 1,
        ]);

        $superadmin1 = Penghuni::create([
            'user_id' => 7,
            'kode_penghuni' => 'PHNR'.Str::upper(Str::random(5)),
            'nik' => 33333,
            'nama_penghuni' => 'Penghuni3',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas_id' => 1,
        ]);

        $superadmin1 = Penghuni::create([
            'user_id' => 8,
            'kode_penghuni' => 'PHNR'.Str::upper(Str::random(5)),
            'nik' => 44444,
            'nama_penghuni' => 'Penghuni4',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas_id' => 1,
        ]);

        $superadmin1 = Penghuni::create([
            'user_id' => 9,
            'kode_penghuni' => 'PHNR'.Str::upper(Str::random(5)),
            'nik' => 55555,
            'nama_penghuni' => 'Penghuni5',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas_id' => 1,
        ]);







    }
}
