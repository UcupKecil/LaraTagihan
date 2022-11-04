<?php

namespace Database\Seeders;
use App\Models\Petugas;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $superadmin1 = Petugas::create([
            'user_id' => 1,
            'kode_petugas' => 'PTGR'.Str::upper(Str::random(5)),
            'nama_petugas' => 'Admin',
            'jenis_kelamin' => 'Laki-Laki',
        ]);

        $superadmin2 = Petugas::create([
            'user_id' => 2,
            'kode_petugas' => 'PTGR'.Str::upper(Str::random(5)),
            'nama_petugas' => 'Petugas',
            'jenis_kelamin' => 'Laki-Laki',
        ]);



        $superadmin3 = Petugas::create([
            'user_id' => 3,
            'kode_petugas' => 'PTGR'.Str::upper(Str::random(5)),
            'nama_petugas' => 'Arnaf',
            'jenis_kelamin' => 'Laki-Laki',
        ]);

        $superadmin4 = Petugas::create([
            'user_id' => 4,
            'kode_petugas' => 'PTGR'.Str::upper(Str::random(5)),
            'nama_petugas' => 'Pinan',
            'jenis_kelamin' => 'Laki-Laki',
        ]);




    }
}
