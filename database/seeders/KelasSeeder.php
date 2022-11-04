<?php

namespace Database\Seeders;
use App\Models\Kelas;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $superadmin1 = Kelas::create([
            'nama_kelas' => 'Amanda',
            'deskripsi' => 'Amanda',
        ]);

        $superadmin1 = Kelas::create([
            'nama_kelas' => 'Chintya',
            'deskripsi' => 'Chintya',
        ]);

        $superadmin1 = Kelas::create([
            'nama_kelas' => 'Dayana',
            'deskripsi' => 'Dayana',
        ]);

        $superadmin1 = Kelas::create([
            'nama_kelas' => 'Btary',
            'deskripsi' => 'Btary',
        ]);

        $superadmin1 = Kelas::create([
            'nama_kelas' => 'Emily',
            'deskripsi' => 'Emily',
        ]);

        $superadmin1 = Kelas::create([
            'nama_kelas' => 'Flora',
            'deskripsi' => 'Flora',
        ]);









    }
}
