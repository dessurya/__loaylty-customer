<div class="text-left">
	<div id="dTableAction" class="btn-group">
		<button id="refreshTable" type="button" class="btn btn-outline-info"><i class="fas fa-sync-alt"></i>&nbsp;Refresh Table</button>
		<button type="button" class="btn btn-outline-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
			<i class="fas fa-tools"></i>&nbsp;Action Tools&nbsp;
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<div class="dropdown-menu" role="menu">
			@foreach($button_action as $list)
			<a 
				class="dropdown-item action-item"
				data-action="{{ $list['action'] }}"
				data-select="{{ $list['select'] }}"
				data-confirm="{{ $list['confirm'] }}"
				data-multiple="{{ $list['multiple'] }}"
				href="{{ route($list['route']) }}"><i class="fas fa-{{$list['icon']}}"></i>&nbsp;{{$list['title']}}</a>
			@endforeach
		</div>
	</div>
</div>
<hr>