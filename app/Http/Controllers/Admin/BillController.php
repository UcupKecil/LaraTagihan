<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\DataTables\BillDataTable;
use App\Exports\BillExport;
use App\Imports\BillImport;
use Maatwebsite\Excel\Facades\Excel;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BillDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        return view('admin.bill.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bill::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Data permbayaran berhasil dihapus!',
            'status' => 'OK',
        ]);
    }

    public function exportbill()
    {
        return Excel::download(new BillExport, 'bill.xlsx');
    }

    public function importbill()
    {
        Excel::import(new BillImport,request()->file('file'));

        return back();
    }
}
