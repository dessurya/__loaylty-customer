<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\User;
use DataTables;
use Validator;
use Auth;
use Hash;


class UserController extends Controller
{
	public function __construct(){
		$this->config_key = 'User';
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

    public function reset(Request $Request){
        $ids = explode('^', $Request->id);
        $Config = $this->getConfig();
        $Model = "App\Models\\".$Config['models'];
        $data = $Model::whereIn('id', $ids)->get();
        foreach ($data as $row) {
            $resspass = explode('@',$row->email);
            $resspass = $resspass[0];
            $row->password = $resspass;
            $row->save();
        }
        return [
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success Reset Password User'
        ];
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
				'email' => 'required|max:175|unique:user,email,'.$Request->id
			], $message);
    	}else{
    		$validator = Validator::make($Request->all(), [
				'name' => 'required|max:175|min:3',
				'email' => 'required|max:175|unique:user,email'
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
    	$store->email = $Request->email;
    	$store->save();
    	return [
    		'pnotify' => true,
    		'pnotify_type' => 'success',
    		'pnotify_text' => 'Success Store Data User',
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
    		'pnotify_text' => 'Success Delete Data User',
    		'reloadDataTabless' => true
    	];
    }

    public function self(){
        $data = Auth::guard('user')->user();
        return view('pages.pettern_self', compact('data'));
    }

    public function selfStore(Request $Request){
        $me = User::find(Auth::guard('user')->user()->id);
        if (User::where('email',$Request->email)->whereNotIn('id',[$me->id])->count() > 0) {
            return redirect()->back()->with('status', 'Sorry email has already been taken');
        }
        if (Hash::check($Request->old_password, $me->password)) {
            if (!empty($Request->new_password)) {
                if ($Request->new_password == $Request->cfm_password) {
                    $me->password = $Request->new_password;
                }else{
                    return redirect()->back()->with('status', 'Sorry your new password not same with confirm password');
                }
            }
            $me->name = $Request->name;
            $me->email = $Request->email;
            $me->save();
            return redirect()->back()->with('status', 'Success update your profile data');
        }else{
            return redirect()->back()->with('status', 'Sorry your old password is wrong');
        }
    }
}
