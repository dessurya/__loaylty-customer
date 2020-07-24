<div class="table-responsive">
	<table id="table-data" class="table table-striped table-bordered no-footer dtables" width="100%">
		<thead>
			<tr role="row">
				@foreach($table_config as $list)
				<th>{{ Str::title($list['name']) }}</th>
				@endforeach
			</tr>
		</thead>
		<tfoot class="">
			<tr role="row">
				@foreach($table_config as $list)
				@if($list['searchable'] == 'true')
				<th class="search">{{ Str::title($list['name']) }}</th>
				@else
				<th></th>
				@endif
				@endforeach
			</tr>
		</tfoot>
	</table>
</div>