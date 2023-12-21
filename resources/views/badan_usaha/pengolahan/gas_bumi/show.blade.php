@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengolahan Gas Bumi</h4>
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
                                        data-bs-target="#buat-pengolahan-produksi-gb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengolahan.gas_bumi.modal')
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
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanProduksiGB as $ppgb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('F Y', strtotime($ppgb->bulan)) }}</td>
                                                <td>{{ $ppgb->produk }}</td>
                                                <td>{{ $ppgb->provinsi }}</td>
                                                <td>{{ $ppgb->kabupaten_kota }}</td>
                                                <td>{{ $ppgb->volume }}</td>
                                                <td>{{ $ppgb->satuan }}</td>
                                                <td>
                                                    @if ($ppgb->status == '0' || $ppgb->status == '' || $ppgb->status == '-')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-produksi-gb"
                                                                onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-produksi-gb"
                                                                data-id="{{ $ppgb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/hapus_pengolahan_gas_bumi_produksi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="/submit_pengolahan_gas_bumi_produksi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ppgb->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppgb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-produksi-gb"
                                                                data-id="{{ $ppgb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($ppgb->status == '2')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-produksi-gb"
                                                                onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-produksi-gb"
                                                                data-id="{{ $ppgb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/submit_pengolahan_gas_bumi_produksi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif

                                                    <center>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $ppgb->id }}">
                                                                Cek Revisi
                                                            </span>
                                                        @endif
                                                    </center>
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
                                        data-bs-target="#buat-pengolahan-pasokan-gb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengolahan.gas_bumi.modal')
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
                                            <th>Intake Kilang</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanPasokanGB as $ppgb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('F Y', strtotime($ppgb->bulan)) }}</td>
                                                <td>{{ $ppgb->intake_kilang }}</td>
                                                <td>{{ $ppgb->provinsi }}</td>
                                                <td>{{ $ppgb->kabupaten_kota }}</td>
                                                <td>{{ $ppgb->volume }}</td>
                                                <td>{{ $ppgb->satuan }}</td>
                                                <td>
                                                    @if ($ppgb->status == '0' || $ppgb->status == '' || $ppgb->status == '-')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-pasokan-gb"
                                                                onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->intake_kilang }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-pasokan-gb"
                                                                data-id="{{ $ppgb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/hapus_pengolahan_gas_bumi_pasokan/{{ $ppgb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="/submit_pengolahan_gas_bumi_pasokan/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ppgb->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppgb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-pasokan-gb"
                                                                data-id="{{ $ppgb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($ppgb->status == '2')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-pasokan-gb"
                                                                onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->intake_kilang }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-pasokan-gb"
                                                                data-id="{{ $ppgb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/submit_pengolahan_gas_bumi_pasokan/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif

                                                    <center>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $ppgb->id }}">
                                                                Cek Revisi
                                                            </span>
                                                        @endif
                                                    </center>
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
                                        data-bs-target="#buat-pengolahan-distribusi-gb">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.pengolahan.gas_bumi.modal')
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
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengolahanDistribusiGB as $ppgb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('F Y', strtotime($ppgb->bulan)) }}</td>
                                                <td>{{ $ppgb->produk }}</td>
                                                <td>{{ $ppgb->provinsi }}</td>
                                                <td>{{ $ppgb->kabupaten_kota }}</td>
                                                <td>{{ $ppgb->sektor }}</td>
                                                <td>{{ $ppgb->volume }}</td>
                                                <td>{{ $ppgb->satuan }}</td>
                                                <td>
                                                    @if ($ppgb->status == '0' || $ppgb->status == '' || $ppgb->status == '-')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-distribusi-gb"
                                                                onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-distribusi-gb"
                                                                data-id="{{ $ppgb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/hapus_pengolahan_gas_bumi_distribusi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="/submit_pengolahan_gas_bumi_distribusi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ppgb->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihatPengolahan('{{ $ppgb->id }}' )"
                                                                data-bs-target="#lihat-pengolahan-distribusi-gb"
                                                                data-id="{{ $ppgb->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($ppgb->status == '2')
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info edit-pengolahan-distribusi-gb"
                                                                onclick="editPengolahan('{{ $ppgb->id }}', '{{ $ppgb->produk }}', '{{ $ppgb->kabupaten_kota }}', '{{ $ppgb->status }}' )"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-pengolahan-distribusi-gb"
                                                                data-id="{{ $ppgb->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit Data"></i>
                                                            </button>
                                                            <form
                                                                action="/submit_pengolahan_gas_bumi_distribusi/{{ $ppgb->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ppgb->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif

                                                    <center>
                                                        @if ($ppgb->status == 1 && $ppgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($ppgb->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($ppgb->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $ppgb->id }}">
                                                                Cek Revisi
                                                            </span>
                                                        @endif
                                                    </center>
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
