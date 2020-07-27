@extends('_layouts.base')

@section('title')
{{ $compact['page_title'] }}
@endsection

@section('link')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
@endsection

@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/dtable_pattern.js') }}"></script>
<script type="text/javascript">
$( document ).ready(function() {
	var confDtTable = {};
	confDtTable['dataTabOfId'] = '#table-data';
	confDtTable['reBuild'] = false;
	confDtTable['ajaxUrl'] = '{!! route($compact["table_url"]) !!}';
	confDtTable['ConfigColumns'] = {!! json_encode($compact["table_config"]) !!};
	confDtTable['dataPost'] = {};
	sessionStorage.setItem("confDtTable", JSON.stringify(confDtTable));
	callDataTabless(confDtTable);
});
@if(Route::is('master.tier*'))
$(document).on('click', 'button#trigerSelectIconFile', function() {
	$(this).val(null);
	$('input[name=icon]').val(null);
	$('small#iconUrl').hide();
	$('small#iconUrl a').html('');
	$('small#iconUrl a').attr('href','');
	$('input[type=file]').focus().trigger('click'); 
	return false;
});
$(document).on('change', 'input[type=file]', function(e){
	if ($(this).val() !== null) {
		var thisFile = e.target.files[0];
		if (Math.round((thisFile.size / 1024)) > 4096) {
			pnotify({"title":"info","type":"error","text":"File too Big, please select a file less than 4mb"});
		}
		var type = thisFile.type;
		var type_reg = /^image\/(png)$/;
		if (type_reg.test(type) === false){
			pnotify({"title":"info","type":"error","text":"not allow format"});
		}
		var url = URL.createObjectURL(thisFile);
		$('small#iconUrl').show();
		$('small#iconUrl a').html(url);
		$('small#iconUrl a').attr('href',url);
		var reader = new FileReader();
		reader.readAsDataURL(thisFile);
		reader.onloadend = function () {
			var b64 = reader.result.replace(/^data:.+;base64,/, '');
		    fileBase64(b64);
		};
	}
});
function fileBase64(b64) {
	$('input[name=icon]').val(b64);
}
@endif
</script>
@endsection

@section('content')
	@include('_componen.content_page_header', ['page_title'=>$compact['page_title']])
	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="card card-primary card-tabs">
					<div class="card-header p-0 pt-1">
						<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-item">
								<a 
									class="nav-link active" 
									id="custom-tabs-one-tab" 
									data-toggle="pill" 
									href="#custom-tabs-one" 
									role="tab" 
									aria-controls="custom-tabs-one" 
									aria-selected="true">Index Of Data</a>
							</li>
							<li class="nav-item">
								<a 
									class="nav-link" 
									id="custom-tabs-two-tab" 
									data-toggle="pill" 
									href="#custom-tabs-two" 
									role="tab" 
									aria-controls="custom-tabs-two" 
									aria-selected="true">Form Data</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="custom-tabs-one-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-one" role="tabpanel" aria-labelledby="custom-tabs-one-tab">
								@include('_componen.dtable_action', ['button_action'=>$compact['button_action']])
								@include('_componen.dtable', ['table_config'=>$compact['table_config']])
							</div>
							<div class="tab-pane fade" id="custom-tabs-two" role="tabpanel" aria-labelledby="custom-tabs-two-tab">
								@include($compact['form_location'], ['form_config'=>$compact['form_config']])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection