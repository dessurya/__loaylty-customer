<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Config;
use App\Models\MasterWebsite;
use App\Models\MasterBank;
use App\Models\MasterTier;
use Carbon\Carbon;
use DataTables;
use Validator;

class CustomerController extends Controller
{
	public function __construct(){
		$this->config_key = 'Customer';
	}

	private function getConfig(){
		$Config = Config::where('key',$this->config_key)->first();
		$Config = json_decode($Config->config,true);
		return $Config;
	}

	public function index(){
		$Config = $this->getConfig();
		$compact = $Config['pass_param'];
		$compact['MasterWebsite'] = MasterWebsite::orderBy('name', 'asc')->get();
		$compact['MasterBank'] = MasterBank::orderBy('name', 'asc')->get();
		$compact['MasterTier'] = MasterTier::orderBy('name', 'asc')->get();
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
				'username' => 'required|max:175|min:5|unique:customer,username,'.$Request->id,
				'name' => 'required|max:175|min:3',
				'alamat' => 'required|max:375|min:15',
				'no_hp' => 'required|numeric',
				'no_rekening' => 'required|numeric',
				'atas_nama_rekening' => 'required|max:175|min:5',
				'website_id' => 'required|numeric',
				'bank_id' => 'required|numeric',
				'tier_id' => 'required|numeric'
			], $message);
    	}else{
    		$validator = Validator::make($Request->all(), [
				'username' => 'required|max:175|min:5|unique:customer,username',
				'name' => 'required|max:175|min:3',
				'alamat' => 'required|max:375|min:15',
				'no_hp' => 'required|numeric',
				'no_rekening' => 'required|numeric',
				'atas_nama_rekening' => 'required|max:175|min:5',
				'website_id' => 'required|numeric',
				'bank_id' => 'required|numeric',
				'tier_id' => 'required|numeric'
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
    	$store->username = $Request->username;
    	$store->name = $Request->name;
    	$store->alamat = $Request->alamat;
    	$store->no_hp = $Request->no_hp;
    	$store->no_rekening = $Request->no_rekening;
    	$store->atas_nama_rekening = $Request->atas_nama_rekening;
    	$store->website_id = $Request->website_id;
    	$store->bank_id = $Request->bank_id;
    	$store->tier_id = $Request->tier_id;
    	$store->save();
    	if (!isset($Request->id)){
	    	$store->code = $store->code.$store->id;
	        $store->save();
    	}
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

    public function import(Request $Request){
        $file         = Carbon::now()->format('Ymd_h_i_s').'_'.Str::random(4);
        $file_dir     = 'assets/file/import/'.$file.'_import.xlsx';
        try {
            file_put_contents($file_dir, base64_decode($Request->base64));
            $response = true;
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}
