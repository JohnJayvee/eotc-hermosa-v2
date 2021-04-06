@extends('system._layouts.main')

@section('content')
<div class="row px-5 py-4">
  <div class="col-12">
    @include('system._components.notifications')
    <div class="row ">
      <div class="col-md-6">
        <h5 class="text-title text-uppercase">{{$page_title}}</h5>
      </div>
      <div class="col-md-6 ">
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Transactions / Transaction Details</p>
      </div>
    </div>
  </div>
  <div class="col-12 pt-4">
    <div class="card card-rounded shadow-sm mb-4">
      <div class="card-body" style="border-bottom: 3px dashed  #E3E3E3;">
        <div class="row">
          <div class="col-md-1 text-center">
            <img src="{{asset('system/images/default.jpg')}}" class="rounded-circle" width="100%">
          </div>
          <div class="col-md-9 d-flex">
            <p class="text-title fw-500 pt-3">Application by: <span class="text-black">{{Str::title($transaction->customer ? $transaction->customer->full_name : $transaction->customer_name)}}</span></p>
            <p class="text-title fw-500 pl-3" style="padding-top: 15px;">|</p>
            <p class="text-title fw-500 pt-3 pl-3">Application Sent: <span class="text-black">{{ Helper::date_format($transaction->created_at)}}</span></p>
          </div>
          <div class="col-md-2 d-flex align-items-end flex-column">
            <p class="pull-right badge badge-danger">Checked the I Agree Checkbox</p>
            <!-- <a href="{{ route('system.business_transaction.digital_cerficate', ['id' => $transaction->id]) }}" class="badge badge-info" target="_blank">Release Digital Certificate</a> -->
            @if($transaction->digital_certificate_released == "0" and $transaction->payment_status == "PAID" and $transaction->status == "APPROVED")
              <a class="badge badge-info btn-certificate" href="#" >Release Digital Certificate</a>
            @endif
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p class="text-title fw-500" style="font-size: 1.2rem;">Application Number: <span class="text-black">{{str::title($transaction->application_permit->application_no)}}</span></p>
            <p class="text-title fw-500">Business Name: <span class="text-black">{{str::title($transaction->business_name)}}</span></p>
            <p class="text-title fw-500">Dominant Name: <span class="text-black">{{str::title($transaction->business_info->dominant_name)}}</span></p>
            <p class="text-title fw-500">Business Number: <span class="text-black">{{$transaction->business_info->dti_sec_cda_registration_no ?: "-"}}</span></p>
            <p class="text-title fw-500">Business Type: <span class="text-black">{{str::title(str_replace("_"," ", $transaction->business_info->business_type))}}</span></p>
            <p class="text-title fw-500">Business Scope: <span class="text-black">{{str::title($transaction->business_info->business_scope)}}</span></p>
          </div>
        </div>
      </div>
    </div>
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <h4>Application No.: <b>{{str::title($transaction->application_permit->application_no)}}</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                  <label for="exampleInputEmail1" class="text-form">Business Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control {{ $errors->first('transaction.business_name') ? 'is-invalid': NULL  }}"  name="transaction[business_name]" value="{{old('transaction.business_name', str::title($transaction->business_name) ?? '') }}">
                  @include('system.business-transaction.error', ['error_field' => 'transaction.business_name'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Trade Name / Franchise<span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.tradename') ? 'is-invalid': NULL  }}"  name="business_info[tradename]" value="{{old('business_info.tradename', str::title($transaction->business_info->tradename) ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.tradename'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">DTI/SEC/CDA registration No. <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.dti_sec_cda_registration_no') ? 'is-invalid': NULL  }}"  name="business_info[dti_sec_cda_registration_no]" value="{{old('business_info.dti_sec_cda_registration_no', $transaction->business_info->dti_sec_cda_registration_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.dti_sec_cda_registration_no'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Business Scope</label>
                {!!Form::select("business_info[business_scope]", $business_scopes, old('business_info.business_scope', $transaction->business_info->business_scope), ['id' => "input_business_scope", 'class' => "form-control classic ".($errors->first('business_info.business_scope') ? 'border-red' : NULL)])!!}
                @include('system.business-transaction.error', ['error_field' => 'business_info[business_scope]'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Cedula No. <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.ctc_no') ? 'is-invalid': NULL  }}"  name="business_info[ctc_no]" value="{{old('business_info.ctc_no', str::title($transaction->business_info->ctc_no) ?? '') }}">
              </div>
            </div> 
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Business Type</label>
                {!!Form::select("business_info[business_type]", $business_types, old('business_info.business_type' , $transaction->business_info->business_type), ['id' => "input_business_type", 'class' => "form-control form-control classic ".($errors->first('business_info.business_type') ? 'border-red' : NULL)])!!}
                @include('system.business-transaction.error', ['error_field' => 'business_info[business_type]'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="text-form pb-2">Exact Location <span class="text-danger">*</span></label>
                    <input type="text" id="map-address" class="form-control form-control-sm {{ $errors->first('business_info.location') ? 'is-invalid': NULL  }}"  name="business_info[location]" value="{{old('business_info.location' , $transaction->business_info->location) }}">
                    @include('system.business-transaction.error', ['error_field' => 'business_info.location'])
                    <input type="hidden" name="business_info[geo_long]" id="geo_long" value="{{ old('business_info.geo_long') }}">
                    <input type="hidden" name="business_info[geo_lat]" id="geo_lat" value="{{ old('business_info.geo_lat') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="map" class="card-shadow mt-3"></div>
            </div>
        </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Business TIN <span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.business_tin') ? 'is-invalid': NULL  }}"  name="business_info[business_tin]" value="{{old('business_info.business_tin', $transaction->business_info->business_tin ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.business_tin'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Business Mobile No. <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.mobile_no') ? 'is-invalid': NULL  }}"  name="business_info[mobile_no]" value="{{old('business_info.mobile_no', $transaction->business_info->mobile_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.mobile_no'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Business Tel No.</label>
                <input type="text" class="form-control {{ $errors->first('business_info.telephone_no') ? 'is-invalid': NULL  }}"  name="business_info[telephone_no]" value="{{old('business_info.telephone_no', $transaction->business_info->telephone_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.telephone_no'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Business Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.email') ? 'is-invalid': NULL  }}"  name="business_info[email]" value="{{old('business_info.email', $transaction->business_info->email ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.email'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Capitalization <span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.capitalization') ? 'is-invalid': NULL  }}"  name="business_info[capitalization]" value="{{old('business_info.capitalization', $transaction->business_info->capitalization ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.capitalization'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Dominant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.dominant_name') ? 'is-invalid': NULL  }}"  name="business_info[dominant_name]" value="{{old('business_info.dominant_name', str::title($transaction->business_info->dominant_name) ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.dominant_name'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">DTI/SEC/CDA Registration Date (MM/DD/YYYY) <span class="text-danger">*</span></label>
                <input type="date" class="form-control  {{ $errors->first('business_info.dti_sec_cda_registration_date') ? 'is-invalid': NULL  }}"  name="business_info[dti_sec_cda_registration_date]" value="{{old('business_info.dti_sec_cda_registration_date', str::title($transaction->business_info->dti_sec_cda_registration_date) ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.dti_sec_cda_registration_date'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">No. of Male Employees <span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.no_of_male_employee') ? 'is-invalid': NULL  }}"  name="business_info[no_of_male_employee]" value="{{old('business_info.no_of_male_employee.', $transaction->business_info->no_of_male_employee ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.no_of_male_employee'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">No. of Male Employees residing in city<span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.male_residing_in_city') ? 'is-invalid': NULL  }}"  name="business_info[male_residing_in_city]" value="{{old('business_info.male_residing_in_city', $transaction->business_info->male_residing_in_city ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.male_residing_in_city'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">No. of Female Employees <span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.no_of_female_employee') ? 'is-invalid': NULL  }}"  name="business_info[no_of_female_employee]" value="{{old('business_info.no_of_female_employee', $transaction->business_info->no_of_female_employee ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.no_of_female_employee'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1" class="text-form">No. of Female Employees residing in city<span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.female_residing_in_city') ? 'is-invalid': NULL  }}"  name="business_info[female_residing_in_city]" value="{{old('business_info.female_residing_in_city', $transaction->business_info->female_residing_in_city ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.female_residing_in_city'])
              </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                <label for="exampleInputEmail1" class="text-form">Business Area (Sq. m)<span class="text-danger">*</span></label>
                <input type="text" class="form-control  {{ $errors->first('business_info.business_area') ? 'is-invalid': NULL  }}"  name="business_info[business_area]" value="{{old('business_info.business_area', $transaction->business_info->business_area ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.business_area'])
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group d-flex flex-row my-1">
                      <label for="" class="text-form pb-2 col-md-6">Are you enjoying tax incentive from any Goverment Entity?</label>
                      <div class="form-check form-check-inline">
                          <input class="form-control" type="checkbox" name="checkbox" value="yes" style="width: 30px; height: 30px;" {{ ($transaction->business_info->tax_incentive == null ?: ($transaction->business_info->tax_incentive == "no" ? '' : 'checked')) }}>
                          <label class="my-2 mx-1" for="inlineCheckbox1">YES</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-control" type="checkbox" name="checkbox" value="no" style="width: 30px; height: 30px;" {{ $transaction->business_info->tax_incentive == "no" ? 'checked' : " " }}>
                          <label class="my-2 mx-1" for="inlineCheckbox3">NO</label>
                      </div>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group" id="checkYes">
                      <label class="text-form pb-2">Please Specify entity:</label>
                      <input type="text" class="form-control" name="business_info[tax_incentive]" value="{{$transaction->business_info->tax_incentive != 'no' ? $transaction->business_info->tax_incentive : ' '}}">
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group d-flex flex-row my-1">
                      <label for="" class="text-form pb-2 col-md-6">Does your establishment has a septic tank or connected to a septic tank?</label>
                      <div class="form-check form-check-inline">
                          <input class="form-control" type="checkbox" name="business_info[has_septic_tank]" value="yes" style="width: 30px; height: 30px;" {{ $transaction->business_info->has_septic_tank == "yes" ? 'checked' : " " }}>
                          <label class="my-2 mx-1" for="inlineCheckbox1">YES</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-control" type="checkbox" name="business_info[has_septic_tank]" value="no" style="width: 30px; height: 30px;" {{ $transaction->business_info->has_septic_tank == "no" ? 'checked' : " " }}>
                          <label class="my-2 mx-1" for="inlineCheckbox3">NO</label>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <h5 class="text-title text-uppercase">Other Information Form (Government Owned Or Controlled Corporations)</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Tin No.</label>
                <input type="text" class="form-control  {{ $errors->first('business_info.tin_no') ? 'is-invalid': NULL  }}"  name="business_info[tin_no]" value="{{old('business_info.tin_no', $transaction->business_info->tin_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info[tin_no]'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Philhealth No.</label>
                <input type="text" class="form-control  {{ $errors->first('business_info.philhealth_no') ? 'is-invalid': NULL  }}"  name="business_info[philhealth_no]" value="{{old('business_info.philhealth_no', $transaction->business_info->philhealth_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.philhealth_no'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">SSS No.</label>
                <input type="text" class="form-control  {{ $errors->first('business_info.sss_no') ? 'is-invalid': NULL  }}"  name="business_info[sss_no]" value="{{old('business_info.sss_no', $transaction->business_info->sss_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.sss_no'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">PAGIBIG No.</label>
                <input type="text" class="form-control  {{ $errors->first('business_info[pagibig_no]') ? 'is-invalid': NULL  }}"  name="business_info[pagibig_no]" value="{{old('business_info.pagibig_no', $transaction->business_info->pagibig_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.pagibig_no'])
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <p class="text-title fw-500">Line of Business :</p>
              <table  id="tr-wrapper" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Line of Business</th>
                    <th>NO. Units</th>
                    <th>Gross Sales/ Capitalization</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="repeat_form">
                  @forelse($business_line as $index => $value)
                    <tr class="activity">
                        <td>
                          <input type="text" class="form-control business-line {{ $errors->has("line_of_business.{$index}") ? 'is-invalid': NULL  }}" name="line_of_business[]" value="{{old('line_of_business.{$index}',$value->line_of_business)}}">
                        </td>
                        <td>
                          <input type="text" class="form-control business-line {{ $errors->has("no_of_units.{$index}") ? 'is-invalid': NULL  }}" name="no_of_units[]" value="{{ old("no_of_units.{$index}",$value->no_of_unit) }}" placeholder="{{ $errors->first("no_of_units.{$index}") }}">
                        </td>
                        <td>
                          <input type="text" class="form-control business-line {{ $errors->has("amount.{$index}") ? 'is-invalid': NULL  }}" name="amount[]" value="{{ old("amount.{$index}",$value->capitalization) }}" placeholder="{{ $errors->first("amount.{$index}") }}">
                        </td>
                        @if($index > 0)
                        <td>
                            <button type="button" class="btn btn-xs btn-remove"><i class="fas fa-trash text-danger"></i></button>
                        </td>
                        @endif
                    </tr>
                   
                  @empty                
                  @endforelse
                  @if(old('line_of_business'))
                    @foreach(range(1, old('line_of_business') ? count(old('line_of_business')) - count($business_line) : 1 ) as $index => $value)
                      <?php $item = $index + count($business_line); ?>
                      <tr class="activity">
                          <td>
                              <input type="text" class="form-control {{ $errors->has("line_of_business.{$item}") ? 'is-invalid': NULL  }}" name="line_of_business[]" value="{{old("line_of_business.{$item}")}}" placeholder="{{ $errors->first("line_of_business.{$item}") }}">
                          </td>
                          <td>
                              <input type="text" class="form-control {{ $errors->has("no_of_units.{$item}") ? 'is-invalid': NULL  }}" name="no_of_units[]" value="{{ old("no_of_units.{$item}") }}" placeholder="{{ $errors->first("no_of_units.{$item}") }}">
                          </td>
                          <td>
                              <input type="text" class="form-control {{ $errors->has("amount.{$item}") ? 'is-invalid': NULL  }}" name="amount[]" value="{{ old("amount.{$item}") }}" placeholder="{{ $errors->first("amount.{$item}") }}">
                          </td>
                          <td>
                            <button type="button" class="btn btn-xs btn-remove"><i class="fas fa-trash text-danger"></i></button>
                          </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
              <div class="text-right">
                <button class="btn btn-primary btn-xs mt-2 border-5 text-white" id="repeater_add_activity" type="button"><i class="fa fa-plus mr-2"></i>Add Line of Business</button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's First Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_fname') ? 'is-invalid': NULL  }}"  name="business_info[owner_fname]" value="{{old('business_info.owner_fname', str::title($transaction->business_info->owner_fname) ?? '') }}" autocomplete="none">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_fname'])
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Middle Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_mname') ? 'is-invalid': NULL  }}"  name="business_info[owner_mname]" value="{{old('business_info.owner_mname', str::title($transaction->business_info->owner_mname) ?? '') }}" autocomplete="none">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_mname'])
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Last Name  </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_lname') ? 'is-invalid': NULL  }}"  name="business_info[owner_lname]" value="{{old('business_info.owner_lname', str::title($transaction->business_info->owner_lname) ?? '') }}" autocomplete="none">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_lname'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Email  </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_email') ? 'is-invalid': NULL  }}"  name="business_info[owner_email]" value="{{old('business_info.owner_email', str::title($transaction->business_info->owner_email) ?? '') }}" autocomplete="none">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_email'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Contact No.  </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_mobile_no') ? 'is-invalid': NULL  }}"  name="business_info[owner_mobile_no]" value="{{old('business_info.owner_mobile_no', str::title($transaction->business_info->owner_mobile_no) ?? '') }}" autocomplete="none">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_mobile_no'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's TIN  </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_tin') ? 'is-invalid': NULL  }}"  name="business_info[owner_tin]" value="{{old('business_info.owner_tin', str::title($transaction->business_info->owner_tin) ?? '') }}" autocomplete="none">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_tin'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Unit No </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_unit_no') ? 'is-invalid': NULL  }}"  name="business_info[owner_unit_no]" value="{{old('business_info.owner_unit_no', $transaction->business_info->owner_unit_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_unit_no'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Street </label>
                <input type="text" class="form-control {{ $errors->first('business_info.owner_street') ? 'is-invalid': NULL  }}"  name="business_info[owner_street]" value="{{old('business_info.owner_street', $transaction->business_info->owner_street ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_street'])
              </div>
            </div>
             <input type="hidden" class="form-control" name="business_info[owner_brgy_name]" id="input_owner_brgy_name" value="{{old('business_info.owner_brgy' ,  $transaction->business_info->owner_brgy )}}">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Owner's Barangay</label>
                {!!Form::select('business_info[owner_brgy]',[],old('business_info.owner_brgy' ,$transaction->business_info->owner_brgy),['id' => "input_owner_brgy",'class' => "form-control form-control classic ".($errors->first('business_info.owner_brgy') ? 'border-red' : NULL)])!!}
                @include('system.business-transaction.error', ['error_field' => 'business_info.owner_brgy'])
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-6">
               <p class="text-title fw-500">Authorize Representative:</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Representative First Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.rep_firstname') ? 'is-invalid': NULL  }}"  name="business_info[rep_firstname]" value="{{old('business_info.rep_firstname', str::title($transaction->business_info->rep_firstname) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Representative Middle Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.rep_middlename') ? 'is-invalid': NULL  }}"  name="business_info[rep_middlename]" value="{{old('business_info.rep_middlename', str::title($transaction->business_info->rep_middlename) ?? '') }}" autocomplete="none">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Representative Last Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.rep_lastname') ? 'is-invalid': NULL  }}"  name="business_info[rep_lastname]" value="{{old('business_info.rep_lastname', str::title($transaction->business_info->rep_lastname) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Representative Gender</label>
                <select name="business_info[rep_gender]" id="rep_gender" class="form-control">
                  <option value="" {{ !empty($transaction->business_info->rep_gender) ?: 'selected'   }}>  -- CHOOSE GENDER --  </option>
                  <option value="male" {{ old( 'business_info.rep_gender', $transaction->business_info->rep_gender) == "male" ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old( 'business_info.rep_gender', $transaction->business_info->rep_gender) == "female" ? 'selected' : '' }}>Female</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Representative Position <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->first('business_info.rep_position') ? 'is-invalid': NULL  }}"  name="business_info[rep_position]" value="{{old('business_info.rep_position', str::title($transaction->business_info->rep_position) ?? '') }}" autocomplete="none">
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-6">
              <p class="text-title fw-500">Lessor Details:</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_fullname') ? 'is-invalid': NULL  }}"  name="business_info[lessor_fullname]" value="{{old('business_info.lessor_fullname', str::title($transaction->business_info->lessor_fullname) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Gender</label>
                <select name="business_info[lessor_gender]" id="lessor_gender" class="form-control">
                  <option value="" {{ !empty($transaction->business_info->lessor_gender) ?: 'selected'   }}>  -- CHOOSE GENDER --  </option>
                  <option value="male" {{ old( 'business_info.lessor_gender', $transaction->business_info->lessor_gender) == "male" ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old( 'business_info.lessor_gender', $transaction->business_info->lessor_gender) == "female" ? 'selected' : '' }}>Female</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Monthly Rental </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_monthly_rental') ? 'is-invalid': NULL  }}"  name="business_info[lessor_monthly_rental]" value="{{old('business_info.lessor_monthly_rental', str::title($transaction->business_info->lessor_monthly_rental) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Start Date of Rental (MM/DD/YYYY)</label>
                <input type="date" class="form-control {{ $errors->first('business_info.lessor_rental_date') ? 'is-invalid': NULL  }}"  name="business_info[lessor_rental_date]" value="{{old('business_info.lessor_rental_date', str::title($transaction->business_info->lessor_rental_date) ?? '') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Email </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_email') ? 'is-invalid': NULL  }}"  name="business_info[lessor_email]" value="{{old('business_info.lessor_email', str::title($transaction->business_info->lessor_email) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Mobile No. </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_mobile_no') ? 'is-invalid': NULL  }}"  name="business_info[lessor_mobile_no]" value="{{old('business_info.lessor_mobile_no', str::title($transaction->business_info->lessor_mobile_no) ?? '') }}" autocomplete="none">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Tel No. </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_tel_no') ? 'is-invalid': NULL  }}"  name="business_info[lessor_tel_no]" value="{{old('business_info.lessor_tel_no', str::title($transaction->business_info->lessor_tel_no) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Unit No </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_unit_no') ? 'is-invalid': NULL  }}"  name="business_info[lessor_unit_no]" value="{{old('business_info.lessor_unit_no', $transaction->business_info->lessor_unit_no ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.lessor_unit_no'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Region</label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_region_name') ? 'is-invalid': NULL  }}"  name="business_info[lessor_region_name]" value="{{old('business_info.lessor_region_name',strtoupper($transaction->business_info->lessor_region_name) ?? '') }}" disabled>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Province/Town</label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_town_name') ? 'is-invalid': NULL  }}"  name="business_info[lessor_town_name]" value="{{old('business_info.lessor_town_name', $transaction->business_info->lessor_town_name ?? '') }}" disabled>
              </div>
            </div>
          </div>
          <input type="hidden" class="form-control" name="business_info[lessor_brgy_name]" id="input_lessor_brgy_name" value="{{old('business_info.lessor_brgy_name' ,  $transaction->business_info->lessor_brgy_name )}}">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Barangay</label>
                {!!Form::select('business_info[lessor_brgy]',[],old('business_info.lessor_brgy' ,$transaction->business_info->lessor_brgy),['id' => "input_lessor_brgy",'class' => "form-control form-control classic ".($errors->first('business_info.lessor_brgy') ? 'border-red' : NULL)])!!}
                @include('system.business-transaction.error', ['error_field' => 'business_info.lessor_brgy'])
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Lessor Street </label>
                <input type="text" class="form-control {{ $errors->first('business_info.lessor_street_address') ? 'is-invalid': NULL  }}"  name="business_info[lessor_street_address]" value="{{old('business_info.lessor_street_address', $transaction->business_info->lessor_street_address ?? '') }}">
                @include('system.business-transaction.error', ['error_field' => 'business_info.lessor_street_address'])
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <p class="text-title fw-500">Emergency Contact:</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Name </label>
                <input type="text" class="form-control {{ $errors->first('business_info.emergency_contact_fullname') ? 'is-invalid': NULL  }}"  name="business_info[emergency_contact_fullname]" value="{{old('business_info.emergency_contact_fullname', str::title($transaction->business_info->emergency_contact_fullname) ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Email </label>
                <input type="text" class="form-control {{ $errors->first('business_info.emergency_contact_email') ? 'is-invalid': NULL  }}"  name="business_info[emergency_contact_email]" value="{{old('business_info.emergency_contact_email', ucfirst($transaction->business_info->emergency_contact_email) ?? '') }}" autocomplete="none">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Mobile No.</label>
                <input type="text" class="form-control {{ $errors->first('business_info.emergency_contact_mobile_no') ? 'is-invalid': NULL  }}"  name="business_info[emergency_contact_mobile_no]" value="{{old('business_info.emergency_contact_mobile_no', $transaction->business_info->emergency_contact_mobile_no ?? '') }}" autocomplete="none">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group my-1">
                <label for="exampleInputEmail1" class="text-form">Tel No. </label>
                <input type="text" class="form-control {{ $errors->first('business_info.emergency_contact_tel_no') ? 'is-invalid': NULL  }}"  name="business_info[emergency_contact_tel_no]" value="{{old('business_info.emergency_contact_tel_no', str::title($transaction->business_info->emergency_contact_tel_no) ?? '') }}" autocomplete="none">
              </div>
            </div>
          </div>
          <button class="btn btn-primary mt-4 border-5 text-white" type="submit"><i class="fas fa-info-circle"></i> Update Information</button>
          <a class="btn btn-danger mt-4 border-5 text-white" href="{{ route('system.business_transaction.show', $transaction->id) }}"><i class="fas fa-ban"></i> Cancel</a>
        </form>
        
      </div>
    </div>
  </div>

</div>
@stop



@section('page-styles')
<!-- <link rel="stylesheet" href="{{asset('system/vendors/sweet-alert2/sweetalert2.min.css')}}"> -->
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css" >
  .input-daterange input{ background: #fff!important; }
  .isDisabled{
    color: currentColor;
    display: inline-block;  /* For IE11/ MS Edge bug */
    pointer-events: none;
    text-decoration: none;
    cursor: not-allowed;
    opacity: 0.5;
  }
  .is-invalid{
    border: solid 2px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    font-size: 18px;
  }
  span.select2.select2-container{
    width: 100% !important;
  }
  textarea.swal2-textarea {
    width: 25em;
  }
  #map {
    height: 400px !important;
    width: 100% !important; 
  }
</style>
@stop

@section('page-scripts')
<script src="{{asset('system/vendors/swal/sweetalert.min.js')}}"></script>
<!-- <script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script> -->
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('system/vendors/locationpicker/locationpicker.jquery.js')}}" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?v=3&libraries=places&key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
<script type="text/javascript">

  $.fn.get_brgy = function (munc_code, input_brgy, selected) {
    $(input_brgy).empty().prop('disabled', true);
    $(input_brgy).append($('<option>', {
      value: "",
      text: "Loading Content..."
    }));
    $.getJSON("{{env('PSGC_BRGY_URL')}}?city_code=" + munc_code, function (data) {
      $(input_brgy).empty().prop('disabled', true);

      $.each(data, function (index, value) {
        $(input_brgy).append($('<option>', {
          value: index,
          text: value.desc,
          "data-zip_code": (value.zip_code).trim()
        }));
      })
      $(input_brgy).prop('disabled', false)
      if(input_brgy == '#input_lessor_brgy'){
        $(input_brgy).prepend($('<option>', {
          value: "{!!  $transaction->business_info->lessor_brgy !!}",
          text: "{!! $transaction->business_info->lessor_brgy_name !!}"
        }))
      }else if(input_brgy == '#input_owner_brgy'){
        var _old = "{!!  $transaction->business_info->owner_brgy !!}";
        if(_old != null){
          $(input_brgy).prepend($('<option>', {
            value: "{!!  $transaction->business_info->owner_brgy !!}",
            text: "{!! $transaction->business_info->owner_brgy_name !!}"
          }))
        }
      }else{
        $(input_brgy).prepend($('<option>', {
          value: "{!!  $transaction->business_info->brgy !!}",
          text: "{!! $transaction->business_info->brgy_name !!}"
        }))
      }
      if (selected.length > 0) {
        $(input_brgy).val($(input_brgy + " option[value=" + selected + "]").val());

        if (typeof $(input_brgy + " option[value=" + selected + "]").data('zip_code') === undefined) {
          $(input_brgy.replace("brgy", "zipcode")).val("")
        } else {
          $(input_brgy.replace("brgy", "zipcode")).val($(input_brgy + " option[value=" + selected + "]").data('zip_code'))
        }
      }else {
        $(input_brgy).val($(input_brgy + " option:first").val());
          // only show select barangay if we it's for owner detail input
        if(input_brgy == "#input_owner_brgy"){
          $(input_brgy).prepend($('<option>', {
          value: "",
          text: " --- SELECT BARANGAY --- "
          }))
        }
      }
    });
  }
  
  $(function(){
    load_lessor_barangay();
    load_owner_barangay();

    $('#map-address').on('click',function(){
        $(this).val('');
    })
    $('#states').text( $("#map-address").val())
    $('#postcode').text( $("#map-address").val())

    function updateControls(addressComponents) {
        $('#postcode').val(addressComponents.postalCode);       
    }

    $('#map').locationpicker({
      location: {
        latitude:  {{$transaction->business_info->geo_lat ?: 14.6741}},
        longitude: {{$transaction->business_info->geo_long ?: 120.5113}}
      },
      zoom: 15,
      radius: 0,
      mapTypeId: 'satellite',

      inputBinding : {
          locationNameInput: $('#map-address'),
          latitudeInput: $('#geo_lat'),
          longitudeInput: $('#geo_long'),
      },
      enableAutocomplete: true,
      autocompleteOptions: {
        componentRestrictions: {country: 'ph'}
      },
      onchanged: function (currentLocation, isMarkerDropped) {
        var addressComponents = $(this).locationpicker('map').location.addressComponents;
        updateControls(addressComponents);
      },
      oninitialized: function(component) {
        var addressComponents = $(component).locationpicker('map').location.addressComponents;
        updateControls(addressComponents);
      }
    });

    $('input[name="checkbox"]').on('change', function () {
      $('input[name="checkbox"]').not(this).prop('checked', false);
      if($(this).val() == 'yes'){
        $('input[name="business_info[tax_incentive]"]').val('');
        $('#checkYes').show();
      }
      if($(this).val() == 'no'){
        $('#checkYes').hide();
        $('input[name="business_info[tax_incentive]"]').val('no');
      }
    });
    @if($transaction->business_info->tax_incentive == "no")
      $('#checkYes').hide();
    @else
      $('#checkYes').show();
    @endif
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });


    $("#repeat_form").delegate(".btn-remove","click",function(){
      var parent_div = $(this).parents(".activity");
      parent_div.fadeOut(500,function(){
        $(this).remove();
      })
    });

    $('#repeater_add_activity').on('click', function(){
      var repeat_item = $("#repeat_form tr").eq(0).prop('outerHTML');
      var main_holder = $(this).parents("tr").parent();
    $("#repeat_form").append(repeat_item).find("tr:last").append('<td> <button type="button" class="btn btn-xs btn-remove"><i class="fas fa-trash text-danger"></i></button> </td>').find(".business-line" ).val('')
    });

    function load_lessor_barangay() {
        var _val = "097332000";
        var _text = "ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA";
        $(this).get_brgy(_val, "#input_lessor_brgy", "");
        $('#input_lessor_zipcode').val('');
        $('#input_lessor_town_name').val(_text);
    }

    function load_owner_barangay() {
        var _val = "097332000";
        var _text = "ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA";
        $(this).get_brgy(_val, "#input_owner_brgy", "");
    }

    $('input[name="business_info[has_septic_tank]"]').on('change', function () {
      $('input[name="business_info[has_septic_tank]"]').not(this).prop('checked', false);
    });

    $("#input_brgy").on("change", function () {
      $('#input_zipcode').val($(this).find(':selected').data('zip_code'))
      var _text = $("#input_brgy option:selected").text();
      $('#input_brgy_name').val(_text);
    });

    $("#input_lessor_brgy").on("change", function () {
      $('#input_lessor_zipcode').val($(this).find(':selected').data('zip_code'))
      var _text = $("#input_lessor_brgy option:selected").text();
      $('#input_lessor_brgy_name').val(_text);
    });

    $("#input_owner_brgy").on("change", function () {
      $('#input_lessor_zipcode').val($(this).find(':selected').data('zip_code'))
      var _text = $("#input_owner_brgy option:selected").text();
      var _val =  $("#input_owner_brgy option:selected").val();
      if(_val != ''){
          $('#input_owner_brgy_name').val(_text);
      }else{
          $('#input_owner_brgy_name').val('')
      }
    });
  });
</script>
@stop
