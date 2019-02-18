<?php

namespace App\Http\Controllers\Phonebook;

use App\Http\Controllers\Controller;

class PhonebookController extends Controller {

	public function create(){
		return response()->json(compact('data'), 200);
	}

	public function read(){
		return response()->json(compact('data'), 200);
	}

	public function update(){
		return response()->json(compact('data'), 200);
	}

	public function delete(){
		return response()->json(compact('data'), 200);
	}

	public function remove(){

	}
}
