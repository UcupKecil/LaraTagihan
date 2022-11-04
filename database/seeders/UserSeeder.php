<?php

namespace Database\Seeders;
use App\Models\User;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $superadmin1 = User::create([
            'username' => 'arnaf',
            'email' => 'arvinaufal@gmail.com',
            'password' => bcrypt('admin123')
        ]);

        $superadmin2 = User::create([
            'username' => 'pinan',
            'email'=> 'pinandita@gmail.com',
            'password' => bcrypt('admin123')
        ]);

        // $penghuni2 = User::create([
        //     'username' => 'penghuni2',
        //     'email'=> 'penghuni2@gmail.com',
        //     'password' => bcrypt('12345678')
        // ]);

        // $penghuni3 = User::create([
        //     'username' => 'penghuni3',
        //     'email'=> 'penghuni3@gmail.com',
        //     'password' => bcrypt('12345678')
        // ]);

        // $penghuni4 = User::create([
        //     'username' => 'penghuni4',
        //     'email'=> 'penghuni4@gmail.com',
        //     'password' => bcrypt('12345678')
        // ]);

        // $penghuni5 = User::create([
        //     'username' => 'penghuni5',
        //     'email'=> 'penghuni5@gmail.com',
        //     'password' => bcrypt('12345678')
        // ]);

        $superadmin1->assignRole('petugas');
        $superadmin2->assignRole('petugas');
        // $penghuni2->assignRole('penghuni');
        // $penghuni3->assignRole('penghuni');
        // $penghuni4->assignRole('penghuni');
        // $penghuni5->assignRole('penghuni');
    }
}
