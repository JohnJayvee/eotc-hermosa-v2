@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
  <div class="container">
    <div class="row">
      @include('web.business.business_sidebar')
      <div class="col-md-9">
        <div class="row">
            @include('system._components.notifications')
        </div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <h5 class="pt-3">Assessment Details for {{str::title($profile->business_name)}}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p class="text-title fw-500">Assessment File: <span class="text-black"><a href="{{$assessment->directory}}/{{$assessment->filename}}" target="_blank">{{$assessment->original_name}}</a></p>
                <p class="text-title fw-500">Cedula: <span class="text-black">{{Helper::money_format($assessment->cedula)}}</span></p>
                <p class="text-title fw-500">Barangay Fee: <span class="text-black">{{Helper::money_format($assessment->brgy_fee)}}</span></p>
                <p class="text-title fw-500">Total Amount: <span class="text-black">{{Helper::money_format($assessment->total_amount)}}</span></p>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--team section end-->
@stop

@section('page-styles')
<style type="text/css">
  .underline {
    border-bottom: solid 1px;
  }
  .btn-quarter{
    line-height: .1;
  }
</style>
@endsection
@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@endsection
