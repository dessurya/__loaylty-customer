<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Config;
use App\Models\MasterWebsite;
use App\Models\MasterBank;
use App\Models\MasterTier;

use PhpOffice\PhpSpreadsheet\IOFactory;
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
		return DataTables::of($data)->editColumn('icon', function ($data){
            // if (!empty($data->icon)) {
            //     return '<img class="icon" src="'.asset($data->icon).'" >';
            // }
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
        $checkParam = ['model'=>$Model,'id'=>null,'wid'=>$Request->website_id,'bid'=>$Request->bank_id,'tid'=>$Request->tier_id];
        if (isset($Request->id)){
            $checkParam['id'] = $Request->id;
        }
        $checkIfExist = $this->checkIfExist();
        if ($checkIfExist === false) {
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'Sorry, this data already exists'
            ];
        }
    	$store = $this->storeExecute($Model, $Request);
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

    private function storeExecute($Model, $object){
        if (isset($Request->id)){
            $store = $Model::find($Request->id);

        }else{
            $store = new $Model;
        }
        $store->username = $object->username;
        $store->name = $object->name;
        $store->alamat = $object->alamat;
        $store->no_hp = $object->no_hp;
        $store->no_rekening = $object->no_rekening;
        $store->atas_nama_rekening = $object->atas_nama_rekening;
        $store->website_id = $object->website_id;
        $store->bank_id = $object->bank_id;
        $store->tier_id = $object->tier_id;
        $store->save();
        return $store;
    }

    public function import(Request $Request){
        $Config = $this->getConfig();
        if (!file_exists('file/')){
            mkdir('file/', 0777);
        }
        if (!file_exists('file/import')){
            mkdir('file/import', 0777);
        }
        $file         = Carbon::now()->format('Ymd_h_i_s').'_'.Str::random(4);
        $file_dir     = 'assets/file/import/'.$file.'_import.xlsx';
        try {
            file_put_contents($file_dir, base64_decode($Request->base64));
            $response = true;
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        $objPHPExcel = IOFactory::load($file_dir);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumn++;
        $header = [];
        for ($column = 'A'; $column != $highestColumn; $column++) {
            $cell = $sheet->getCell($column.'1')->getValue();
            $header[] = $cell;
        }
        unlink($file_dir);
        if ($Config['import_header_validat'] !== $header) {
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'Sorry, this not correct document'
            ];
        }
        $write_arr = [];
        $done = [];
        $fail = [];
        for ($row = 2; $row <= $highestRow; $row++){
            $write_arr[] = [
                "username" => $sheet->getCell('A'.$row)->getValue(),
                "name" => $sheet->getCell('B'.$row)->getValue(),
                "alamat" => $sheet->getCell('C'.$row)->getValue(),
                "no_hp" => $sheet->getCell('D'.$row)->getValue(),
                "no_rekening" => $sheet->getCell('E'.$row)->getValue(),
                "atas_nama_rekening" => $sheet->getCell('F'.$row)->getValue(),
                "website_code" => $sheet->getCell('G'.$row)->getValue(),
                "bank_code" => $sheet->getCell('H'.$row)->getValue(),
                "tier" => $sheet->getCell('I'.$row)->getValue()
            ];
        }
        $Model = "App\Models\\".$Config['models'];
        foreach ($write_arr as $arr) {
            $get_import_id = $this->get_import_id($arr,$Model);
            if ($get_import_id['status'] == true) {
                $arr['website_id'] = $get_import_id['website_id'];
                $arr['bank_id'] = $get_import_id['bank_id'];
                $arr['tier_id'] = $get_import_id['tier_id'];
                $done[] = $arr;
                $object = (object)$arr;
                $this->storeExecute($Model, $object);
            }else{
                $arr['msg'] = $get_import_id['msg'];
                $fail[] = $arr;
            }
        }
        $render = view('_componen.customer_import_response_info', compact('done','fail'))->render();
        return [
            'pnotify' => true,
            'pnotify_type' => 'Success',
            'pnotify_text' => 'Success read your document',
            'reloadDataTabless' => true,
            'render' => true,
            'render_type' => 'html',
            'render_target' => '#responseImport',
            'render_content' => base64_encode($render)
        ];
    }

    private function get_import_id($arr,$Model){
        $website_id = MasterWebsite::where('code', strtoupper($arr['website_code']))->first();
        if (!empty($website_id)) {
            $website_id = $website_id->id;
        }else{
            return ['status' => false, 'msg' => 'Cannt find website code'];
        }
        $bank_id = MasterBank::where('code', $arr['bank_code'])->first();
        if (!empty($bank_id)) {
            $bank_id = $bank_id->id;
        }else{
            return ['status' => false, 'msg' => 'Cannt find bank code'];
        }
        $tier_id = MasterTier::where('name', $arr['tier'])->first();
        if (!empty($tier_id)) {
            $tier_id = $tier_id->id;
        }else{
            return ['status' => false, 'msg' => 'Cannt find tier'];
        }

        $message = [];
        $validator = Validator::make($arr, [
            'username' => 'required|max:175|min:5|unique:customer,username',
            'name' => 'required|max:175|min:3',
            'alamat' => 'required|max:375|min:15',
            'no_hp' => 'required|numeric',
            'no_rekening' => 'required|numeric',
            'atas_nama_rekening' => 'required|max:175|min:5'
        ], $message);
        if ($validator->fails()) {
            $msg = '';
            $err = $validator->getMessageBag()->toArray();
            foreach ($err as $key => $value) {
                $msg .= $value[0].', ';
            }
            $msg = substr($msg, 0, -2);
            return [
                "status" => false,
                "msg" => $msg
            ];
        }

        $checkParam = ['model'=>$Model,'id'=>null,'wid'=>$website_id,'bid'=>$bank_id,'tid'=>$tier_id];
        $checkIfExist = $this->checkIfExist();
        if ($checkIfExist === false) {
            return ['status' => false, 'msg' => 'This data already exists'];
        }

        return ['status' => true, 'website_id' => $website_id, 'bank_id' => $bank_id, 'tier_id' => $tier_id];
    }

    private function checkIfExist($data){
        $check = $data['model']::where([
            'website_id' => $data['wid'],
            'bank_id' => $data['bid'],
            'tier_id' => $data['tid']
        ]);
        if (!empty($data['id'])) {
            $check->whereNotIn('id',[$data['id']]);
        }
        $check = $check->count();
        if ($check != 0) {
            return false;
        }else{
            return true;
        }
    }

    public function delete(Request $Request){
        $ids = explode('^', $Request->id);
        $Config = $this->getConfig();
        $Model = "App\Models\\".$Config['models'];
        $data = $Model::whereIn('id', $ids)->delete();
        return [
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success Delete Data Customer',
            'reloadDataTabless' => true
        ];
    }
}
