$(document).on('click', '#dTableAction #refreshTable', function(){
	reloadDataTabless();
});

$(document).on('click', 'table.dtables tbody tr', function(){
	$(this).toggleClass('selected');
});

$(document).on('click', '#dTableAction a.action-item', function(){
	var data = {
		"action" : $(this).data('action'),
		"select" : $(this).data('select'),
		"confirm" : $(this).data('confirm'),
		"multiple" : $(this).data('multiple'),
		"url" : $(this).attr('href'),
		"target" : "table#table-data tr.selected"
	};
	actionButtonExe(data);
	return false;
});

$(document).on('submit', 'form.postData', function(){
	pnotifyConfirm({
		"title" : "Warning",
		"type" : "info",
		"text" : "Are You Sure Do Store This Data?",
		"formData" : false,
		"data" : $(this).serializeArray(),
		"url" : $(this).attr('action')
	});
	return false;
});

function actionButtonExe(data) {
	var id = true;
	if (data.select == true) {
		id = getSelectedRowId({"target" : data.target, "multiple" : data.multiple});
		if (id === false) { return false; }
	}
	data["id"] = id;
	if (data.confirm == true) {
		pnotifyConfirm({
			"title" : "Warning",
			"type" : "info",
			"text" : "Are You Sure Do "+data.action+" On Selected Data?",
			"data" : data,
			"url" : data.url
		});
	}else{
		postData(data,data.url);
	}
}

function getSelectedRowId(data) {
	var idData = "";
	$(data.target).each(function(){
		idData += $(this).attr('id')+'^';
	});
	var idDL = idData.length-1;
	idData = idData.substr(0, idDL);
	if (idData === null || idData === '' || idData === undefined) { 
		pnotify({"title":"info","type":"error","text":"No Data Selected!"}); 
		return false;
	}else if(data.multiple == false && idData.indexOf('^') > -1){
		pnotify({"title":"info","type":"error","text":"You only can selected one data!"}); 
		return false;
	}
	return idData;
}

function callDataTabless(setConf) {
	if(setConf.reBuild == true){
		datatable.destroy();
	}
	$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
		return {
			"iStart": oSettings._iDisplayStart,
			"iEnd": oSettings.fnDisplayEnd(),
			"iLength": oSettings._iDisplayLength,
			"iTotal": oSettings.fnRecordsTotal(),
			"iFilteredTotal": oSettings.fnRecordsDisplay(),
			"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
			"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
		};
	};
	var dataTabOfId = setConf.dataTabOfId;
	datatable = $(dataTabOfId).DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: setConf.ajaxUrl,
			type: "POST",
			data: setConf.dataPost
		},
		columns: setConf.ConfigColumns,
		initComplete: function () {
			var api = this.api();
			api.columns().every(function () {
				var column = this;
				if ($(column.footer()).hasClass('search')) {
					var input = $('<input type="text" class="search form-control input-sm" placeholder="Search '+$(column.footer()).text()+'" />');
					input.appendTo( $(column.footer()).empty() ).on('change', function (keypress) {
						if (column.search() !== this.value) {
		                        // var val = $.fn.dataTable.util.escapeRegex($(this).val());
		                        var val = this.value;
		                        column.search(val ? val : '', true, false).draw();
		                    }
		                });
				}
			});
		},
		rowCallback: function(row, data, iDisplayIndex) {
			$(row).attr('id', data.id);
		}
	});
}

function reloadDataTabless() {
	var confDtTable =JSON.parse(sessionStorage.getItem("confDtTable"));
	confDtTable['reBuild'] = true;
	if($(confDtTable['dataTabOfId']).length){
		callDataTabless(confDtTable);
	}
}

function formPrepare(data) {
	$('#iconUrl').hide();
	$('#iconUrl a').html('');
	$(data.target).find('button').removeAttr('disabled');
	$(data.target).find('.input').val(null).removeAttr('required').removeAttr('readonly');
	$.each(data.required, function(key,target){
		$('[name='+target+']').attr('required', 'true');
	});
	$.each(data.readonly, function(key,target){
		$('[name='+target+']').attr('readonly', 'true');
	});
	$.each(data.data, function(key, val){
		$(data.target+' [name='+key+']').val(val);
	});

	toggleTab();
}

function toggleTab() {
	$('ul#custom-tabs-one-tab li a').toggleClass('active');
	$('#custom-tabs-one-tabContent .tab-pane').toggleClass('active');
	$('#custom-tabs-one-tabContent .tab-pane').toggleClass('show');
}

function validatorError(data) {
	$.each(data.data, function(arrK, arrV){
		pnotify({"title":"info","type":"error","text":arrV}); 
	});
}

function reCallForm(url,id) {
	var post = {};
	post['id'] = id;
	postData(post,url);
}