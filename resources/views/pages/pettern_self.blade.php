@extends('_layouts.base')

@section('title')
Self Data
@endsection
@section('link')
@endsection
@section('script')
@endsection

@section('content')
	@include('_componen.content_page_header', ['page_title'=>'Halo, '.$data->name])
	<section class="content">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Your Self Data</h3>
			</div>
			<form id="Self" method="post" action="{{ route('self-store') }}">
				{{ csrf_field() }}
				<div class="card-body">
					@if(Session::has('status'))
					<div class="alert alert-info" role="alert">
						{{ Session::get('status') }}
					</div>
					@endif
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Name</label>
								<input required name="name" type="text" class="form-control" value="{{ $data->name }}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input required name="email" type="email" class="form-control" value="{{ $data->email }}">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Old Password</label>
								<input required name="old_password" type="password" class="form-control">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>New Password</label>
								<input name="new_password" type="password" class="form-control">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Confirm Password</label>
								<input name="cfm_password" type="password" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</section>
@endsection