<div class="row">
	<div class="col-12">
		<div class="card card-primary card-tabs">
			<div class="card-header p-0 pt-1">
				<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
					<li class="pt-2 px-3"><h3 class="card-title">Import Information</h3></li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-two-success-tab" data-toggle="pill" href="#custom-tabs-two-success" role="tab" aria-controls="custom-tabs-two-success" aria-selected="false">Success</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-two-fail-tab" data-toggle="pill" href="#custom-tabs-two-fail" role="tab" aria-controls="custom-tabs-two-fail" aria-selected="false">Fail</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<div class="tab-content" id="custom-tabs-two-tabContent">
					<div class="tab-pane fade" id="custom-tabs-two-success" role="tabpanel" aria-labelledby="custom-tabs-two-success-tab">
						<div class="table-responsive">
							<table class="table table-striped table-bordered no-footer dtables" width="100%">
								<thead>
									<tr role="row">
										<th>Username</th>
										<th>Name</th>
										<th>No Hp</th>
										<th>Website</th>
										<th>No Rekening</th>
									</tr>
								</thead>
								<tbody>
									@foreach($done as $list)
									<tr role="row">
										<td>{{ $list['username'] }}</td>
										<td>{{ $list['name'] }}</td>
										<td>{{ $list['no_hp'] }}</td>
										<td>{{ $list['website_code'] }}</td>
										<td>{{ $list['no_rekening'] }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-two-fail" role="tabpanel" aria-labelledby="custom-tabs-two-fail-tab">
						<div class="table-responsive">
							<table class="table table-striped table-bordered no-footer dtables" width="100%">
								<thead>
									<tr role="row">
										<th>Username</th>
										<th>Name</th>
										<th>No Hp</th>
										<th>Website</th>
										<th>No Rekening</th>
										<th>Info</th>
									</tr>
								</thead>
								<tbody>
									@foreach($fail as $list)
									<tr role="row">
										<td>{{ $list['username'] }}</td>
										<td>{{ $list['name'] }}</td>
										<td>{{ $list['no_hp'] }}</td>
										<td>{{ $list['website_code'] }}</td>
										<td>{{ $list['no_rekening'] }}</td>
										<td>{{ $list['msg'] }}</td>
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