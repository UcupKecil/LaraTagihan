<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ipl;
use Illuminate\Support\Facades\Validator;
use App\DataTables\IplDataTable;

class IplController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-ipl'])->only(['index', 'show']);
        $this->middleware(['permission:create-ipl'])->only(['create', 'store']);
        $this->middleware(['permission:update-ipl'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-ipl'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, IplDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        return view('admin.ipl.index');
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
            'tahun' => ['required', 'unique:ipl'],
            'nominal' => ['required', 'numeric'],
        ]);

        if ($validator->passes()) {
            Ipl::create($request->all());
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
        $ipl = Ipl::findOrFail($id);
        return response()->json(['data' => $ipl]);
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
            'nominal' => ['required', 'numeric']
        ]);

        if ($validator->passes()) {
            Ipl::findOrFail($id)->update($request->all());
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
        Ipl::findOrFail($id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
