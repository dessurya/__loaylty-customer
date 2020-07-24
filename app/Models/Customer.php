<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customer';
	public static function boot() {
		parent::boot();
		self::creating(function ($selfM) {
			$selfM->code = $selfM->website_id.'-';
		});
	}
}
