<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterWebsite extends Model
{
	protected $table = 'master_website';
	public function setCodeAttribute($code){ 
        return $this->attributes['code'] = strtoupper($code); 
    }
}
