@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="create-form" method="POST" enctype="multipart/form-data" id="edit_form">
                    @include('system._components.notifications')
                    {!!csrf_field()!!}
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $business->business_name }} Business Information Form</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="text-title text-uppercase">Business Information</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Scope</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->business_scope) }}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Type</label>
                                        <h4 class="form-data text-success">{{str_replace("_"," ",Str::upper($business->business_type))}}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Dominant Name</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->dominant_name) }}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Name</label>
                                        <h4 class="form-data text-success">{{ Str::upper($business->business_name) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Trade name / Franchise</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('trade_name') ? 'is-invalid': NULL  }}"  name="trade_name" value="{{old('trade_name', $business->tradename ?? '') }}">
                                        @if($errors->first('trade_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('trade_name')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('dti_sec_cda_registration_no') ? 'is-invalid': NULL  }}"  name="dti_sec_cda_registration_no" value="{{old('dti_sec_cda_registration_no', $business->dti_sec_cda_registration_no) }}">
                                        @if($errors->first('dti_sec_cda_registration_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dti_sec_cda_registration_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration Date</label>
                                        <input type="date" class="form-control form-control-sm {{ $errors->first('dti_sec_cda_registration_date') ? 'is-invalid': NULL  }}"  name="dti_sec_cda_registration_date" value="{{old('dti_sec_cda_registration_date', $business->dti_sec_cda_registration_date) }}">
                                        @if($errors->first('dti_sec_cda_registration_date'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dti_sec_cda_registration_date')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Cedula No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('ctc_no') ? 'is-invalid': NULL  }}"  name="ctc_no" value="{{old('ctc_no', $business->ctc_no ?? '' ) }}">
                                        @if($errors->first('ctc_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('ctc_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business TIN.</label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('business_tin') ? 'is-invalid': NULL  }}"  name="business_tin" value="{{old('business_tin', $business->business_tin ?? '') }}">
                                        @if($errors->first('business_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2 col-md-6">Are you enjoying tax incentive from any Goverment Entity?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-control-sm tax_entity" type="checkbox" name="checkbox" value="yes" style="width: 30px; height: 30px;" {{ in_array($business->tax_incentive, ['', 'no']) ?: 'checked' }}>
                                            <label class="my-2 mx-1" for="inlineCheckbox1">YES</label>
                                            {{-- <small class="my-2" for="inlineCheckbox3">Please Specify entity:</small> --}}
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-control-sm" type="checkbox" name="checkbox" value="no" style="width: 30px; height: 30px;" {{ $business->tax_incentive == 'no' ? 'checked' : $business->tax_incentive }}>
                                            <label class="my-2 mx-1" for="inlineCheckbox3">NO</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="{{ !in_array($business->tax_incentive, ['', 'no']) ?: 'display:none;' }}" id="checkYes">
                                        <label class="text-form pb-2 text-title">Please Specify entity:</label>
                                        <input type="text" class="form-control form-control-sm" name="tax_incentive" value="{{ $business->tax_incentive }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Area (Sq. m)</label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('business_area') ? 'is-invalid': NULL  }}"  name="business_area" value="{{old('business_area', $business->business_area ?? '') }}">
                                        @if($errors->first('business_area'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_area')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_no_male_employee" class="text-form pb-2">Total No. of Male Employees</label>
										<input type="number" id="input_no_male_employee" class="form-control {{ $errors->first('no_male_employee') ? 'is-invalid': NULL  }}" name="no_male_employee" value="{{old('no_male_employee', $business->no_of_male_employee)}}">
										@if($errors->first('no_male_employee'))
										<p class="help-block text-danger">{{$errors->first('no_male_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_male_residing_in_city" class="text-form pb-2">No. of Male Employees Residing In City</label>
										<input type="number" id="input_male_residing_in_city" class="form-control {{ $errors->first('male_residing_in_city') ? 'is-invalid': NULL  }}" name="male_residing_in_city" value="{{old('male_residing_in_city', $business->male_residing_in_city)}}">
										@if($errors->first('male_residing_in_city'))
										<p class="help-block text-danger">{{$errors->first('male_residing_in_city')}}</p>
										@endif
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_no_female_employee" class="text-form pb-2">Total No. of Female Employees</label>
										<input type="number" id="input_no_female_employee" class="form-control {{ $errors->first('no_female_employee') ? 'is-invalid': NULL  }}" name="no_female_employee" value="{{old('no_female_employee', $business->no_of_female_employee)}}">
										@if($errors->first('no_female_employee'))
										<p class="help-block text-danger">{{$errors->first('no_female_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_female_residing_in_city" class="text-form pb-2">No. of Female Employees Residing In City</label>
										<input type="number" id="input_female_residing_in_city" class="form-control {{ $errors->first('female_residing_in_city') ? 'is-invalid': NULL  }}" name="female_residing_in_city" value="{{old('female_residing_in_city', $business->female_residing_in_city)}}">
										@if($errors->first('female_residing_in_city'))
										<p class="help-block text-danger">{{$errors->first('female_residing_in_city')}}</p>
										@endif
									</div>
								</div>
							</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Capitalization</label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('capitalization') ? 'is-invalid': NULL  }}"  name="capitalization" value="{{old('capitalization', $business->capitalization) }}">
                                        @if($errors->first('capitalization'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('capitalization')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2 col-md-6">Does your establishment has a septic tank or connected to a septic tank?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-control-sm" type="checkbox" name="has_septic_tank" value="yes" style="width: 30px; height: 30px;" {{$business->has_septic_tank == "yes" ? 'checked' : " "}}>
                                            <label class="my-2 mx-1" for="inlineCheckbox1">YES</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-control-sm" type="checkbox" name="has_septic_tank" value="no" style="width: 30px; height: 30px;" {{$business->has_septic_tank == "no" ? 'checked' : " "}}>
                                            <label class="my-2 mx-1" for="inlineCheckbox3">NO</label>
                                        </div>
                                        @if($errors->first('has_septic_tank'))
                                            <small class="form-text pl-3" style="color:red;">{{$errors->first('has_septic_tank')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Exact Location <span class="text-danger">*</span></label>
                                        <input type="text" id="map-address" class="form-control form-control-sm {{ $errors->first('location') ? 'is-invalid': NULL  }}"  name="location" value="{{old('location', $business->location) }}">
                                        @if($errors->first('location'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('capitalization')}}</small>
                                        @endif
                                        <input type="hidden" name="geo_long" id="geo_long" value="{{ old('geo_long',$business->geo_long) }}">
                                        <input type="hidden" name="geo_lat" id="geo_lat" value="{{ old('geo_lat',$business->geo_lat) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="map" class="card-shadow mt-3"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('email') ? 'is-invalid': NULL  }}"  name="email" value="{{old('email', $business->email ?? '') }}">
                                        @if($errors->first('email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website (URL)</label>
                                        <input type="url" class="form-control form-control-sm {{ $errors->first('website_url') ? 'is-invalid': NULL  }}"  name="website_url" value="{{old('website_url', $business->website_url ?? '') }}">
                                        @if($errors->first('website_url'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('website_url')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('mobile_no', $business->mobile_no ?? '')}}">

                                        </div>
                                        @if($errors->first('mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('telephone_no') ? 'is-invalid': NULL  }}"  name="telephone_no" value="{{old('telephone_no', $business->telephone_no) }}">
                                        @if($errors->first('telephone_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('telephone_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="lessor_region_name" id="input_lessor_region_name" value="{{old('lessor_region_name', 'REGION III (CENTRAL LUZON)')}}">
                            <input type="hidden" class="form-control" name="lessor_town_name" id="input_lessor_town_name" value="{{old('lessor_town_name', 'BATAAN - HERMOSA')}}">
                            <input type="hidden" class="form-control" name="lessor_brgy_name" id="input_lessor_brgy_name" value="{{old('lessor_brgy_name', $business->lessor_brgy_name)}}">
                            <h5 class="text-title text-uppercase">Owners Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_firstname') ? 'is-invalid': NULL  }}"  name="owner_firstname" value="{{old('owner_firstname', $business->owner_fname) }}" autocomplete="none">
                                        @if($errors->first('owner_firstname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_firstname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_middlename') ? 'is-invalid': NULL  }}"  name="owner_middlename" value="{{old('owner_middlename', $business->owner_mname) }}" autocomplete="none">
                                        @if($errors->first('owner_middlename'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_middlename')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_lastname') ? 'is-invalid': NULL  }}"  name="owner_lastname" value="{{old('owner_lastname', $business->owner_lname) }}" autocomplete="none">
                                        @if($errors->first('owner_lastname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_lastname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Owner TIN</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_tin') ? 'is-invalid': NULL  }}"  name="owner_tin" value="{{old('owner_tin' , $business->owner_tin) }}" autocomplete="none">
                                        @if($errors->first('owner_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email </label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('owner_email') ? 'is-invalid': NULL  }}"  name="owner_email" value="{{old('owner_email', $business->owner_email) }}" autocomplete="none">
                                        @if($errors->first('owner_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('owner_mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="owner_mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('owner_mobile_no', $business->owner_mobile_no)}}" autocomplete="none">
                                        </div>
                                        @if($errors->first('owner_mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay </label>
                                        {!!Form::select('owner_brgy',[],old('owner_brgy'),['id' => "input_owner_brgy",'class' => "form-control form-control-sm classic ".($errors->first('owner_brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('owner_brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="owner_brgy_name" id="input_owner_brgy_name" value="{{old('owner_brgy_name')}}">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address </label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_street') ? 'is-invalid': NULL  }}"  name="owner_street" value="{{old('owner_street', $business->owner_street ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_street'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_street')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No. </label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_unit_no') ? 'is-invalid': NULL  }}"  name="owner_unit_no" value="{{old('owner_unit_no', $business->owner_unit_no )}}" autocomplete="none">
                                        @if($errors->first('owner_unit_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_unit_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Name of Authorized Representative</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_lastname') ? 'is-invalid': NULL  }}"  name="rep_lastname" value="{{old('rep_lastname', $business->rep_lastname) }}">
                                        @if($errors->first('rep_lastname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_lastname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_firstname') ? 'is-invalid': NULL  }}"  name="rep_firstname" value="{{old('rep_firstname', $business->rep_firstname) }}">
                                        @if($errors->first('rep_firstname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_firstname')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_middlename') ? 'is-invalid': NULL  }}"  name="rep_middlename" value="{{old('rep_middlename', $business->rep_middlename) }}">
                                        @if($errors->first('rep_middlename'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_middlename')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <select name="rep_gender" id="" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Position</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_position') ? 'is-invalid': NULL  }}"  name="rep_position" value="{{old('rep_position', $business->rep_position) }}">
                                        @if($errors->first('rep_position'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_position')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN</label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('rep_tin') ? 'is-invalid': NULL  }}"  name="rep_tin" value="{{old('rep_tin', $business->rep_tin) }}">
                                        @if($errors->first('rep_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">If place of Business is Rented (Lessor Detail)</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Monthly Rental</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_monthly_rental') ? 'is-invalid': NULL  }}"  name="lessor_monthly_rental" value="{{old('lessor_monthly_rental', $business->lessor_monthly_rental) }}">
                                        @if($errors->first('lessor_monthly_rental'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_monthly_rental')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Start Date of Rental (MM/DD/YYYY)</label>
                                        <input type="date" class="form-control form-control-sm {{ $errors->first('lessor_rental_date') ? 'is-invalid': NULL  }}"  name="lessor_rental_date" value="{{old('lessor_rental_date',$business->lessor_rental_date) }}">
                                        @if($errors->first('lessor_rental_date'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_rental_date')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Name of Lessor / Corporation</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_fullname') ? 'is-invalid': NULL  }}"  name="lessor_fullname" value="{{old('lessor_fullname',$business->lessor_fullname) }}">
                                        @if($errors->first('lessor_fullname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_fullname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <select name="lessor_gender" id="" class="form-control">
                                            <option value="{{ old('lessor_gender'), $business->lessor_gender }}">Male</option>
                                            <option value="{{ old('lessor_gender'), $business->lessor_gender }}">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                        {!!Form::select('lessor_region',[],old('lessor_region'),['id' => "input_lessor_region",'class' => "form-control form-control-sm classic ".($errors->first('lessor_region') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_region'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_region')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        {!!Form::select('lessor_town',[],old('lessor_town', $business->lessor_town),['id' => "input_lessor_town",'class' => "form-control form-control-sm classic ".($errors->first('lessor_town') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_town'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_town')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        {!!Form::select('lessor_brgy',[],old('lessor_brgy', $business->lessor_brgy),['id' => "input_lessor_brgy",'class' => "form-control form-control-sm classic ".($errors->first('lessor_brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <input type="text" id="input_lessor_zipcode" class="form-control form-control-sm  {{ $errors->first('lessor_zipcode') ? 'is-invalid': NULL  }}" name="lessor_zipcode" value="{{old('lessor_zipcode', $business->lessor_zipcode)}}" readonly="readonly">
                                        @if($errors->first('lessor_zipcode'))
                                        <p class="help-block text-danger">{{$errors->first('lessor_zipcode')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_unit_no') ? 'is-invalid': NULL  }}"  name="lessor_unit_no" value="{{old('lessor_unit_no', $business->lessor_unit_no) }}">
                                        @if($errors->first('lessor_unit_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_unit_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_street_address') ? 'is-invalid': NULL  }}"  name="lessor_street_address" value="{{old('lessor_street_address', $business->lessor_street_address) }}">
                                        @if($errors->first('lessor_street_address'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_street_address')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('lessor_email') ? 'is-invalid': NULL  }}"  name="lessor_email" value="{{old('lessor_email', $business->lessor_email) }}">
                                        @if($errors->first('lessor_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('lessor_mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="lessor_mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('lessor_mobile_no', $business->lessor_mobile_no)}}">

                                        </div>
                                        @if($errors->first('lessor_mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_tel_no') ? 'is-invalid': NULL  }}"  name="lessor_tel_no" value="{{old('lessor_tel_no',$business->lessor_tel_no) }}">
                                        @if($errors->first('lessor_tel_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_tel_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-md-12" id="repeat_form">
                                    @if ((!empty($lob)))
                                        <div class="row activity">
                                            @foreach ($lob as $key => $item)
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="text-form pb-2">Line of Business {{ $key }}</label>
                                                    <input type="text" class="form-control form-control-sm {{ $errors->first("business_line.{$key}") ? 'is-invalid': NULL  }}"  name="business_line[]" value="{{ $item }}" readonly>
                                                    @if($errors->first("business_line.{$key}"))
                                                        <small class="form-text pl-1" style="color:red;">{{$errors->first("business_line.{$key}")}}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-title text-uppercase">Incase of Emergency</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Contact Person</label>
                                        <input type="text"
                                            class="form-control form-control-sm {{ $errors->first('emergency_contact_fullname') ? 'is-invalid': NULL  }}"
                                            name="emergency_contact_fullname"
                                            value="{{old('emergency_contact_fullname',$business->emergency_contact_fullname) }}">
                                        @if($errors->first('emergency_contact_fullname'))
                                        <small class="form-text pl-1"
                                            style="color:red;">{{$errors->first('emergency_contact_fullname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Tel. No</label>
                                        <input type="text"
                                            class="form-control form-control-sm {{ $errors->first('emergency_contact_tel_no') ? 'is-invalid': NULL  }}"
                                            name="emergency_contact_tel_no"
                                            value="{{old('emergency_contact_tel_no',$business->emergency_contact_tel_no) }}">
                                        @if($errors->first('emergency_contact_tel_no'))
                                        <small class="form-text pl-1"
                                            style="color:red;">{{$errors->first('emergency_contact_tel_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span
                                                        class="pr-1 pl-2" style="padding-bottom: 2px">
                                                        |</span></span>
                                            </div>
                                            <input type="number"
                                                class="form-control {{ $errors->first('emergency_contact_mobile_no') ? 'is-invalid': NULL  }} br-left-white"
                                                name="emergency_contact_mobile_no"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                maxlength="10" placeholder="Contact Number"
                                                value="{{old('emergency_contact_mobile_no', $business->emergency_contact_mobile_no)}}">

                                        </div>
                                        @if($errors->first('emergency_contact_mobile_no'))
                                        <small class="form-text pl-1"
                                            style="color:red;">{{$errors->first('emergency_contact_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email
                                            Address</label>
                                        <input type="text"
                                            class="form-control form-control-sm {{ $errors->first('emergency_contact_email') ? 'is-invalid': NULL  }}"
                                            name="emergency_contact_email"
                                            value="{{old('emergency_contact_email',$business->emergency_contact_email) }}">
                                        @if($errors->first('emergency_contact_email'))
                                        <small class="form-text pl-1"
                                            style="color:red;">{{$errors->first('emergency_contact_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-title text-uppercase">Other Information Form (Government Owned Or Controlled Corporations)</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('tin_no') ? 'is-invalid': NULL  }}"  name="tin_no" value="{{old('tin_no', $business->tin_no ?? '') }}">
                                        @if($errors->first('tin_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('tin_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">SSS No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('sss_no') ? 'is-invalid': NULL  }}"  name="sss_no" value="{{old('sss_no', $business->sss_no) }}">
                                        @if($errors->first('sss_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('sss_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Philhealth No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('philhealth_no') ? 'is-invalid': NULL  }}"  name="philhealth_no" value="{{old('philhealth_no', $business->philhealth_no) }}">
                                        @if($errors->first('philhealth_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('philhealth_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">PAGIBIG No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('pagibig_no') ? 'is-invalid': NULL  }}"  name="pagibig_no" value="{{old('pagibig_no', $business->pagibig_no) }}">
                                        @if($errors->first('pagibig_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('pagibig_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <a href="{{route('web.business.index')}}" class="btn btn-light" style="float: right;">Cancel</a>
                            <button type="submit" class="btn badge-primary-2 text-white mr-2" style="float: right;">Update Record</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

</section>
<!--team section end-->


@stop
@section('page-styles')
<style type="text/css">
    #map {
        height: 400px !important;
        width: 100% !important; 
    }
</style>
@endsection
@section('page-scripts')
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('system/vendors/locationpicker/locationpicker.jquery.js')}}" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?v=3&libraries=places&key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
<script type="text/javascript">
    $.fn.get_region = function (input_region, input_province, input_city, input_brgy, selected) {

        $(input_city).empty().prop('disabled', true)
        $(input_brgy).empty().prop('disabled', true)

        $(input_region).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
        $.getJSON("{{env('PSGC_REGION_URL')}}", function (response) {
            $(input_region).empty().prop('disabled', true)
            $.each(response.data, function (index, value) {
                $(input_region).append($('<option>', {
                    value: index,
                    text: value
                }));
            })

            $(input_region).prop('disabled', true)
            $(input_region).prepend($('<option>', {
                value: "",
                text: "--Select Region--"
            }))
            if (selected.length > 0) {
                $(input_region).val($(input_region + " option[value=" + selected + "]").val());
            } else {
                $(input_region).val($(input_region + " option:first").val());
            }
        });
        // return result;
    };

    $.fn.get_city = function (reg_code, input_city, input_brgy, selected) {
        $(input_brgy).empty().prop('disabled', true)
        $(input_city).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
        $.getJSON("{{env('PSGC_CITY_URL')}}?region_code=" + reg_code, function (data) {
            console.log(data)
            $(input_city).empty().prop('disabled', true)
            $.each(data, function (index, value) {
                $(input_city).append($('<option>', {
                    value: index,
                    text: value
                }));
            })

            $(input_city).prop('disabled', true)
            $(input_city).prepend($('<option>', {
                value: "",
                text: "--SELECT MUNICIPALITY/CITY, PROVINCE--"
            }))
            if (selected.length > 0) {
                $(input_city).val($(input_city + " option[value=" + selected + "]").val());
            } else {
                $(input_city).val($(input_city + " option:first").val());
            }
        });
        // return result;
    };

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
            $(input_brgy).prepend($('<option>', {
                value: "",
                text: "--SELECT BARANGAY--"
            }))

            if (selected.length > 0) {
                $(input_brgy).val($(input_brgy + " option[value=" + selected + "]").val());

                if (typeof $(input_brgy + " option[value=" + selected + "]").data('zip_code') === undefined) {
                    $(input_brgy.replace("brgy", "zipcode")).val("")
                } else {
                    $(input_brgy.replace("brgy", "zipcode")).val($(input_brgy + " option[value=" + selected + "]").data('zip_code'))
                }

            } else {
                $(input_brgy).val($(input_brgy + " option:first").val());
            }
        });
    }

    $( "#edit_form" ).submit(function( event ) {
        $("#input_lessor_region").prop( "disabled", false );
        $("#input_lessor_town").prop( "disabled", false );
    });   
    $(function () {
        
        $('#buttonID').click(function(){
            alert('click');
        })

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
            latitude:  {{$business->geo_lat ?: 14.6741}},
            longitude: {{$business->geo_long ?: 120.5113}}
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
        $('input[name="has_septic_tank"]').on('change', function () {
            $('input[name="has_septic_tank"]').not(this).prop('checked', false);
        });

        $('input[name="checkbox"]').on('change', function () {
            $('input[name="checkbox"]').not(this).prop('checked', false);

            if($(this).val() == 'yes'){
                $('input[name="tax_incentive"]').val('');
                $('#checkYes').show();
            }
            if($(this).val() == 'no'){
                $('#checkYes').hide();
                $('input[name="tax_incentive"]').val('no');
            }
        });
        function load_lessor_barangay() {
            var _val = "030805000";
            var _text = "BATAAN - HERMOSA";
            $(this).get_brgy(_val, "#input_lessor_brgy", "");
            $('#input_lessor_zipcode').val('');
            $('#input_lessor_town_name').val(_text);
        }
      
        function load_owner_barangay() {
            var _val = "030805000";
            var _text = "BATAAN - HERMOSA";
            $(this).get_brgy(_val, "#input_owner_brgy", "");
        }

        $(this).get_region("#input_lessor_region", "#input_lessor_province", "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_region', '030000000')}}")
        $(this).get_city("030000000", "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_town', '030805000')}}");
        $(this).get_brgy('030805000', "#input_lessor_brgy", "{{ $business->lessor_brgy }}");
        $(this).get_brgy('030805000', "#input_owner_brgy", "{{ $business->owner_brgy }}");

        $("#input_lessor_region").on("change", function () {
            var _val = $(this).val();
            var _text = $("#input_lessor_region option:selected").text();
            $(this).get_city($("#input_lessor_region").val(), "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_town')}}");
            $('#input_zipcode').val('');
            $('#input_region_name').val(_text);
        });

        $("#input_lessor_town").on("change", function () {
            var _val = $(this).val();
            var _text = $("#input_lessor_town option:selected").text();
            $(this).get_brgy($("#input_lessor_town").val(), "#input_lessor_brgy", "");
            $('#input_lessor_zipcode').val('');
            $('#input_lessor_town_name').val(_text);
        });


        @if(strlen(old('lessor_region')) > 0)
        $(this).get_city("{{old('lessor_region')}}", "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_town')}}");
        @endif

        @if(strlen(old('lessor_town')) > 0)
        $(this).get_brgy("{{old('lessor_town')}}", "#input_lessor_brgy", "{{old('lessor_brgy')}}");
        @endif

        $("#input_lessor_brgy").on("change", function () {
            $('#input_lessor_zipcode').val($(this).find(':selected').data('zip_code'))
            var _text = $("#input_lessor_brgy option:selected").text();
            $('#input_lessor_brgy_name').val(_text);
        });
        $("#input_owner_brgy").on("change", function () {
            var _text = $("#input_owner_brgy option:selected").text();
            $('#input_owner_brgy_name').val(_text);
        });

    })

  
</script>
@endsection
