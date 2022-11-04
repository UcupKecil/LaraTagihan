@extends('layouts.backend.app')
@section('title', 'Data Bill')
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Sweetalert 2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.css">
@endpush
@section('content_title', 'Data Bill')
@section('content')
<x-alert></x-alert>
<div class="row">
  <div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('importbill') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import Bill</button>
                <a class="btn btn-warning" href="{{ route('exportbill') }}">Export Bill</a>
            </form>
        </div>
      <div class="card-header">
        <a href="{{ route('bill.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i> Tambah Bill</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="dataTable2" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Nama Penghuni</th>
            <th>Nik</th>
            <th>Cluster Penghuni</th>
            <th>Tanggal Bayar</th>

            <th>Untuk Bulan</th>
            <th>Untuk Tahun</th>
            <th>Jumlah Bill</th>
            <th>Status</th>

            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@stop

@push('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Sweetalert 2 -->
<script type="text/javascript" src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
 $(function () {

  var table = $("#dataTable2").DataTable({
      processing: true,
      serverSide: true,
      "responsive": true,
      ajax: "{{ route('bill-ipl.index') }}",
      columns: [
          {data: 'DT_RowIndex' , name: 'id'},

          {data: 'penghuni.nama_penghuni', name: 'penghuni.nama_penghuni'},
          {data: 'nik', name: 'nik'},
          {data: 'penghuni.kelas.nama_kelas', name: 'penghuni.kelas.nama_kelas'},
          {data: 'tanggal_bill', name: 'tanggal_bill'},
          {data: 'bulan_bill', name: 'bulan_bill'},
          {data: 'tahun_bill', name: 'tahun_bill'},
          {data: 'jumlah_bill', name: 'jumlah_bill'},
          {data: 'status', name: 'status'},



          {data: 'action', name: 'action', orderable: false, searchable: true},
      ]
  });

});

// delete
$("body").on('click', '.btn-delete', function() {
  var id = $(this).attr("id")

  Swal.fire({
    title: 'Yakin hapus data ini?',
    // text: "You won't be able to revert",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/admin/bill-ipl/"+id,
        method: "DELETE",
        success: function(response) {
          $('#dataTable2').DataTable().ajax.reload()
          Swal.fire(
            '',
            response.message,
            'success'
          )
        }
      })
    }
  })
})
</script>
@endpush
