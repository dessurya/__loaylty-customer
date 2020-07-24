<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $form_config['title'] }}</h3>
	</div>
	<form id="{{ $form_config['id'] }}" class="postData" method="post" action="{{ route($form_config['action']) }}">
		<input type="hidden" name="id" class="input">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Code</label>
						<input readonly name="code" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Website</label>
						<select readonly name="website_id" class="form-control input">
							@foreach($MasterWebsite as $row)
							<option value="{{ $row->id }}">{{ $row->code.' '.$row->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Username</label>
						<input readonly name="username" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Name</label>
						<input readonly name="name" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>No HP</label>
						<input readonly name="no_hp" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Alamat</label>
						<input readonly name="alamat" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Bank</label>
						<select readonly name="bank_id" class="form-control input">
							@foreach($MasterBank as $row)
							<option value="{{ $row->id }}">{{ $row->code.' '.$row->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>No Rekening</label>
						<input readonly name="no_rekening" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Atas Nama Rekening</label>
						<input readonly name="atas_nama_rekening" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Tier</label>
						<select readonly name="tier_id" class="form-control input">
							@foreach($MasterTier as $row)
							<option value="{{ $row->id }}">{{ $row->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button disabled type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>