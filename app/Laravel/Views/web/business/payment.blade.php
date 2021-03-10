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
              <div class="table-responsive pt-2">
                <table class="table table-bordered table-wrap" style="table-layout: fixed;">
                  <thead>
                    <tr>
                      <th class="text-title p-3">Department Name</th>
                      <th class="text-title p-3">Assessment File</th>
                      <th class="text-title p-3">Cedula</th>
                      <th class="text-title p-3">Barangay Fee</th>
                      <th class="text-title p-3">Total Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($assessments as $value)
                      <tr>
                         <td>{{str::title($value->department->name)}}</td>
                         <td><a href="{{$value->directory}}/{{$value->filename}}" target="_blank">{{$value->original_name}}</a></td>
                         <td>{{Helper::money_format($value->cedula)}}</td>
                         <td>{{Helper::money_format($value->brgy_fee)}}</td>
                         <td>{{Helper::money_format($value->total_amount)}}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center"><i>No Assessment Records Available.</i></td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
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
