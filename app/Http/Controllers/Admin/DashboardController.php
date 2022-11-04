<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $penghuni_laki_laki = DB::table('penghuni')->where('jenis_kelamin', 'Laki-laki')->count();
        $penghuni_perempuan = DB::table('penghuni')->where('jenis_kelamin', 'Perempuan')->count();

    	return view('admin.dashboard', [
    		'total_penghuni' => DB::table('penghuni')->count(),
    		'total_kelas' => DB::table('kelas')->count(),
    		'total_admin' => DB::table('model_has_roles')->where('role_id', 1)->count(),
    		'total_petugas' => DB::table('petugas')->count(),
            'penghuni_laki_laki' => $penghuni_laki_laki,
            'penghuni_perempuan' => $penghuni_perempuan,
    	]);
    }
}
