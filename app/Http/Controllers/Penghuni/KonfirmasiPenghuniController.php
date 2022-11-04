<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konfirmasi;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Validator;
use App\DataTables\KonfirmasiPenghuniDataTable;


class KonfirmasiPenghuniController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-konfirmasipenghuni'])->only(['index', 'show']);
        $this->middleware(['permission:create-konfirmasipenghuni'])->only(['create', 'store']);
        $this->middleware(['permission:update-konfirmasipenghuni'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-konfirmasipenghuni'])->only(['destroy']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, KonfirmasiPenghuniDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }
        $konfirmasipenghuni = Konfirmasi::all();
        $penghuni = Penghuni::all();

        //return view('penghuni.konfirmasipenghuni.index');
        return view('penghuni.konfirmasipenghuni.index', compact('konfirmasipenghuni', 'penghuni'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $extension = $request->file('cover')->getClientOriginalExtension();
        $cover = date('YmdHis').'.'.$extension;
        $path = base_path('public/photo_konfirmasipenghuni');
        $request->file('cover')->move($path, $cover);

        //dd($cover);

        $validator = Validator::make($request->all(), [
            // 'cover' => 'required',
             'deskripsi' => 'required',
             'penghuni_id' => 'required',
        ],[


            'deskripsi.required' => 'deskripsi tidak boleh kosong!',
            'penghuni_id.required' => 'penghuni tidak boleh kosong!',
        ]);

        if ($validator->passes()) {
            Konfirmasi::create([
                'deskripsi' =>$request->deskripsi,
                'cover' => $cover,
                'penghuni_id' => $request->penghuni_id,
                        ]);

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
        $konfirmasipenghuni = Konfirmasi::with(['penghuni'])->findOrFail($id);

        return response()->json(['data' => $konfirmasipenghuni]);


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
            'penghuni_id' => 'required',
            'deskripsi' => 'required',
        ],[
            'penghuni_id.required' => 'penghuni tidak boleh kosong!',
            'deskripsi.required' => 'deskripsi tidak boleh kosong!',
        ]);

        if ($validator->passes()) {
            Konfirmasi::findOrFail($id)->update
            ([
                'deskripsi' =>$request->deskripsi,
                'penghuni_id' => $request->penghuni_id,
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
        Konfirmasi::findOrFail($id)->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }

    public function exportkonfirmasipenghuni()
    {
        return Excel::download(new KonfirmasiPenghuniExport, 'kategori.xlsx');
    }

    public function importkonfirmasipenghuni()
    {
        Excel::import(new KonfirmasiPenghuniImport,request()->file('file'));

        return back();
    }
}
