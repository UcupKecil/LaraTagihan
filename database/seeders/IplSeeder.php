<?php

namespace Database\Seeders;
use App\Models\Ipl;



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IplSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $superadmin1 = Ipl::create([
            'tahun' => 2022,
            'nominal' => 500000,
        ]);













    }
}
