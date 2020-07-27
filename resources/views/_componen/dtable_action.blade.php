<div class="text-left">
	<div id="dTableAction" class="btn-group">
		<button id="refreshTable" alt="Refresh Table" title="Refresh Table" type="button" class="btn btn-outline-info"><i class="fas fa-sync-alt"></i></button>
		<button type="button" alt="Action Tools" title="Action Tools" class="btn btn-outline-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
			<i class="fas fa-tools"></i>&nbsp;
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