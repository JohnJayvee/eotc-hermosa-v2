@extends('system._layouts.main')
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.department.index')}}">Assessment Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Get Assessment Details</li>
  </ol>
</nav>
@stop

@section('content')
<div class="row">
  
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Assessment Form</h4>
        <form class="create-form" method="POST" enctype="multipart/form-data">
          @include('system._components.notifications')
          {!!csrf_field()!!}
          <div class="form-group">
            <label for="input_title">E-BRIU Application No.</label>
            <input type="text" class="form-control {{$errors->first('application_no') ? 'is-invalid' : NULL}}" id="input_title" name="application_no" value="{{old('application_no',strtoupper($transaction->application_permit->application_no))}}" readonly>
            @if($errors->first('application_no'))
            <p class="mt-1 text-danger">{!!$errors->first('application_no')!!}</p>
            @endif
          </div>
          <p></p>
         
            <div class="form-group">
              <label for="input_title">File</label>
              <input type="file" class="form-control {{$errors->first('file') ? 'is-invalid' : NULL}}" id="input_title" name="file" value="{{old('file',strtoupper($transaction->application_permit->file))}}">
              @if($errors->first('file'))
              <p class="mt-1 text-danger">{!!$errors->first('file')!!}</p>
              @endif
            </div>
          @if(Auth::user()->department->code == "03")
            <div class="form-group">
              <label for="input_title">BFP Fee</label>
              <input type="text" class="form-control {{$errors->first('bfp_fee') ? 'is-invalid' : NULL}}" id="input_title" name="bfp_fee" value="{{old('bfp_fee',strtoupper($transaction->application_permit->bfp_fee))}}">
              @if($errors->first('bfp_fee'))
              <p class="mt-1 text-danger">{!!$errors->first('bfp_fee')!!}</p>
              @endif
            </div>
          @endif
          @if(Auth::user()->department->code == "99")
            <div class="form-group">
              <label for="input_title">Cedula</label>
              <input type="text" class="form-control {{$errors->first('cedula') ? 'is-invalid' : NULL}}" id="input_title" name="cedula" value="{{old('cedula',strtoupper($transaction->application_permit->cedula))}}">
              @if($errors->first('cedula'))
              <p class="mt-1 text-danger">{!!$errors->first('cedula')!!}</p>
              @endif
            </div>
            <div class="form-group">
              <label for="input_title">Barangay Fee</label>
              <input type="text" class="form-control {{$errors->first('brgy_fee') ? 'is-invalid' : NULL}}" id="input_title" name="brgy_fee" value="{{old('brgy_fee',strtoupper($transaction->application_permit->brgy_fee))}}">
              @if($errors->first('brgy_fee'))
              <p class="mt-1 text-danger">{!!$errors->first('brgy_fee')!!}</p>
              @endif
            </div>
            <div class="form-group">
              <label for="input_title">Total Assessment</label>
              <input type="text" class="form-control {{$errors->first('total_amount') ? 'is-invalid' : NULL}}" id="input_title" name="total_amount" value="{{old('total_amount',strtoupper($transaction->application_permit->total_amount))}}">
              @if($errors->first('total_amount'))
              <p class="mt-1 text-danger">{!!$errors->first('total_amount')!!}</p>
              @endif
            </div>
          @endif
          
          <button type="submit" class="btn btn-primary mr-2">Proceed</button>
          <a href="{{route('system.business_transaction.show',[$transaction->id])}}" class="btn btn-light">Return </a>
        </form>
      </div>
    </div>
  </div>
  
</div>
@stop

@section('page-styles')
<style type="text/css">
  .btn-assessment{
    height: 10px;
    line-height: 1px;
    text-decoration: none;
    font-size: 12px;
  }
</style>
@endsection