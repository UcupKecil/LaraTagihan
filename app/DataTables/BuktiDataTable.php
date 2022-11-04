<?php

namespace App\DataTables;

use App\Models\Bukti;
use App\Models\Penghuni;
use DataTables;
use Illuminate\Support\Facades\DB;

class BuktiDataTable
{
	public function data()
	{

        $id = auth()->user()->id;
        $penghuni = Penghuni::where('user_id', $id)->first();
       


		$data = Bukti::with(['penghuni'])
        ->where('penghuni_id', $penghuni->id)
        ->latest();
		return DataTables::of($data)
			->addIndexColumn()
            ->editColumn(
                'cover',
                function($row) {
                    $data = [
                        'cover' => $row->cover
                    ];

                    return view('penghuni.konfirmasi.img', $data);
                }
            )
            ->addColumn('action', function($row) {
                $btn = '<div class="row"><a href="javascript:void(0)" id="'.$row->id.
                        '" class="btn btn-primary btn-sm ml-2 btn-edit">Edit</a>';
                $btn .= '<a href="javascript:void(0)" id="'.$row->id.
                        '" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	}
}
