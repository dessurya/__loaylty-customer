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
var importUrl = '{!! route($compact["import_url"]) !!}';
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

$(document).on('click', 'button#trigerSelectImportFile', function() {
	$(this).val(null);
	sessionStorage.setItem('importBase64', null);
	$('input[type=file]').focus().trigger('click'); 
	return false;
});

$(document).on('change', 'input.import', function(e){
	var file = e.target.files[0];
	var reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onloadend = function () {
		var b64 = reader.result.replace(/^data:.+;base64,/, '');
	    sessionStorage.setItem('importBase64', b64);
	    importExcute();
	};
});

function importExcute() {
	var data = {};
	data['base64'] = sessionStorage.getItem('importBase64');
	pnotifyConfirm({
		"title" : "Warning",
		"type" : "info",
		"text" : "Are You Sure Do Import Data?",
		"formData" : false,
		"data" : data,
		"url" : importUrl
	});
	$('input.import').val(null);
	return false;
}
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
								<div class="text-right" style="float: right;">
									<div class="btn-group">
										<a class="btn btn-outline-info" href="{{ asset('assets/file/template_import_customer.xlsx') }}" target="_blank" alt="Download Template Import" title="Download Template Import"><i class="fas fa-file-download"></i></a>
										<button id="trigerSelectImportFile" type="button" class="btn btn-outline-info" href="#" target="_blank" alt="Upload Template Import" title="Upload Template Import"><i class="fas fa-file-upload"></i></button>
										<input class="import" type="file" accept=".xlsx" style="display: none;">
									</div>
								</div>
								@include('_componen.dtable_action', ['button_action'=>$compact['button_action']])
								@include('_componen.dtable', ['table_config'=>$compact['table_config']])
							</div>
							<div class="tab-pane fade" id="custom-tabs-two" role="tabpanel" aria-labelledby="custom-tabs-two-tab">
								@include($compact['form_location'], ['MasterTier'=>$compact['MasterTier'],'MasterWebsite'=>$compact['MasterWebsite'],'MasterBank'=>$compact['MasterBank'],'form_config'=>$compact['form_config']])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection