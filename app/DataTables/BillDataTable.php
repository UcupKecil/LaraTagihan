<?php

namespace App\DataTables;

use App\Models\Bill;
use DataTables;

class BillDataTable
{
	public function data()
	{
        //$data = Bill::with(['penghuni','kelas'])->latest();

        $data = Bill::with(['penghuni' => function($query){
            $query->with('kelas');
        }, ])->latest();
		return DataTables::of($data)
			->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="row"><a href="javascript:void(0)" id="'.$row->id.
                        '" class="btn btn-danger btn-sm ml-2 btn-delete">
                        <i class="fas fa-trash fa-fw"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
	}
}
