<!DOCTYPE html>
<html>
<head>
    <title>GENERATE PDF</title>
</head>
<body>
<br><br>
<center>
  <h2 style="font-family: sans-serif;">Laporan Pembayaran IPL</h2>
</center>
<br>
<b>Dari tanggal {{ \Carbon\Carbon::parse(request()->tanggal_mulai)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse(request()->tanggal_selesai)->format('d-m-Y') }}</b><br><br>
<table style="" border="1" cellspacing="0" cellpadding="10" width="100%">
  <thead>
    <tr>
      <th scope="col" style="font-family: sans-serif;">No</th>
      <th scope="col" style="font-family: sans-serif;">Nama Penghuni</th>
      <th scope="col" style="font-family: sans-serif;">Nik</th>
      <th scope="col" style="font-family: sans-serif;">Cluster</th>
      <th scope="col" style="font-family: sans-serif;">Tanggal Bayar</th>
      <th scope="col" style="font-family: sans-serif;">Petugas</th>
      <th scope="col" style="font-family: sans-serif;">Jumlah Bayar</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pembayaran as $row)
    <tr>
      <th scope="row" style="font-family: sans-serif;">{{ $loop->iteration }}</th>
      <td style="font-family: sans-serif;">{{ $row->penghuni->nama_penghuni }}</td>
      <td style="font-family: sans-serif;">{{ $row->nik }}</td>
      <td style="font-family: sans-serif;">{{ $row->penghuni->kelas->nama_kelas }}</td>
      <td style="font-family: sans-serif;">
        {{ \Carbon\Carbon::parse($row->tanggal_bayar)->format('d-m-Y') }}
      </td>
      <td style="font-family: sans-serif;">{{ $row->petugas->nama_petugas }}</td>
      <td style="font-family: sans-serif;">{{ $row->jumlah_bayar }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>
