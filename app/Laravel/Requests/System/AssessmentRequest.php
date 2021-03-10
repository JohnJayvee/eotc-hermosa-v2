<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class AssessmentRequest extends RequestManager{

	public function rules(){

		$rules = [
			'file' => "required|mimes:png,jpg,jpeg,pdf,xlsx",
		];

		if(Auth::user()->department->code == "99"){
			$rules['total_amount'] = "required|numeric|min:0";
			$rules['cedula'] = "required";
			$rules['brgy_fee'] = "required|numeric|min:0";
		}
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
