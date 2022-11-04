<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Kelas;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            IndexSeeder::class,
            UserSeeder::class,
            PetugasSeeder::class,
            KelasSeeder::class,
            //PenghuniSeeder::class,
            IplSeeder::class,
        ]);

    }
}
