<?php 
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailRemarks;

class SendEmailRemarksListener{

	public function handle(SendEmailRemarks $email){
		$email->job();
	}
}