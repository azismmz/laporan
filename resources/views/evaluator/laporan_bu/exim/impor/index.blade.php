@extends('layouts.blackand.app')

@section('content')
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0 font-size-18">{{$title}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
								<li class="breadcrumb-item active">{{$title}}</li>
							</ol>
						</div>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3>{{$title}}</h3>
						</div>
						<div class="card-body">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="penjualan">
									<div class="table-responsive">
										<table id="datatable-buttons" class="table table-bordered nowrap w-100">
											<thead>

											<tr>
												<th>No</th>
												<th>Nama Perusahaan</th>
												<th>Aksi</th>
											</tr>
											</thead>
											<tbody>
											@foreach($perusahaan as $per)
												<tr>
													<td>{{$loop->iteration}}</td>
													<td>{{$per->NAMA_PERUSAHAAN}}</td>
													<td><a href="{{url('laporan/impor/exim/periode').'/'. \Illuminate\Support\Facades\Crypt::encrypt($per->id_perusahaan) }}" class="btn btn-primary btn-rounded btn-sm"><i class="bx bx-show"></i> Lihat </a></td>

												</tr>
											@endforeach

											</tbody>


										</table>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

@endsection

@section('script')



@endsection