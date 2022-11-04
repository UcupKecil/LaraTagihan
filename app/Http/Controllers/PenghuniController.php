<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Models\Ipl;
use App\Models\Konfirmasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\DataTables\BuktiDataTable;
use DataTables;
use PDF;

class PenghuniController extends Controller
{
    public function pembayaranIpl()
    {
        $ipl = Ipl::all();

        return view('penghuni.pembayaran-ipl', compact('ipl'));
    }


    public function konfirmasiBayar()
    {
        $ipl = Ipl::all();

        return view('penghuni.konfirmasi-bayar', compact('konfirmasi'));
    }


    public function pembayaranIplShow(Ipl $ipl)
    {
        $penghuni = Penghuni::where('user_id', Auth::user()->id)
            ->first();

        $pembayaran = Pembayaran::with(['petugas', 'penghuni'])
            ->where('penghuni_id', $penghuni->id)
            ->where('tahun_bayar', $ipl->tahun)
            ->oldest()
            ->get();

        return view('penghuni.pembayaran-ipl-show', compact('pembayaran', 'penghuni', 'ipl'));
    }

    public function historyPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $penghuni = Penghuni::where('user_id', Auth::user()->id)
                ->first();

            $data = Pembayaran::with(['petugas', 'penghuni' => function($query) {
                $query->with(['kelas']);
            }])
                ->where('penghuni_id', $penghuni->id)
                ->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="row"><a href="'.route('penghuni.history-pembayaran.preview', $row->id).'"class="btn btn-danger btn-sm ml-2" target="_blank">
                    <i class="fas fa-print fa-fw"></i>
                    </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    	return view('penghuni.history-pembayaran');
    }

    public function previewHistoryPembayaran($id)
    {
        $data['penghuni'] = Penghuni::where('user_id', Auth::user()->id)
            ->first();

        $data['pembayaran'] = Pembayaran::with(['petugas', 'penghuni'])
            ->where('id', $id)
            ->where('penghuni_id', $data['penghuni']->id)
            ->first();

        $pdf = PDF::loadView('penghuni.history-pembayaran-preview',$data);
        return $pdf->stream();
    }

    public function laporanPembayaran()
    {
        $ipl = Ipl::all();
        return view('penghuni.laporan', compact('ipl'));
    }

    public function printPdf(Request $request)
    {
        $penghuni = Penghuni::where('user_id', Auth::user()->id)
            ->first();

        $data['pembayaran'] = Pembayaran::with(['petugas', 'penghuni'])
            ->where('penghuni_id', $penghuni->id)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->get();

        $data['data_penghuni'] = $penghuni;

        if ($data['pembayaran']->count() > 0) {
            $pdf = PDF::loadView('penghuni.laporan-preview', $data);
            return $pdf->download('pembayaran-ipl-'.$penghuni->nama_penghuni.'-'.
                $penghuni->nik.'-'.
                $request->tahun_bayar.'-'.
                Str::random(9).'.pdf');
        }else{
            return back()->with('error', 'Data Pembayaran Ipl Anda Tahun '.$request->tahun_bayar.' tidak tersedia');
        }
    }
}
