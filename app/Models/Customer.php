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
			$website = MasterWebsite::find($selfM->website_id);
			$website_code = $website->code;
			$queue = DB::table('customer')->where('website_id', $selfM->website_id)->count();
			$queue += 1;
			$loop = strlen((string)$queue);
			if ($loop == 1) { $append = '00'.$queue; }
			else if ($loop == 2) { $append = '0'.$queue; }
			else if ($loop == 3) { $append = $queue; }
			$selfM->code = $website_code.$append;
			$selfM->website = $website->name;

			$bank = MasterBank::find($selfM->bank_id);
			$selfM->bank = $bank->name;

			$tier = MasterTier::find($selfM->tier_id);
			$selfM->tier = $tier->name;
		});
	}
}
