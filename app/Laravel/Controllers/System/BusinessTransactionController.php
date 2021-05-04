<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */

/*
 * Models
 */


use App\Laravel\Models\{BusinessTransaction,Department,RegionalOffice,Application, ApplicationBusinessPermit, ApplicationRequirements, BusinessActivity, TransactionRequirements,CollectionOfFees,ApplicationBusinessPermitFile, Business, BusinessFee,RegulatoryPayment,User,BusinessTaxPayment,BusinessLine,Assessment};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Events\NotifyDepartmentSMS;
use App\Laravel\Events\NotifyBPLOAdminEmail;
/* App Classes
 */
use App\Laravel\Requests\System\BPLORequest;
use App\Laravel\Events\NotifyDepartmentEmail;
use App\Laravel\Events\SendEmailRemarks;
use App\Laravel\Events\SendEmailDigitalCertificate;
use App\Laravel\Events\SendEmailApprovedBusiness;
use App\Laravel\Events\SendEmailDeclinedBusiness;
use App\Laravel\Events\SendDeclinedEmailReference;
use App\Laravel\Events\SendEmailDeclinedApplication;
use App\Laravel\Events\UploadLineOfBusinessToLocal;
use App\Laravel\Requests\System\TransactionCollectionRequest;
use App\Laravel\Requests\System\TransactionUpdateRequest;
use App\Laravel\Requests\System\AssessmentRequest;
use App\Laravel\Requests\System\RemarkBusinessTransactionRequest;
use Carbon,Auth,DB,Str,ImageUploader,Helper,Event,FileUploader,Curl,PDF;
use Illuminate\Support\Facades\Log;

class BusinessTransactionController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

		$this->data['departments'] = ['' => "Choose Department"] + Department::pluck('name', 'id')->toArray();
        $this->data['business_scopes'] = ["" => "Choose Business Scope",'national' => "National",'regional' => "Regional",'municipality' => "City/Municipality",'barangay' => "Barangay"];
        $this->data['attachment_counts'] = ["" => "Choose Attachment Types",'2' => "Complete",'1' => "Incomplete",'0' => "No Attachment"];
		$this->data['business_types'] = ["" => "Choose Business Type",'sole_proprietorship' => "Sole Proprietorship",'cooperative' => "Cooperative",'corporation' => "Corporation",'partnership' => "Partnership", 'association' => "Association"];
		$this->data['regional_offices'] = ['' => "Choose Regional Offices"] + RegionalOffice::pluck('name', 'id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->data['status'] = ['' => "Choose Payment Status",'PAID' => "Paid" , 'UNPAID' => "Unpaid"];
		$this->data['approval'] = ['' => "Choose Approval Type",'1' => "Yes" , '0' => "No"];
		$this->data['processor'] = ['' => "Choose Validation",'1' => "Validated" , '0' => "Not Yet"];
        $this->data['fees'] =  ['' => "Choose Collection Fees"] + CollectionOfFees::pluck('collection_name','id')->toArray();
		$this->per_page = env("DEFAULT_PER_PAGE",2);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Business Transactions";
		$this->data['business_transactions'] = BusinessTransaction::orderBy('created_at',"DESC")->get();
		return view('system.business-transaction.index',$this->data);
	}

	public function  pending(PageRequest $request){


		/*$get_bt = BusinessTransaction::all();

		foreach ($get_bt as $key => $value) {
			$app_file_count = ApplicationBusinessPermitFile::where('application_business_permit_id' , $value->id)->count();
			$update_business_transaction = BusinessTransaction::where('id',$value->id)->where('attachment_count', NULL)->first();
			if ($update_business_transaction) {
				$update_business_transaction->attachment_count = $app_file_count;
				$update_business_transaction->save();
			}

		}*/
		$this->data['page_title'] = "Pending Business Transactions";

		$auth = Auth::user();
		$this->data['auth'] = Auth::user();

		$first_record = BusinessTransaction::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at->format("Y-m-d"));
		}
		$this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");


		$this->data['selected_application_id'] = $request->get('application_id');
		$this->data['selected_bplo_approval'] = $request->get('bplo_approval');
		$this->data['selected_processor'] = $request->get('processor');
		$this->data['selected_department'] = $request->get('department_id');
		$this->data['selected_attachment_count'] = $request->get('attachment_count');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();

        $this->data['department'] = Department::find($this->data['selected_department']);

        $query = BusinessTransaction::with('application_permit')->with('owner')->where('status',"PENDING")->where('is_resent',0)->whereHas('application_permit',function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
								->orWhereRaw("LOWER(application_no) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_application_id']) > 0){
						return $query->where('application_id',$this->data['selected_application_id']);
					}

				})
				->where(function($query){
					if(strlen($this->data['selected_processing_fee_status']) > 0){
						return $query->where('payment_status',$this->data['selected_processing_fee_status']);
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_bplo_approval']) > 0){
						return $query->where('for_bplo_approval',$this->data['selected_bplo_approval']);
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_processor']) > 0){
						return $query->where('is_validated',$this->data['selected_processor']);
					}
                })
                ->where(function($query){
					if(strlen($this->data['selected_department']) > 0){
						return $query->whereJsonContains('department_involved',$this->data['department']->code);
					}
                })
                ->where(function($query){
					if(strlen($this->data['selected_attachment_count']) > 0){
						return $query->where('attachment_count',$this->data['selected_attachment_count']);
					}
                })
                ->where(function($query) use($auth){
					if(strlen($auth->department_id) > 0 && !in_array($auth->type, ['admin', 'super_user'])){
						return $query->where('is_validated', '1');
					}
				})
                ->whereBetween('created_at', [
                    Carbon::parse($this->data['start_date'])->startOfDay()->format('Y-m-d H:i:s'),
                    Carbon::parse($this->data['end_date'])->endofDay()->format('Y-m-d H:i:s')
                ])
				->orderBy('created_at',"ASC");

        $this->data['transactions'] = $query->paginate($this->per_page);

		return view('system.business-transaction.pending',$this->data);
	}

	public function  approved(PageRequest $request){
		$this->data['page_title'] = "Approved Business Transactions";

		$auth = Auth::user();
		$this->data['auth'] = Auth::user();

		$first_record = BusinessTransaction::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at->format("Y-m-d"));
		}

		$this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");
		$this->data['selected_application_id'] = $request->get('application_id');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['selected_department'] = $request->get('department_id');
		$this->data['keyword'] = Str::lower($request->get('keyword'));

		$this->data['department'] = Department::find($this->data['selected_department']);
		$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();
		$this->data['transactions'] = BusinessTransaction::with('application_permit')->with('owner')->where('status',"APPROVED")->whereHas('application_permit',function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(application_no) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_application_id']) > 0){
						return $query->where('application_id',$this->data['selected_application_id']);
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_processing_fee_status']) > 0){
						return $query->where('payment_status',$this->data['selected_processing_fee_status']);
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_department']) > 0){
						return $query->whereJsonContains('department_involved',$this->data['department']->code);
					}
                })
				->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
				->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
				->orderBy('created_at',"ASC")->paginate($this->per_page);

		return view('system.business-transaction.approved',$this->data);
	}
	public function  declined(PageRequest $request){
		$this->data['page_title'] = "Declined Business Transactions";

		$auth = Auth::user();
		$this->data['auth'] = Auth::user();

		$first_record = BusinessTransaction::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at->format("Y-m-d"));
		}
		$this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");

		$this->data['selected_application_id'] = $request->get('application_id');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->get('keyword'));
		$this->data['selected_department'] = $request->get('department_id');

		$this->data['department'] = Department::find($this->data['selected_department']);
		$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();

		$this->data['transactions'] = BusinessTransaction::with('application_permit')->with('owner')->where('status',"DECLINED")->whereHas('application_permit',function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(application_no) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_application_id']) > 0){
						return $query->where('application_id',$this->data['selected_application_id']);
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_department']) > 0){
						return $query->whereJsonContains('department_involved',$this->data['department']->code);
					}
                })
				->where(function($query){
					if(strlen($this->data['selected_processing_fee_status']) > 0){
						return $query->where('payment_status',$this->data['selected_processing_fee_status']);
					}
				})
				->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
				->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
				->orderBy('created_at',"ASC")->paginate($this->per_page);

		return view('system.business-transaction.declined',$this->data);
	}
	public function show(PageRequest $request,$id=NULL){
		$this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['transaction'] = $request->get('business_transaction_data');

        $requirements_id = $this->data['transaction']->requirements_id;

        $this->data['business_line'] = BusinessActivity::where('application_business_permit_id', $this->data['transaction']->business_permit_id)->get();
		$this->data['app_business_permit'] = ApplicationBusinessPermit::where('business_id' , $this->data['transaction']->business_id)->get();

        $this->data['app_business_permit_file'] = ApplicationBusinessPermitFile::where('application_business_permit_id', $this->data['transaction']->id)->get();


		$this->data['physical_requirements'] = ApplicationRequirements::whereIn('id',explode(",", $requirements_id))->get();

		$this->data['department'] =  Department::pluck('name','id')->toArray();

		$this->data['assessments'] = Assessment::where('transaction_id',$id)->get();
        $this->update_status($id);
		$this->data['page_title'] = "Transaction Details";
		return view('system.business-transaction.show',$this->data);
    }

    public function edit(PageRequest $request,$id=NULL){
        $this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['transaction'] = $request->get('business_transaction_data');

        $requirements_id = $this->data['transaction']->requirements_id;

        $this->data['business_line'] = BusinessActivity::where('application_business_permit_id', $this->data['transaction']->business_permit_id)->get();
        $this->data['existing'] = [];
        if(count($this->data['business_line']) > 0){
            foreach ($this->data['business_line'] as $key => $value) {
                $this->data['existing'][$value->b_class."---".$value->s_class."---".($value->x_class ? $value->x_class:"0")."---".$value->account_code] = $value->line_of_business;
            }
        }

		$this->data['app_business_permit'] = ApplicationBusinessPermit::where('business_id' , $this->data['transaction']->business_id)->get();

        $this->data['app_business_permit_file'] = ApplicationBusinessPermitFile::where('application_business_permit_id', $this->data['transaction']->id)->get();


		$this->data['physical_requirements'] = ApplicationRequirements::whereIn('id',explode(",", $requirements_id))->get();

		$this->data['department'] =  Department::pluck('name','id')->toArray();

		$this->data['regulatory_fee'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 0)->get();
		$this->data['garbage_fee'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 2)->get();
        $this->data['business_tax'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 1)->get();
        // $this->update_status($id);
		$this->data['page_title'] = "Transaction Details";
		return view('system.business-transaction.edit',$this->data);
    }

    public function update(TransactionUpdateRequest $request,$id=NULL){
        // dd(request()->all());
        $this->retrieve_lobs();
        $transaction = $request->get('business_transaction_data');
        DB::beginTransaction();
        try{

            $owner_transaction_details = array('email' => request('business_info.owner_email'), 'contact_number' => request('business_info.owner_mobile_no'));
            $business_info = array_merge(request('business_info'), request('transaction'));
            $transaction->fill(array_merge( request('transaction'),  $owner_transaction_details))->save();
            $transaction->business_info->fill($business_info)->save();

            // retrieve all lines of business by transaction
            // if empty  disregard
            $permit_business_lines = BusinessActivity::where('application_business_permit_id', $transaction->business_permit_id)->get(['id']);

            // handle edit of existing line of businesses
            if($permit_business_lines){
            	BusinessActivity::destroy($permit_business_lines->toArray());
            }
        	foreach ($request->line_of_business as $key => $v) {
	            $data = [
	                'application_business_permit_id' => $transaction->business_permit_id,
	                'line_of_business' => $request->line_of_business [$key],
	                'no_of_unit' => $request->no_of_units [$key],
	                'capitalization' => $request->amount [$key],
	                //'gross_sales' => $new_business_permit->type == "renew" && !$request->is_new [$key] ? $request->amount [$key] : 0,
	            ];
	            BusinessActivity::insert($data);
        	}

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Changes has been saved");
            return redirect(route('system.business_transaction.show', ['id' => $id]));
        }catch(\Throwable $e){
            DB::rollback();
            Log::error('TRANSACTION_EDIT_FAILED', ['message' => $e->getMessage()]);
            throw $e;
            session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
        }
    }

    public function retrieve_lobs(){
        $response = Curl::to(env('OBOSS_GET_LINE_OF_BUSINESS'))
        ->withData($this->data)
        ->asJson(true)
        ->returnResponseObject()
        ->get();

        if ($response->status == "200") {
            foreach($response->content['data'] as $key => $lob){
                $this->data['line_of_businesses'][$lob['BClass']."---".$lob['SClass']."---".($lob['XClass'] ? $lob['XClass']:"0")."---".$lob['AcctCode']] = $lob['Class'];
                $this->data['line_of_businesses_coded'][$lob['BClass']."---".$lob['SClass']."---".($lob['XClass'] ? $lob['XClass']:"0")."---".$lob['AcctCode']] = $lob;
                if(!empty($lob['Class'])){
                    $particulars = !empty($lob['Particulars']) ? " (".$lob['Particulars'].")" : "";
                    $this->data['lob'][] = $lob['Class'].$particulars;
                }
            }
        }else{
            Log::error('API_GET_LOB_FAILED', ['response' => $response]);
        }
    }

    public function update_status($id = null){
        $business_transaction = BusinessTransaction::find($id);
        $business_transaction->isNew = null;
        $business_transaction->save();
    }

	public function process($id = NULL,PageRequest $request){

		$type = strtoupper($request->get('status_type'));
		DB::beginTransaction();
		try{
			$transaction = $request->get('business_transaction_data');
			$transaction->status = $type;
			$transaction->remarks = $type == "DECLINED" ? $request->get('remarks') : NULL;
			$transaction->processor_user_id = Auth::user()->id;
			$transaction->status = $type;
			$transaction->modified_at = Carbon::now();
			$transaction->processed_at = Carbon::now();
            $transaction->save();

            $transaction->application_permit->status =  strtolower($type);
            $transaction->application_permit->save();

			if ($type == "APPROVED") {

			    $insert[] = [
	            	'contact_number' => $transaction->owner ? $transaction->owner->contact_number : $transaction->contact_number,
	            	'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
	                'amount' => $transaction->total_amount,
	                'ref_num' => $transaction->code,
	                'full_name' => $transaction->owner ? $transaction->owner->full_name : $transaction->business_name,
	                'application_name' => $transaction->application_name,
                    'modified_at' => Helper::date_only($transaction->modified_at),
                    'business_id' => $transaction->business_id,
            	];
			    $notification_data_email = new SendEmailApprovedBusiness($insert);
			    Event::dispatch('send-email-business-approved', $notification_data_email);

			} else {

                $insert[] = [
                    'contact_number' => $transaction->owner ? $transaction->owner->contact_number : $transaction->contact_number,
                    'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
                    'ref_num' => $transaction->code,
                    'full_name' => $transaction->owner ? $transaction->owner->full_name : $transaction->business_name,
                    'application_name' => $transaction->application_name,
                    'modified_at' => Helper::date_only($transaction->modified_at),
                    'remarks' =>  $request->get('remarks'),
                ];


                $notification_data_email = new SendEmailDeclinedBusiness($insert);
                Event::dispatch('send-email-business-declined', $notification_data_email);
            }
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Transaction has been successfully Processed.");
			return redirect()->route('system.business_transaction.'.strtolower($type));
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
    }

    public function digital_cerficate(PageRequest $request,$id=NULL){
        $this->data['transaction'] = BusinessTransaction::find($id);
        $transaction = BusinessTransaction::find($id);
        $this->data['business_line'] = BusinessActivity::where('application_business_permit_id', 1)->get();
        $this->data['regulatory_fee'] = BusinessFee::where('transaction_id',1)->where('fee_type' , 0)->get();
        $this->data['business_tax'] = BusinessFee::where('transaction_id',1)->where('fee_type' , 1)->get();
        $insert[] = [
            'data' => $this->data,
            'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
        ];
        $notification_data_email = new SendEmailDigitalCertificate($insert);
        Event::dispatch('send-digital-business-permit', $notification_data_email);
    }

	public function remarks($id = NULL, RemarkBusinessTransactionRequest $request){
		DB::beginTransaction();
			$transaction = $request->get('business_transaction_data');

			$auth = Auth::user();
			$array_remarks = [];
			$dept_id = [];
	 		$value = $request->get('value');
            $status = $request->get('status');

	 		if ($transaction->department_remarks) {
	 			array_push($array_remarks, ['processor_id' => $auth->id ,'id' => $auth->department->code , 'remarks' => $value, 'status' => $status]);
	 			$existing = json_decode($transaction->department_remarks);
	 			$existing_id = json_decode($transaction->department_id);

	 			if ($transaction->department_id) {
	 				$a = array_search($auth->department->code, $existing_id);
	 				if ($a !== false) {
	 					$dept_id_final = $existing_id;
		 			}else{
		 				array_push($dept_id, $auth->department->code);
		 				$dept_id_final = array_merge($existing_id , $dept_id);
		 			}
	 			}else{
	 				array_push($dept_id, $auth->department->code);
	 				$dept_id_final = $dept_id;
	 			}


	 			$final_value = array_merge($existing , $array_remarks);
	 		}else{
	 			 array_push($array_remarks, ['processor_id' => $auth->id,'id' => $auth->department->code , 'remarks' => $value, 'status' => $status]);

	 			 array_push($dept_id, $auth->department->code);

	 			 $dept_id_final = $dept_id;
	 			 $final_value = $array_remarks;
	 		}
	 		$transaction->department_id = json_encode($dept_id_final);
			$transaction->department_remarks = json_encode($final_value);
			$transaction->save();

			$it_1 = json_decode($transaction->department_involved, TRUE);
		    $it_2 = json_decode($transaction->department_id, TRUE);
		    $result_array = array_diff($it_1,$it_2);

		    $insert_data[] = [
                'email' => $transaction->owner->email,
                'full_name' => $transaction->owner->full_name,
                'department_name' => $auth->department->name,
                'application_name' => $transaction->application_name,
                'remarks' => $value,
                'created_at' => Carbon::now(),
            ];

			$application_data = new SendEmailRemarks($insert_data);
		    Event::dispatch('send-email-remarks', $application_data);

		    if(empty($result_array)){
		    	$transaction->for_bplo_approval = 1;
		    	$transaction->bplo_approved_at = Carbon::now();
		    	$transaction->save();
		    }


			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Application Remarks has been saved.");
			return redirect()->route('system.business_transaction.show',[$transaction->id]);
	}

	public function bplo_validate($id = NULL , PageRequest $request){
		DB::beginTransaction();
		try{
			$status_type = $request->get('status_type');
			$type = $request->get('status_type') == 'validate' ? 'pending' : 'declined';

			$transaction = $request->get('business_transaction_data');
			$transaction->isNew = 1;
			$transaction->remarks = $status_type == "validate" ? NULL : $request->get('remarks');
			$transaction->modified_at = Carbon::now();

			if ($status_type == 'validate'){
				$transaction->is_validated = 1;
				$transaction->validated_at = Carbon::now();

				$department_id = Department::all();

				if (!$department_id) {
					session()->flash('notification-status', "failed");
					session()->flash('notification-msg', "No Department Found.");
					return redirect()->route('system.business_transaction.show',[$id]);
				}
				$dept_array = [];

				foreach ($department_id as $data) {
					array_push($dept_array, $data->id);
				}
				$transaction->department_involved = json_encode($dept_array);

				$department = User::whereIn('department_id', $dept_array)->get();

				if (count($department) == 0) {
					session()->flash('notification-status', "failed");
					session()->flash('notification-msg', "No Processor Found.");
					return redirect()->route('system.business_transaction.show',[$id]);
				}

				$insert = [];
				foreach ($department as $departments ) {
					$insert[] = [
						'contact_number' => $departments->contact_number,
						'email' => $departments->email,
						'department_name' => $departments->department->name,
						'application_no' => $transaction->application_permit->application_no,
					];
				}
				// send via Email
				$notification_data = new NotifyDepartmentEmail($insert);
				Event::dispatch('notify-departments-email', $notification_data);

				// Send via SMS
				//$notification_data = new NotifyDepartmentSMS($insert);
				//Event::dispatch('notify-departments-sms', $notification_data);

				session()->flash('notification-status', "success");
				session()->flash('notification-msg', "Transaction has been successfully validated.");

			} else {
				$transaction->status = "DECLINED";
				$transaction->application_permit->status =  "declined";
				$transaction->application_permit->save();
				$data = [
					'contact_number' => $transaction->owner ? $transaction->owner->contact_number : $transaction->contact_number,
					'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
					'ref_num' => $transaction->code,
					'full_name' => $transaction->owner ? $transaction->owner->full_name : $transaction->business_name,
					'application_name' => $transaction->application_name,
					'modified_at' => Helper::date_only($transaction->modified_at),
					'remarks' =>  $transaction->remarks,
				];

				$notification_data_email = new SendEmailDeclinedApplication($data);
				Event::dispatch('send-email-application-declined', $notification_data_email);

				session()->flash('notification-status', "success");
				session()->flash('notification-msg', "Transaction has been successfully declined.");
			}

			$transaction->save();
			DB::commit();

			return redirect()->route('system.business_transaction.'.strtolower($type));
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function assessment (PageRequest $request , $id = NULL){
		$auth = Auth::user();
		$this->data['page_title'] .= " - Assesment Details";

		$this->data['transaction'] = BusinessTransaction::find($id);
		$this->data['business_fees'] = Assessment::where('transaction_id',$id)->get();

		$existing_assessment = Assessment::where('transaction_id' , $id)->where('department_id', $auth->department_id)->first();
		if($existing_assessment){
			session()->flash('notification-status', "warning");
			session()->flash('notification-msg', "Assesment already existing for this department.");
			return redirect()->route('system.business_transaction.show',$id);
		}

		return view('system.business-transaction.assessment',$this->data);
	}

	public function get_assessment(AssessmentRequest $request , $id = NULL){
		DB::beginTransaction();
		try{

			$auth = Auth::user();
			$this->data['transaction'] = BusinessTransaction::find($id);


			$new_assessment = new Assessment();
			$new_assessment->transaction_id = $id;
			$new_assessment->department_id = Auth::user()->department_id;
			$new_assessment->cedula = $request->get('cedula');
			$new_assessment->bfp_fee = $request->get('bfp_fee');
			$new_assessment->brgy_fee = $request->get('brgy_fee');
			$new_assessment->total_amount = $request->get('total_amount');

            if ($request->file('file')) {
				$ext = $request->file('file')->getClientOriginalExtension();
				$image = $request->file('file');

				if($ext == 'pdf' || $ext == 'docx' || $ext == 'doc' || $ext == 'xlsx'){
					$type = 'file';
					$original_filename = $request->file('file')->getClientOriginalName();
					$upload_image = FileUploader::upload($image, 'uploads/transaction/assessment/'.$id);
				}
				if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){
					$type = 'image';
					$original_filename = $request->file('file')->getClientOriginalName();
					$upload_image = ImageUploader::upload($image, 'uploads/transaction/assessment/'.$id);
				}
				$new_assessment->path = $upload_image['path'];
				$new_assessment->directory = $upload_image['directory'];
				$new_assessment->filename = $upload_image['filename'];
				$new_assessment->type =$type;
				$new_assessment->original_name =$original_filename;
			}

            $new_assessment->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Assesment successfully added.");
			return redirect()->route('system.business_transaction.show',$id);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}

	}

	public function release(PageRequest $request , $id = NULL){
		DB::beginTransaction();
		try{
			$transaction = $request->get('business_transaction_data');
			$transaction->digital_certificate_released = "1";
			$transaction->save();

			$insert[] = [
	        	'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
	            'business_name' => $transaction->business_info ? $transaction->business_info->business_name : $transaction->business_name,
	            'business_id' => $transaction->business_id,
	            'link' => env("APP_URL")."e-permit/".$transaction->business_id,
	    	];

		    $notification_data_email = new SendEmailDigitalCertificate($insert);
		    Event::dispatch('send-digital-business-permit', $notification_data_email);

		    DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Certificate has been successfully released.");
			return redirect()->route('system.business_transaction.show',[$id]);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
    }

    public function read_all_notifs(){
        DB::beginTransaction();
        try{
            $businesses = Business::where('isNew' , 1)->get();
            $business_transaction = BusinessTransaction::where('isNew' , 1)->get();
            foreach($businesses as $b){
                $b->isNew = 0;
                $b->save();
            }
            foreach($business_transaction as $bs){
                $bs->isNew = 0;
                $bs->save();
            }
            DB::commit();
            return redirect()->back();
        }catch(\Throwable $e){
            DB::rollback();
            return redirect()->back();
        }
    }

    public function bulk_decline(PageRequest $request){
    	DB::beginTransaction();
    	try{
	    	$application_business_permit_id = [];

	    	foreach (explode(",", $request->get('application_no')) as $key => $value) {
	    		$app = ApplicationBusinessPermit::where('application_no', trim($value))->first();
				if ($app) {
					array_push($application_business_permit_id, $app->id);
				}
			}
			foreach ($application_business_permit_id as $key => $value) {
				$data = BusinessTransaction::where('business_permit_id', $value)->where('status',"PENDING")->first();
				if ($data) {
					$data->status = "DECLINED";
					$data->modified_at = Carbon::now();
					$data->remarks = $request->get('remarks');
					$data->update();

					$data->application_permit->status =  "declined";
					$data->application_permit->update();

					$transaction_data = [
						'contact_number' => $data->owner ? $data->owner->contact_number : $data->contact_number,
						'email' => $data->owner ? $data->owner->email : $data->email,
						'ref_num' => $data->code,
						'full_name' => $data->owner ? $data->owner->full_name : $data->business_name,
						'application_name' => $data->application_name,
						'modified_at' => Helper::date_only($data->modified_at),
						'remarks' =>  $data->remarks,
					];

					$notification_data_email = new SendEmailDeclinedApplication($transaction_data);
					Event::dispatch('send-email-application-declined', $notification_data_email);
				}
			}
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "successfully declined transactions");
			return redirect()->route('system.business_transaction.declined');
		}catch(\Throwable $e){
            DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
        }
    }

  	public function download (PageRequest $request , $id = NULL){

        $transaction = BusinessTransaction::find($id);
        $this->data['business'] = Business::find($transaction->business_id);
        $this->data['application'] = ApplicationBusinessPermit::find($transaction->business_permit_id);
        $this->data['activities'] = BusinessActivity::where('application_business_permit_id', $this->data['application']->id)->get();

        $customPaper = array(0,0,700.00,1200);
        $pdf = PDF::loadView('pdf.permit-application',$this->data)->setPaper($customPaper);

        return $pdf->download("permit-application.pdf");

    }

}
