<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $form_config['title'] }}</h3>
	</div>
	<form id="{{ $form_config['id'] }}" class="postData" method="post" action="{{ route($form_config['action']) }}">
		<input type="hidden" name="id" class="input">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Name</label>
						<input readonly name="name" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Icon</label>
						<div class="btn-group btn-block">
							<button id="trigerSelectIconFile" type="button" class="btn btn-outline-info" href="#" target="_blank" alt="Upload Tier Icon" title="Upload Tier Icon"><i class="fas fa-file-upload"></i>&nbsp;Upload Tier Icon</button>
							<input type="file" class="input" accept=".png" style="display: none;" >
							<input name="icon" class="input" type="text" style="display: none;" >
						</div>
						<small id="iconUrl" class="form-text text-muted" style="display: none;">
							<a target="_blank" href=""></a>
						</small>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button disabled type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>