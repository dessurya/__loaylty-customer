<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use DataTables;
use Validator;


class MasterWebsiteController extends Controller
{
	public function __construct(){
		$this->config_key = 'MasterWebsite';
	}

	private function getConfig(){
		$Config = Config::where('key',$this->config_key)->first();
		$Config = json_decode($Config->config,true);
		return $Config;
	}

	public function index(){
		$Config = $this->getConfig();
		$compact = $Config['pass_param'];
		return view($Config['page_pattern'], compact('compact'));
	}

	public function dataTables(Request $Request){
		$Config = $this->getConfig();
		$Model = "App\Models\\".$Config['table_models'];
		$data = $Model::get();
		return DataTables::of($data)->escapeColumns(['*'])->make(true);
    }

    public function form(Request $Request){
    	$Config = $this->getConfig();
    	$data = null;
    	if ($Request->id != "true") {
    		$Model = "App\Models\\".$Config['models'];
			$data = $Model::find($Request->id);
    	}
    	return [
    		"formPrepare" => true,
    		"target" => $Config['form_target'],
    		"required" => $Config['form_required'],
    		"readonly" => $Config['form_readonly'],
    		"data" => $data
    	];
    }

    public function store(Request $Request){
    	$message = [];
    	if (isset($Request->id)) {
    		$validator = Validator::make($Request->all(), [
				'name' => 'required|max:175',
				'code' => 'required|size:3|regex:/^[a-zA-Z]+$/u|unique:master_website,code,'.$Request->id
			], $message);
    	}else{
    		$validator = Validator::make($Request->all(), [
				'name' => 'required|max:175|min:3',
				'code' => 'required|size:3|regex:/^[a-zA-Z]+$/u|unique:master_website,code'
			], $message);
    	}
    	if ($validator->fails()) {
    		return [
    			"validatorError" => true,
    			"data" => $validator->getMessageBag()->toArray()
    		];
    	}
    	$Config = $this->getConfig();
    	$Model = "App\Models\\".$Config['models'];
    	if (isset($Request->id)){
    		$store = $Model::find($Request->id);

    	}else{
    		$store = new $Model;
    	}
    	$store->name = $Request->name;
    	$store->code = $Request->code;
    	$store->save();
    	return [
    		'pnotify' => true,
    		'pnotify_type' => 'success',
    		'pnotify_text' => 'Success Store Data Master Website',
    		'reloadDataTabless' => true,
    		'reCallForm' => true,
    		'form_route' => route($Config['form_route']),
    		'form_id' => $store->id
    	];
    }

    public function delete(Request $Request){
        $ids = explode('^', $Request->id);
        $Config = $this->getConfig();
        $Model = "App\Models\\".$Config['models'];
        $data = $Model::whereIn('id', $ids)->delete();
        return [
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success Delete Data Website',
            'reloadDataTabless' => true
        ];
    }
}
