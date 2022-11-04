<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Bill;
use App\Models\Penghuni;
use App\Models\Ipl;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PenghuniDataTable;
use App\Exports\PenghuniExport;
use App\Imports\PenghuniImport;
use Maatwebsite\Excel\Facades\Excel;

class PenghuniController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-penghuni'])->only(['index', 'show']);
        $this->middleware(['permission:create-penghuni'])->only(['create', 'store']);
        $this->middleware(['permission:update-penghuni'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-penghuni'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PenghuniDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        $penghuni = Penghuni::all();
        $ipl = Ipl::all();
        $kelas = Kelas::all();

        return view('admin.penghuni.index', compact('penghuni', 'ipl', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penghuni' => 'required',
            'username' => 'required|unique:users',
            'nik' => 'required|unique:penghuni',

            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);

        if ($validator->passes()) {
            DB::transaction(function() use($request){
                $user = User::create([
                    'username' => Str::lower($request->username),
                    'password' => Hash::make('12345678'),
                ]);

                $user->assignRole('penghuni');

                $id=Penghuni::insertGetId([
                    'user_id' => $user->id,
                    'kode_penghuni' => 'PHNS'.Str::upper(Str::random(5)),
                    'nik' => $request->nik,
                    'nama_penghuni' => $request->nama_penghuni,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                    'kelas_id' => $request->kelas_id,
                ]);

                $ipl = Ipl::where('tahun', '2022')
                ->first();



                    foreach (['Januari','Februari','Maret','April','Mei',
                    'Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan) {

                        Bill::insert([

                            'kode_bill' => 'BILL'.Str::upper(Str::random(5)),
                            'penghuni_id' => $id,
                            'nik' => $request->nik,
                            'tanggal_bill' => Carbon::now('Asia/Jakarta'),
                            'tahun_bill' => $ipl->tahun,
                            'bulan_bill' => $bulan,
                            'jumlah_bill' => $ipl->nominal,
                            'status' => 'BELUM BAYAR',
                        ]);
                    }

            });

            return response()->json(['message' => 'Data berhasil disimpan!']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penghuni = Penghuni::with(['kelas', 'ipl'])->findOrFail($id);
        return response()->json(['data' => $penghuni]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_penghuni' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);

        if ($validator->passes()) {
            Penghuni::findOrFail($id)->update([
                'nama_penghuni' => $request->nama_penghuni,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'kelas_id' => $request->kelas_id,
            ]);

            return response()->json(['message' => 'Data berhasil diupdate!']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        User::findOrFail($penghuni->user_id)->delete();
        $penghuni->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }

    public function exportpenghuni()
    {
        return Excel::download(new PenghuniExport, 'penghuni.xlsx');
    }

    public function importpenghuni()
    {
        Excel::import(new PenghuniImport,request()->file('file'));

        return back();
    }
}
