<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'first_name', 'last_name', 'mobile',
	];
}
