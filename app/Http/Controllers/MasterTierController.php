<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Config;
use Carbon\Carbon;
use DataTables;
use Validator;

class MasterTierController extends Controller
{
	public function __construct(){
		$this->config_key = 'MasterTier';
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
		return DataTables::of($data)->editColumn('icon', function ($data){
            if (!empty($data->icon)) {
                return '<img class="icon" src="'.asset($data->icon).'" >';
            }
        })->escapeColumns(['*'])->make(true);
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
				'name' => 'required|max:175|unique:master_tier,name,'.$Request->id
			], $message);
    	}else{
    		$validator = Validator::make($Request->all(), [
				'name' => 'required|max:175|unique:master_tier,name'
			], $message);
    	}
    	if ($validator->fails()) {
    		return [
    			"validatorError" => true,
    			"data" => $validator->getMessageBag()->toArray()
    		];
    	}
        $imgIcon = null;
        if (isset($Request->icon) and !empty($Request->icon)){
            $imgIcon = base64_decode($Request->icon);
        }
    	$Config = $this->getConfig();
    	$Model = "App\Models\\".$Config['models'];
    	if (isset($Request->id)){
    		$store = $Model::find($Request->id);
            if ($imgIcon !== null and !empty($store->icon)){
                unlink($store->icon);
            }
    	}else{
    		$store = new $Model;
    	}
    	$store->name = $Request->name;
        if ($imgIcon !== null) {
            if (!file_exists('images/')){
                mkdir('images/', 0777);
            }
            if (!file_exists('images/icon')){
                mkdir('images/icon', 0777);
            }
            $file_name = Str::slug($Request->name, '-').'_'.Carbon::now()->format('Ymd_h_i_s').'_'.Str::random(4);
            $file_dir     = 'images/icon/'.$file_name.'.png';
            try {
                file_put_contents($file_dir, $imgIcon);
                $response = true;
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
        	$store->icon = $file_dir;
        }
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
}
