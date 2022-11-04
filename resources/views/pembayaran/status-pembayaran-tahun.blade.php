@extends('layouts.backend.app')
@section('title', 'Pembayaran Ipl '.$penghuni->nama_penghuni)
@section('content_title', 'Pembayaran Ipl '.$penghuni->nama_penghuni)
@section('content')
<div class="row">
	<div class="col-lg-6">
    	<div class="callout callout-success">
	        <h5>Info Penghuni:</h5>

	        <p>
	        	Nama Penghuni : <b>{{ $penghuni->nama_penghuni }}</b><br>
		        Nik : <b>{{ $penghuni->nik }}</b><br>
		        Cluster : <b>{{ $penghuni->kelas->nama_kelas }}</b>
	    	</p>
      	</div>
      	<div class="callout callout-danger">
	        <h5>Pemberitahuan!</h5>

	        <p>Garis biru pada list tahun menandakan tahun aktif / tahun sekarang.</p>
      	</div>
  	</div>

  	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">
				<a href="javascript:void(0)" class="btn btn-primary btn-sm">
					<i class="fas fa-circle fa-fw"></i> PILIH TAHUN
				</a>
				<a href="{{ route('pembayaran.status-pembayaran') }}" class="btn btn-danger btn-sm">
					<i class="fas fa-window-close fa-fw"></i> BACK TO LIST
				</a>
			</div>
			<div class="card-body">
				<div class="list-group">
				  @foreach($ipl as $row)
				  	@if($row->tahun == date('Y'))
				  	<a href="{{ route('pembayaran.status-pembayaran.show-status', [$penghuni->nik,$row->tahun]) }}" class="list-group-item list-group-item-action active">
				  		{{ $row->tahun }}
				  	</a>
				  	@else
				  	<a href="{{ route('pembayaran.status-pembayaran.show-status', [$penghuni->nik,$row->tahun]) }}" class="list-group-item list-group-item-action">
				  		{{ $row->tahun }}
				  	</a>
				  	@endif
				  @endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
