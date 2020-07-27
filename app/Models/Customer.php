<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
	protected $table = 'customer';
	public static function boot() {
		parent::boot();
		self::creating(function ($selfM) {
			$prefix = MasterWebsite::find($selfM->website_id);
			$prefix = $prefix->code;
			$queue = DB::table('customer')->where('website_id', $selfM->website_id)->count();
			$queue += 1;
			$loop = strlen((string)$queue);
			if ($loop == 1) { $append = '00'.$queue; }
			else if ($loop == 2) { $append = '0'.$queue; }
			else if ($loop == 3) { $append = $queue; }
			$selfM->code = $prefix.$append;
		});
	}
}
