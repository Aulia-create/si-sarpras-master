@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Rekap Laporan Peminjaman</h1>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ $message }}</strong>
    </div>
  @endif

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <a href="{{ route('admin.laporan.peminjamanall.pdf') }}" class="btn btn-sm btn-primary m-0 font-weight-bold text-light" type="button" target="_blank">Cetak Laporan Peminjaman</a>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 15px">NO</th>
                        <th>Nama User</th>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>                
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($peminjaman as $key => $row)     
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $row->user->name}}</td>
                        <td>{{ $row->barang->nama_barang }}</td>
                        <td>{{ $row->barang->kategori }}</td>
                        <td>{{ $row->pengajuan->tanggal_pengajuan }}</td>
                        <td>{{ $row->tanggal_pengembalian }}</td>
                        <td>{{ ucfirst($row->status) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

@push('script')

@endpush

@endsection
