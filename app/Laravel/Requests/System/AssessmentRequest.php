<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class AssessmentRequest extends RequestManager{

	public function rules(){

		$rules = [
			'file' => "required",
			'cedula' => "required",
			'brgy_fee' => "required|numeric|min:0",
			'total_amount' => "required|numeric|min:0",
		];
	
		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
			'numeric' => "Please input a valid amount.",
			'min' => "Minimum amount is 0.",
			'integer' => "Invalid data. Please provide a valid input.",
		];
	}
}