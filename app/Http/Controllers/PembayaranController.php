<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penghuni;
use App\Models\Ipl;
use App\Models\Bill;
use App\Models\Petugas;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Validator;
use App\Helpers\Bulan;
use PDF;
use DataTables;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Penghuni::with(['kelas'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="row"><a href="'.route('pembayaran.bayar', $row->nik).'"class="btn btn-primary btn-sm ml-2">
                    <i class="fas fa-money-check"></i> BAYAR
                    </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    	return view('pembayaran.index');
    }

    public function bayar($nik)
    {
    	$penghuni = Penghuni::with(['kelas'])
            ->where('nik', $nik)
            ->first();

        $ipl = Ipl::all();

    	return view('pembayaran.bayar', compact('penghuni', 'ipl'));
    }

    public function ipl($tahun)
    {
        $ipl = Ipl::where('tahun', $tahun)
            ->first();

        return response()->json([
            'data' => $ipl,
            'nominal_rupiah' => 'Rp '.number_format($ipl->nominal, 0, 2, '.'),
        ]);
    }

    public function prosesBayar(Request $request, $nik)
    {
        $request->validate([
            'jumlah_bayar' => 'required',
        ],[
            'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong!'
        ]);

		$petugas = Petugas::where('user_id', Auth::user()->id)
            ->first();

        $pembayaran = Pembayaran::whereIn('bulan_bayar', $request->bulan_bayar)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->where('penghuni_id', $request->penghuni_id)
            ->pluck('bulan_bayar')
            ->toArray();

        if (!$pembayaran) {
            DB::transaction(function() use($request, $petugas) {
                foreach ($request->bulan_bayar as $bulan) {
                    Pembayaran::create([
                        'kode_pembayaran' => 'SMRC'.Str::upper(Str::random(5)),
                        'petugas_id' => $petugas->id,
                        'penghuni_id' => $request->penghuni_id,
                        'nik' => $request->nik,
                        'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                        'tahun_bayar' => $request->tahun_bayar,
                        'bulan_bayar' => $bulan,
                        'jumlah_bayar' => $request->jumlah_bayar,
                    ]);

                    Bill::where('bulan_bill', $bulan)->where('penghuni_id', $request->penghuni_id)->update([
                        'status'  => 'LUNAS',

                        'updated_at' => date('Y-m-d H:i:s')
                    ]);


                }
            });

            return redirect()->route('pembayaran.history-pembayaran')
                ->with('success', 'Pembayaran berhasil disimpan!');
        }else{
            return back()
                ->with('error', 'Penghuni Dengan Nama : '.$request->nama_penghuni.' , NIK : '.
                $request->nik.' Sudah Membayar Ipl di bulan yang diinput  , di Tahun : '.$request->tahun_bayar.' , Pembayaran Dibatalkan');
        }
    }

    public function statusPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Penghuni::with(['kelas'])
                ->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="row"><a href="'.route('pembayaran.status-pembayaran.show',$row->nik).
                    '"class="btn btn-primary btn-sm">DETAIL</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pembayaran.status-pembayaran');
    }

    public function statusPembayaranShow(Penghuni $penghuni)
    {
        $ipl = Ipl::all();
        return view('pembayaran.status-pembayaran-tahun', compact('penghuni', 'ipl'));
    }

    public function statusPembayaranShowStatus($nik, $tahun)
    {
        $penghuni = Penghuni::where('nik', $nik)
            ->first();

        $ipl = Ipl::where('tahun', $tahun)
            ->first();

        $pembayaran = Pembayaran::with(['penghuni'])
            ->where('penghuni_id', $penghuni->id)
            ->where('tahun_bayar', $ipl->tahun)
            ->get();

        return view('pembayaran.status-pembayaran-show', compact('penghuni', 'ipl', 'pembayaran'));
    }

    public function historyPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Pembayaran::with(['petugas', 'penghuni' => function($query){
                $query->with('kelas');
            }])
                ->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="row"><a href="'.route('pembayaran.history-pembayaran.print',$row->id).'"class="btn btn-danger btn-sm ml-2" target="_blank">
                    <i class="fas fa-print fa-fw"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    	return view('pembayaran.history-pembayaran');
    }

    public function printHistoryPembayaran($id)
    {
        $data['pembayaran'] = Pembayaran::with(['petugas', 'penghuni'])
            ->where('id', $id)
            ->first();

        $pdf = PDF::loadView('pembayaran.history-pembayaran-preview',$data);
        return $pdf->stream();
    }

    public function laporan()
    {
        return view('pembayaran.laporan');
    }

    public function printPdf(Request $request)
    {
        $tanggal = $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $data['pembayaran'] = Pembayaran::with(['petugas', 'penghuni'])
            ->whereBetween('tanggal_bayar', $tanggal)->get();

        if ($data['pembayaran']->count() > 0) {
            $pdf = PDF::loadView('pembayaran.laporan-preview', $data);
            return $pdf->download('pembayaran-ipl-'.
            Carbon::parse($request->tanggal_mulai)->format('d-m-Y').'-'.
            Carbon::parse($request->tanggal_selesai)->format('d-m-Y').
            Str::random(9).'.pdf');
        }else{
            return back()->with('error', 'Data pembayaran ipl tanggal '.
                Carbon::parse($request->tanggal_mulai)->format('d-m-Y').' sampai dengan '.
                Carbon::parse($request->tanggal_selesai)->format('d-m-Y').' Tidak Tersedia');
        }
    }
}
