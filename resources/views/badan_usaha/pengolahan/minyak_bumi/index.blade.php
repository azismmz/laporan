@extends('layouts.frontand.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengolahan Minyak Bumi/Hasil Olahan</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pengolahan</a></li>
                                <li class="breadcrumb-item active"> Minyak Bumi/Hasil Olahan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Produksi Kilang</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#buat-pengolahan-produksi-mb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelPengolahanMBProduksi">Import
                                        Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengolahan.minyak_bumi.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanProduksiMB as $ppmb)
                                            @php
                                                $id = Crypt::encryptString($ppmb->bulan . ',' . $ppmb->badan_usaha_id);
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <b><a
                                                            href="/pengolahan-minyak-bumi-hasil-olah/show/{{ $id }}/produksi">{{ dateIndonesia($ppmb->bulan) }}
                                                            <i class="bx bx-check" title="lihat data laporan"></i></a>
                                                    </b>
                                                </td>
                                                <td>
                                                    @if ($ppmb->status_tertinggi == 1 && $ppmb->catatanx)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($ppmb->status_tertinggi == 1)
                                                        <span class="badge bg-success">Kirim</span>
                                                    @elseif ($ppmb->status_tertinggi == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($ppmb->status_tertinggi == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form
                                                        action="/hapus_bulan_pengolahan_minyak_bumi_produksi/{{ $ppmb->bulan }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="hapusData($(this).closest('form'))"
                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                            <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="/submit_bulan_pengolahan_minyak_bumi_produksi/{{ $ppmb->bulan }}"
                                                        method="post" class="d-inline" data-id="{{ $ppmb->bulan }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="kirimData($(this).closest('form'))"
                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                            <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                        </button>
                                                    </form>
                                                    @if ($ppmb->status_tertinggi != 1)
                                                        <a href="/pengolahan-minyak-bumi-hasil-olah/show/{{ $id }}/produksi"
                                                            class="btn btn-sm btn-info">
                                                            <i class="bx bx-edit" title="Revisi"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pengolahan Minyak Bumi Produksi Kilang --}}

            {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Pasokan Kilang</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="intake_kilang(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#buat-pengolahan-pasokan-mb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelPengolahanMBPasokan">Import
                                        Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengolahan.minyak_bumi.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanPasokanMB as $ppmb)
                                            @php
                                                $id = Crypt::encryptString($ppmb->bulan . ',' . $ppmb->badan_usaha_id);
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <b><a
                                                            href="/pengolahan-minyak-bumi-hasil-olah/show/{{ $id }}/pasokan">{{ dateIndonesia($ppmb->bulan) }}
                                                            <i class="bx bx-check" title="lihat data laporan"></i></a>
                                                    </b>
                                                </td>
                                                <td>
                                                    @if ($ppmb->status_tertinggi == 1 && $ppmb->catatanx)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($ppmb->status_tertinggi == 1)
                                                        <span class="badge bg-success">Kirim</span>
                                                    @elseif ($ppmb->status_tertinggi == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($ppmb->status_tertinggi == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form
                                                        action="/hapus_bulan_pengolahan_minyak_bumi_pasokan/{{ $ppmb->bulan }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="hapusData($(this).closest('form'))"
                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                            <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="/submit_bulan_pengolahan_minyak_bumi_pasokan/{{ $ppmb->bulan }}"
                                                        method="post" class="d-inline" data-id="{{ $ppmb->bulan }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="kirimData($(this).closest('form'))"
                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                            <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                        </button>
                                                    </form>
                                                    @if ($ppmb->status_tertinggi != 1)
                                                        <a href="/pengolahan-minyak-bumi-hasil-olah/show/{{ $id }}/pasokan"
                                                            class="btn btn-sm btn-info">
                                                            <i class="bx bx-edit" title="Revisi"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pengolahan Minyak Bumi Pasokan Kilang --}}

            {{-- Pengolahan Minyak Bumi Distribusi Kilang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Distribusi/Penjualan Domestik Kilang</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#buat-pengolahan-distribusi-mb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelPengolahanMBDistribusi">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengolahan.minyak_bumi.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanDistribusiMB as $ppmb)
                                            @php
                                                $id = Crypt::encryptString($ppmb->bulan . ',' . $ppmb->badan_usaha_id);
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <b>
                                                        <a
                                                            href="/pengolahan-minyak-bumi-hasil-olah/show/{{ $id }}/distribusi">{{ dateIndonesia($ppmb->bulan) }}
                                                            <i class="bx bx-check" title="lihat data laporan"></i>
                                                        </a>
                                                    </b>
                                                </td>
                                                <td>
                                                    @if ($ppmb->status_tertinggi == 1 && $ppmb->catatanx)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($ppmb->status_tertinggi == 1)
                                                        <span class="badge bg-success">Kirim</span>
                                                    @elseif ($ppmb->status_tertinggi == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($ppmb->status_tertinggi == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form
                                                        action="/hapus_bulan_pengolahan_minyak_bumi_distribusi/{{ $ppmb->bulan }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="hapusData($(this).closest('form'))"
                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                            <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="/submit_bulan_pengolahan_minyak_bumi_distribusi/{{ $ppmb->bulan }}"
                                                        method="post" class="d-inline" data-id="{{ $ppmb->bulan }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="kirimData($(this).closest('form'))"
                                                            {{ $ppmb->status_tertinggi == 1 ? 'disabled' : '' }}>
                                                            <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                        </button>
                                                    </form>
                                                    @if ($ppmb->status_tertinggi != 1)
                                                        <a href="/pengolahan-minyak-bumi-hasil-olah/show/{{ $id }}/distribusi"
                                                            class="btn btn-sm btn-info">
                                                            <i class="bx bx-edit" title="Revisi"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pengolahan Minyak Bumi Produksi Kilang --}}
        </div>
    </div>
@endsection
