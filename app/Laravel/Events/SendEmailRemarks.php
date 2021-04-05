<?php 
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon;

class SendEmailRemarks extends Event {


	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $form_data)
	{
		$this->data = $form_data;
		// $this->email = $form_data['insert'];

	

	}

	public function job(){	
		
		
		foreach($this->data as $index =>$value){
			$mailname = "Application Remarks Details";
			$user_email = $value['email'];
			$this->data['full_name'] = $value['full_name'];
			$this->data['application_name'] = $value['application_name'];
			$this->data['department_name'] = $value['department_name'];
			$this->data['remarks'] = $value['remarks'];
			$this->data['created_at'] = $value['created_at'];

			Mail::send('emails.application-remarks', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("Application Remarks Details");
			});
		}


		
		
		
	}
}
