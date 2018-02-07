@extends('layouts.common')
@section('pageTitle')
    {{__('app.default_list_title',["app_name" => __('app.app_name'),"module"=> __('app.sale_data')])}}
@endsection
@push('externalCssLoad')
<link rel="stylesheet" href="{{url('css/plugins/jquery.datetimepicker.css')}}" type="text/css"/>
@endpush
@push('internalCssLoad')

@endpush
@section('content')
    <div class="be-content">
        <div class="page-head">
            <h2>{{trans('app.sale_data')}} Management</h2>
            <ol class="breadcrumb">
                <li><a href="{{url('/dashboard')}}">{{trans('app.admin_home')}}</a></li>
                <li class="active">{{trans('app.sale_data')}} Listing</li>
            </ol>
        </div>
        <div class="main-content container-fluid">

            <!-- Caontain -->
            <div class="panel panel-default panel-border-color panel-border-color-primary pull-left">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="activity-but activity-space pull-left">
                            <div class="pull-left">
                                <a href="javascript:void(0);" class="btn btn-warning func_SearchGridData"><i
                                            class="icon mdi mdi-search"></i> Search</a>
                            </div>
                            <div class="pull-left">
                                <a href="javascript:void(0);" class="btn btn-danger func_ResetGridData"
                                   style="margin-left: 10px;">Reset</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="deta-table user-table pull-left">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default panel-table">
                                <div class="panel-body">
                                    <table id="dataTable"
                                           class="table display dt-responsive responsive nowrap table-striped table-hover table-fw-widget"
                                           style="width: 100%;">

                                        <thead>

                                        <tr>
                                            <th>Created Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Voucher Code</th>
                                            <th>Transaction Id</th>
                                            <th>Rate</th>
                                            <th>Total Amount</th>
                                            <th>Number of Qty</th>

                                        </tr>

                                        </thead>
                                        <thead>
                                        <tr>
                                            <th>
                                                {{--<input type="text" name="filter[created_date]" style="width: 80px;" id="created_date" value="" />--}}
                                            </th>
                                            <th>
                                                <input type="text" name="filter[name]" style="width: 80px;" id="name" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[email]" style="width: 80px;" id="email" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[mobile]" style="width: 80px;" id="mobile" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[voucher_code]" style="width: 80px;" id="voucher_code" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[payment_code]" style="width: 80px;" id="payment_code" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[rate]" style="width: 80px;" id="rate" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[amount_paid]" style="width: 80px;" id="amount_paid" value="" />
                                            </th>
                                            <th>
                                                <input type="text" name="filter[number_of_voucher]" style="width: 80px;" id="number_of_voucher" value="" />
                                            </th>
                                      
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('externalJsLoad')

<script src="{{url('js/plugins/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{url('js/appDatatable.js')}}"></script>
<script src="{{url('js/modules/saledata.js')}}"></script>
<script>
    $( function() {
        $( "#created_date" ).datepicker();
    } );
</script>
@endpush
@push('internalJsLoad')
<script>
    app.saledata.init();
</script>
@endpush