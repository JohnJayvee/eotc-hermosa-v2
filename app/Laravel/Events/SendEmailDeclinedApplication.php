<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,PDF;

class SendEmailDeclinedApplication extends Event {


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

			$value = $this->data;

			$mailname = "Bussiness Application Details";
			$user_email = $value['email'];
			$this->data['full_name'] = $value['full_name'];
			$this->data['application_name'] = $value['application_name'];
			$this->data['ref_num'] = $value['ref_num'];
			$this->data['modified_at'] = $value['modified_at'];
			$this->data['remarks'] = $value['remarks'];
			
			Mail::send('emails.business-declined', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
                $message->subject("Business Application Details");
			});
	}
}
