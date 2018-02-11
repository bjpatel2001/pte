@extends('layouts.common')
@section('pageTitle')
    {{__('app.default_add_title',["app_name" => __('app.app_name'),'Expense data'])}}
@endsection
@push('externalCssLoad')
<link rel="stylesheet" href="{{url('css/plugins/jquery.datetimepicker.css')}}" type="text/css" />
@endpush
@push('internalCssLoad')

@endpush
@section('content')
    <div class="be-content">
        <div class="page-head">
            <h2>Expense {{trans('app.management')}}</h2>
            <ol class="breadcrumb">
                <li><a href="{{url('/dashboard')}}">{{trans('app.admin_home')}}</a></li>
                <li><a href="{{url('/expense/list')}}">Expense {{trans('app.management')}}</a></li>
                <li class="active">{{trans('app.edit')}} Expense entry</li>
            </ol>
        </div>
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-border-color panel-border-color-primary">
                        <div class="panel-heading panel-heading-divider">{{trans('app.edit')}} Expense entry</div>
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{url('/expense/update')}}" name="app_add_form" id="app_form" style="border-radius: 0px;" method="post" class="form-horizontal group-border-dashed">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Expense Date<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="date" id="date" placeholder="Expense Date" class="form-control input-sm required" value="{{$details->date}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Name<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="name" id="name" placeholder="Nmae" class="form-control input-sm required" value="{{$details->name}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Detail<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="detail" id="detail" placeholder="Detail" class="form-control input-sm required" value="{{$details->detail}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Amount Before GST<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="number" name="before_gst" id="before_gst" placeholder="Amount Before GST" class="form-control input-sm required" value="{{$details->before_gst}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">GST amount<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="number" name="gst" id="gst" placeholder="GST amount" class="form-control input-sm required" value="{{$details->gst}}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Amount After GST<span class="error">*</span></label>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="number" name="after_gst" id="after_gst" placeholder="Amount After GST" class="form-control input-sm required" value="{{$details->after_gst}}" />
                                    </div>
                                </div>

                                <input type="hidden" name="id" id="id" value="{{$details->id}}" />

                                {{ csrf_field() }}

                                <div class="col-sm-6 col-md-8 savebtn">
                                    <p class="text-right">
                                        <button type="submit" class="btn btn-space btn-info btn-lg">{{trans('app.edit')}} entry</button>
                                        <a href="{{url('/expense/list')}}" class="btn btn-space btn-danger btn-lg">Cancel</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('externalJsLoad')
<script src="{{url('js/plugins/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script>
    $( function() {
        $( "#date" ).datepicker({dateFormat: 'dd-mm-yy'});

    } );
</script>
@endpush
