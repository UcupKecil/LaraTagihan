<?php

namespace App\DataTables;

use App\Models\Konfirmasi;
use DataTables;

class KonfirmasiDataTable
{
	public function data()
	{
       
		$data = Konfirmasi::with(['penghuni'])->latest();
		return DataTables::of($data)
			->addIndexColumn()
            ->editColumn(
                'cover',
                function($row) {
                    $data = [
                        'cover' => $row->cover
                    ];

                    return view('admin.konfirmasi.img', $data);
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
