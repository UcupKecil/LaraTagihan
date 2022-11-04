<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bukti;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Validator;
use App\DataTables\BuktiDataTable;


class BuktiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-konfirmasi'])->only(['index', 'show']);
        $this->middleware(['permission:create-konfirmasi'])->only(['create', 'store']);
        $this->middleware(['permission:update-konfirmasi'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-konfirmasi'])->only(['destroy']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BuktiDataTable $datatable)
    {
        $penghuni = Penghuni::where('user_id', $request->user()->id)
            ->first();






        if ($request->ajax()) {
            return $datatable->data();
        }

        //$konfirmasi = Bukti::with(['penghuni'])->findOrFail($penghuni->id);


        $konfirmasi = Bukti::all();
        

        return view('penghuni.konfirmasi.index', compact('konfirmasi', 'penghuni'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penghuni = Penghuni::where('user_id', $request->user()->id)
            ->first();
            //dd($penghuni->id);


        $extension = $request->file('cover')->getClientOriginalExtension();
        $cover = date('YmdHis').'.'.$extension;
        $path = base_path('public/photo_konfirmasi');
        $request->file('cover')->move($path, $cover);

        //dd($cover);

        $validator = Validator::make($request->all(), [
            // 'cover' => 'required',
             'deskripsi' => 'required',
             //'penghuni_id' => 'required',
        ],[


            'deskripsi.required' => 'deskripsi tidak boleh kosong!',
            //'penghuni_id.required' => 'penghuni tidak boleh kosong!',
        ]);


        if ($validator->passes()) {
            Bukti::create([
                'deskripsi' =>$request->deskripsi,
                'cover' => $cover,
                'penghuni_id' => $penghuni->id,


                //'penghuni_id' => $request->penghuni_id,
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
        $konfirmasi = Bukti::with(['penghuni'])->findOrFail($id);

        return response()->json(['data' => $konfirmasi]);


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
            Bukti::findOrFail($id)->update
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
        Bukti::findOrFail($id)->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }

    public function exportkonfirmasi()
    {
        return Excel::download(new BuktiExport, 'kategori.xlsx');
    }

    public function importkonfirmasi()
    {
        Excel::import(new BuktiImport,request()->file('file'));

        return back();
    }
}
