<?php $userPermission = \App\Helpers\LaraHelpers::GetUserPermissions(); ?>
<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">{{trans('app.admin_home')}}</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">{{trans('app.menu')}}</li>
                        <li class="{{$dashboardTab or ''}}" title="Dashboard"><a href="{{url('/dashboard')}}"><i
                                        class="icon mdi mdi-home"></i><span>{{trans('app.admin_home')}}</span></a>
                        </li>
                        @if(in_array("master_manage",$userPermission))
                            <li class="parent {{$masterManagementTab or ''}}" title="Master Managemet"><a href="#"><i
                                            class="icon mdi mdi-account mdi-18px"></i><span>{{trans('app.master_managemet')}}</span></a>
                                <ul class="sub-menu">
                                    @if(in_array("user_management",$userPermission))
                                        <li class="{{$userTab or ''}}">
                                            <a href="{{url('/user/list')}}">{{trans('app.user')}} {{trans('app.management')}}</a>
                                        </li>
                                    @endif
                                    @if(in_array("role_manage",$userPermission))
                                        <li class="{{$roleTab or ''}}">
                                            <a href="{{url('/role/list')}}">{{trans('app.role')}} {{trans('app.management')}}</a>
                                        </li>
                                    @endif
                                    <li class="{{$permissionTab or ''}}">
                                        <a href="{{url('/permission/list')}}">{{trans('app.permission')}} {{trans('app.management')}}</a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                          <li class="parent {{$promoManagementTab or ''}}" title="{{trans('app.voucher_managment')}}"><a href="#"><i
                                        class="icon mdi mdi-quote mdi-18px"></i><span>{{trans('app.voucher_managment')}}</span></a>
                            <ul class="sub-menu">
                                <li class="{{$promoTab or ''}}">
                                    <a href="{{url('voucher/list')}}">{{trans('app.voucher_managment')}}</a>
                                </li>
                           </ul>
                        </li>

                        <li class="parent {{$enquiryManagementTab or ''}}" title="{{trans('app.enquiry_managment')}}"><a href="#"><i
                                        class="icon mdi mdi-quote mdi-18px"></i><span>{{trans('app.enquiry_managment')}}</span></a>
                            <ul class="sub-menu">
                                <li class="{{$enquiryTab or ''}}">
                                    <a href="{{url('enquiry/list')}}">{{trans('app.enquiry_managment')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent {{$prizeManagementTab or ''}}" title="{{trans('app.prize_managment')}}"><a href="#"><i
                                        class="icon mdi mdi-quote mdi-18px"></i><span>{{trans('app.prize_managment')}}</span></a>
                            <ul class="sub-menu">
                                <li class="{{$prizeTab or ''}}">
                                    <a href="{{url('prize/add')}}">{{trans('app.prize_managment')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent {{$detailManagementTab or ''}}" title="{{trans('app.detail_managment')}}"><a href="#"><i
                                        class="icon mdi mdi-quote mdi-18px"></i><span>{{trans('app.detail_managment')}}</span></a>
                            <ul class="sub-menu">
                                <li class="{{$detailTab or ''}}">
                                    <a href="{{url('detail/add')}}">{{trans('app.detail_managment')}}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="parent {{$OfflinePaymentManagementTab or ''}}" title="{{trans('app.offline_payment_managment')}}"><a href="#"><i
                                        class="icon mdi mdi-quote mdi-18px"></i><span>{{trans('app.offline_payment_managment')}}</span></a>
                            <ul class="sub-menu">
                                <li class="{{$addNewAgentPaymentTab or ''}}">
                                    <a href="{{url('offline/add-new-agent')}}">{{trans('app.add_new_agent_payment')}}</a>
                                </li>
                                <li class="{{$addExistingAgentPaymentTab or ''}}">
                                    <a href="{{url('offline/list')}}">Add exiting agent payment</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent {{$saledataManagementTab or ''}}" title="{{trans('app.sale_data_managment')}}"><a href="#"><i
                                        class="icon mdi mdi-quote mdi-18px"></i><span>{{trans('app.sale_data_managment')}}</span></a>
                            <ul class="sub-menu">
                                <li class="{{$saledataTab or ''}}">
                                    <a href="{{url('saledata/list')}}">{{trans('app.sale_data')}}</a>
                                </li>
                            </ul>
                            <ul class="sub-menu">
                                <li class="{{$invoicedataTab or ''}}">
                                    <a href="{{url('saledata/invoice-list')}}">{{trans('app.invoice_data')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li title="Reports"><a href="{{url('/maintanance')}}"><i class="icon fa fa-file-text-o"
                                                                                 aria-hidden="true"></i><span>{{trans('app.reports')}}</span></a>
                        </li>

                        <li title="profile" class="{{$profileTab or ''}}"><a href="{{url('/user/profile')}}"><i
                                        class="icon mdi mdi-face"></i></i><span>{{trans('app.my_profile')}}</span></a>
                        </li>
                        <li title="Change Password" class="{{$changePasswordTab or ''}}"><a
                                    href="{{url('/change-password')}}"><i class="icon mdi mdi-lock"></i></i>
                                <span>{{trans('app.change_password')}}</span></a>
                        </li>

                    </ul>
                    </li>
                    </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>