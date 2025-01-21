@extends($theme)
@section('meta_title',setMetaData()->e_deshbrd_title.' - '.$gadget->item_name )
@section('meta_description',setMetaData()->e_deshbrd_desc)
@section('meta_keywords',setMetaData()->e_deshbrd_keyword)

@section('content')
    <div class="page-main-contain">

        <section class="user-events" style="padding-top: 0;">
            <div class="container">
                <a href="{{ route('events.manage') }}">   <button type="button" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> @lang('words.mng_eve.mng_eve_bk')</button></a>

                <br><br>

                @if($gadget->ban == 1)
                    <div class="alert alert-danger">
                        <ul style="padding-left:10px;">
                            <li>@lang('words.ban_reason.ban_text_1')</li>
                            <li>@lang('words.ban_reason.ban_text_2')</li>
                            <li>@lang('words.ban_reason.ban_text_3') {{frommail()}} </li>
                        </ul>
                    </div>
                @endif
                <h2 class="text-heading mb-4">@lang('words.manage_dash.mng_dash_tit1')</h2>


                <!--Heading stat-->
                <div class="row mb-4">

                    <div class="col-md-8">

                        <div class="card">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <img src="{{ getImage($gadget->item1_image, 'thumb') }}" class="card-img-top"
                                         alt="...">
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $gadget->item_name }} </h5>
                                        <?php
                                        //Jenssegers\Date\Date::setLocale('fr');
                                        /*$startdate = Carbon\Carbon::parse($gadget->item_start_datetime)->format('D, F j, Y');
                                        $enddate = Carbon\Carbon::parse($gadget->item_end_datetime)->format('D, F j, Y');
                                        $starttime = Carbon\Carbon::parse($gadget->item_start_datetime)->format('h:i A');
                                        $endtime = Carbon\Carbon::parse($gadget->item_end_datetime)->format('h:i A');*/
                                        $startdate 	= ucwords(Jenssegers\Date\Date::parse($gadget->item_start_datetime)->format('l j M Y'));
                                        $enddate 	= ucwords(Jenssegers\Date\Date::parse($gadget->item_end_datetime)->format('l j M Y'));
                                        $starttime	= Carbon\Carbon::parse($gadget->item_start_datetime)->format('H:i');
                                        $endtime	= Carbon\Carbon::parse($gadget->item_end_datetime)->format('H:i');
                                        ?>
                                        @if($startdate == $enddate)
                                            <p class="event-time">{{ $startdate }} - {{ $starttime }}
                                                <b>à</b> {{ $endtime }}</p>
                                        @else
                                            <p class="event-time">{{ $startdate }}, {{ $starttime }}
                                                <b>à</b> {{ $enddate }}, {{ $endtime }}</p>
                                        @endif

                                        <p>
                                            <?php
                                            /*$startdate = Carbon\Carbon::parse($gadget->item_start_datetime)->format('D, F j, Y');
                                            $enddate = Carbon\Carbon::parse($gadget->item_end_datetime)->format('D, F j, Y');
                                            $starttime = Carbon\Carbon::parse($gadget->item_start_datetime)->format('h:i A');
                                            $endtime = Carbon\Carbon::parse($gadget->item_end_datetime)->format('h:i A');*/
                                            $startdate 	= ucwords(Jenssegers\Date\Date::parse($gadget->item_start_datetime)->format('l j M Y'));
                                            $enddate 	= ucwords(Jenssegers\Date\Date::parse($gadget->item_end_datetime)->format('l j M Y'));
                                            $starttime	= Carbon\Carbon::parse($gadget->item_start_datetime)->format('H:i');
                                            $endtime	= Carbon\Carbon::parse($gadget->item_end_datetime)->format('H:i');
                                            ?>
                                        </p>

                                        <div class=" mt-2">
                                            @if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($gadget->item_start_datetime)->format('Y-m-d'))
                                                <label class="badge badge-pill badge-primary">@lang('words.events_tab.today')</label>
                                            @elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($gadget->item_start_datetime)->format('Y-m-d'))
                                                <label class="event-label label-status badge badge-pill">@lang('words.mng_eve.mng_eve_fea')</label>
                                            @else
                                                <label class="event-label label-status badge badge-pill">@lang('words.mng_eve.mng_eve_past')</label>
                                            @endif
                                            @if($gadget->item_status == 1)
                                                <label class="event-label label-publish badge badge-pill">@lang('words.mng_eve.mng_eve_pus')</label>
                                            @else
                                                <label class="event-label label-draft badge badge-pill">@lang('words.mng_eve.mng_eve_drf')</label>
                                            @endif
                                            @if($gadget->ban == 1)
                                                <label class="event-label label-ban badge badge-pill"><i class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')
                                                </label>
                                            @endif
                                        </div>

                                        <div class="dropdown mt-3">
                                            <a href="{{ route('events.edit',$gadget->item_unique_id) }}">
                                                <button type="button" class="btn btn-outline-primary"><i
                                                            class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')
                                                </button>
                                            </a>

                                            <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Option
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="{{ route('events.details',$gadget->item_slug) }}"><i
                                                            class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')
                                                </a>
                                                <a class="dropdown-item"
                                                   href="{{ route('events.delete',$gadget->item_unique_id) }}"
                                                   onclick=" return confirm('are you sure Delete this item ?')"><i
                                                            class="fa fa-trash"></i> @lang('words.mng_eve.mng_eve_del')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--Type de tickets-->
                    <div class="col-md-4">
                        <div class="tickets-type">

                            <div class="card">
                                <h5 class="card-header">@lang('words.manage_dash.mng_tik_toal')</h5>
                                <div class="card-body">
                                    @php
                                    $ticket_qty = array_column(array_flatten($tickets), 'ticket_qty');
                                    $remaning_qty = array_column(array_flatten($tickets), 'ticket_remaning_qty');
                                    $totalTickets = array_sum($ticket_qty);
                                    $totalRemaning = array_sum($remaning_qty);
                                    $totalSoldTickets = $totalTickets - $totalRemaning;
                                    @endphp
                                    <div class="progess-text">
                                        <strong>{{ $totalOrderTickss->TOTAL_ORDER_TICKETS }}</strong> @lang('words.manage_dash.mng_sol_toal')
                                        / <strong>{{ $event_tickets->TOTAL_TICKETS }}</strong>
                                    </div>
                                    <div class="progress">
                                        @php $j=1 @endphp
                                        @foreach($eventOrderTickets as $ticket)
                                            @php
                                            $total = number_format(($ticket->NUMBER_OF_ORDER /
                                            $event_tickets->TOTAL_TICKETS) * 100, 0);
                                            @endphp

                                            @if($j==1)
                                                <div class="progress-bar" data-toggle="tooltip" data-placement="top"
                                                     data-original-title="{{  number_format($total,0) }}%"
                                                     style="width:{{  $total }}%; background-color:#f07322;"></div>
                                            @elseif($j==2)
                                                <div class="progress-bar" data-toggle="tooltip" data-placement="top"
                                                     data-original-title="{{  number_format($total,0) }}%"
                                                     style="width:{{  $total }}%; background-color:#0095da;"></div>
                                            @elseif($j==3)
                                                <div class="progress-bar" data-toggle="tooltip" data-placement="top"
                                                     data-original-title="{{  number_format($total,0) }}%"
                                                     style="width:{{  $total }}%; background-color:#ce242c;"></div>
                                            @elseif($j==4)
                                                <div class="progress-bar" data-toggle="tooltip" data-placement="top"
                                                     data-original-title="{{  number_format($total,0) }}%"
                                                     style="width:{{  $total }}%; background-color:#00924c;"></div>
                                            @else
                                                <div class="progress-bar" data-toggle="tooltip" data-placement="top"
                                                     data-original-title="{{  number_format($total,0) }}%"
                                                     style="width:{{  $total }}%; background-color:#fbb413;"></div>
                                            @endif
                                            @php $j++ @endphp
                                        @endforeach
                                </div>
                            </div>
                            </div>
                            <br>
                            @if(!empty($eventOrderTickets))
                                @php $i=1  @endphp
                                @foreach($eventOrderTickets as $ticket)
                                    <div class="card">
                                        <h5 class="card-header">{{ $ticket->TICKE_TITLE }}</h5>
                                        <div class="card-body">
                                            <div class="progess-text">
                                            <strong>{{($ticket->NUMBER_OF_ORDER)}}</strong> @lang('words.manage_dash.mng_sol_toal')
                                            / <strong>{{ $ticket->TICKE_QTY }}</strong>
                                                </div>
                                            @php
                                            $total = number_format(($ticket->NUMBER_OF_ORDER /
                                            $ticket->TICKE_QTY) * 100, 0);
                                            @endphp
                                        <div class="progress working">
                                            @if($i==1)
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     style="width:{{  $total }}%; background-color:#f07322"> {{ number_format($total) }}
                                                    %
                                                </div>
                                            @elseif($i==2)
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     style="width:{{  $total }}%; background-color:#0095da"> {{  number_format($total) }}
                                                    %
                                                </div>
                                            @elseif($i==3)
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     style="width:{{ $total }}%; background-color:#ce242c"> {{ number_format($total) }}
                                                    %
                                                </div>
                                            @elseif($i==4)
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     style="width:{{ $total }}%; background-color:#00924c"> {{ number_format($total) }}
                                                    %
                                                </div>
                                            @else
                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                     style="width:{{ $total }}%; background-color:#fbb413"> {{ number_format($total) }}
                                                    %
                                                </div>
                                            @endif
                                        </div>
                                        </div>
                                    </div>

                                    @php $i++  @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!--Heading stat-->

                <!--Télécharger la liste des participants-->
                <div class="row mb-5">
                    <div class="col-md-12" align="center">
                        <center>
                            <a href="{{ route('events.attendee', $gadget->item_unique_id) }}"
                               class="add_tickets pro-choose-file  mt-0" style="width: auto !important;"><i class="fas fa-download"></i> @lang('words.mng_eve.mng_eve_down')</a>
                        </center>
                    </div>
                </div>
                <!--Télécharger la liste des participants-->


                <!--Autres stats-->
             <div class="row mb-4">
             <div class="col-md-12">
                 <div class="card-tabs-3">
                     <div class="nav-center">
                         <ul class="nav nav-tabs min-tab">
                             <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab"><i class="fas fa-list-ul"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_ord')</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-2" role="tab"><i class="fas fa-heart"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_reg')</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-3" role="tab"><i class="fas fa-money-bill-alt"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_Ear')</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-4" role="tab"><i class="fas fa-ticket-alt"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_TE')</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-5" role="tab"><i class="fas fa-user-check"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_AP')</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-6" role="tab"><i class="fas fa-id-card"></i> <span class="d-none d-sm-block">Contact partcip.</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-7" role="tab"><i class="fas fa-link"></i> <span class="d-none d-sm-block">Iframe</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-8" role="tab"><i class="fas fa-code"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_LP')</span></a></li>
                             <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-9" role="tab"><i class="fas fa-code"></i> <span class="d-none d-sm-block">@lang('words.manage_dash.eve_not_TC')</span></a></li>
                         </ul>
                     </div>
                     <div class="card-block">
                         <div class="tab-content">

                             <!-- Commandes -->
                             <div class="tab-pane active" id="tab-1">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>@lang('words.eve_order.eve_book_tbl_tit')</h3>
                                             </div>
                                             <div class="table-responsive">
                                                  <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                     <thead class="table-head">
                                                     <tr>
                                                         <th>@lang('words.eve_order.eve_book_tbl_1')</th>
                                                         <th>@lang('words.eve_order.eve_book_tbl_2')</th>
                                                         <th>@lang('words.eve_order.eve_book_tbl_3')</th>
                                                         <th>@lang('words.eve_order.eve_book_tbl_4')</th>
                                                         <th>@lang('words.eve_order.eve_book_tbl_5')</th>
                                                         <th>@lang('words.eve_order.eve_book_tbl_6')</th>
                                                         <th>@lang('words.eve_order.eve_book_tbl_7')</th>
                                                     </tr>
                                                     </thead>
                                                     <tbody>
                                                     @if(count($bookedeve) > 0 )
                                                         @foreach($bookedeve as $key => $val)
                                                             <tr>
                                                                 <td>{{ $val->order_id }}</td>
                                                                 <td>
                                                                     @if(! is_null($val->gust_id))
                                                                         {{ $val->user_name }}
                                                                     @else
                                                                         {{ $val->fnm }} {{ $val->lnm }}
                                                                     @endif
                                                                 </td>
                                                                 <td class="text-center">{{ $val->order_tickets }}</td>
                                                                 <td>{!! use_currency()->symbol !!} {{ $val->order_amount }}</td>
                                                                 <td>{{ date_format($val->created_at,'d M Y H:i')}}</td>
                                                                 <td>
                                                                     @php
                                                                     $order_t_id = unserialize($val->order_t_id);
                                                                     $order_t_title = unserialize($val->order_t_title);
                                                                     $order_t_price = unserialize($val->order_t_price);
                                                                     $order_t_fees = unserialize($val->order_t_fees);
                                                                     $order_t_qty = unserialize($val->order_t_qty);
                                                                     @endphp
                                                                     <button data-toggle="modal"
                                                                             data-target="#Model-{{ $val->order_id }}"><i
                                                                             class="fa fa-eye"></i>&nbsp; @lang('words.eve_order.view_ord_vew')
                                                                     </button>
                                                                     <div class="modal fade" id="Model-{{ $val->order_id }}">
                                                                         <div class="modal-dialog modal-lg">
                                                                             <div class="modal-content">
                                                                                 <!-- Modal Header -->
                                                                                 <div class="modal-header">
                                                                                     <h4 class="modal-title"> {{ $val->order_id }}</h4>
                                                                                 </div>

                                                                                 <!-- Modal body -->
                                                                                 <div class="modal-body">
                                                                                     <div class="text-body">
                                                                                         <p>
                                                                                             <strong>
                                                                                                 @if(! is_null($val->gust_id))
                                                                                                     {{ $val->user_name }}
                                                                                                 @else
                                                                                                     {{ $val->fnm }} {{ $val->lnm }}
                                                                                                 @endif
                                                                                             </strong>
                                                                                             ({{ ! is_null($val->gust_id)?$val->guest_email:$val->mail }}
                                                                                             )
                                                                                             on {{ date_format($val->created_at,'M d, Y  h:i A') }}
                                                                                         </p>

                                                                                         <div class="gernal-label">
                                                                                             @if($val->order_status == 1)
                                                                                                 <label class="label label-publish">@lang('words.view_ord_tbl.view_order_label')</label>
                                                                                             @elseif($val->order_status == 2)
                                                                                                 <label class="label label-draft">@lang('words.view_ord_tbl.view_cancel_label')</label>
                                                                                             @else
                                                                                                 <label class="label label-status">@lang('words.view_ord_tbl.view_progress_label')</label>
                                                                                                 @endif
                                                                                                         <!-- <span>Free Order</span> -->
                                                                                         </div>
                                                                                     </div>
                                                                                     <hr/>
                                                                                     <div class="tickets-type table-responsive">
                                                                                         <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                                                             <thead class="table-head">
                                                                                             <tr>
                                                                                                 <th>@lang('words.view_ord_tbl.view_ord_tbl_1')</th>
                                                                                                 <th>@lang('words.view_ord_tbl.view_ord_tbl_2')</th>
                                                                                                 <th class="text-center">@lang('words.view_ord_tbl.view_ord_tbl_3')</th>
                                                                                                 <th class="text-right">@lang('words.view_ord_tbl.view_ord_tbl_4')</th>
                                                                                                 <th class="text-right">@lang('words.view_ord_tbl.view_ord_tbl_5')</th>
                                                                                             </tr>
                                                                                             </thead>
                                                                                             <tbody>
                                                                                             @if(!empty($order_t_id))
                                                                                                 @foreach($order_t_id as $key => $ticket)
                                                                                                     <tr>
                                                                                                         <td width="30%">{{ $order_t_title[$key] }}</td>
                                                                                                         <td>@php $tType
                                                                                                             =(floatval($order_t_price[$key])>0)?'paid':'free' @endphp {{$tType}}</td>
                                                                                                         <td class="text-center">{{ $order_t_qty[$key] }}</td>
                                                                                                         <td class="text-right">{!! use_currency()->symbol !!} {{ number_format((floatval($order_t_price[$key]) + floatval($order_t_fees[$key])),0) }}</td>
                                                                                                         <td class="text-right">{!! use_currency()->symbol !!} {{ number_format((floatval($order_t_price[$key]) + floatval($order_t_fees[$key])) * intval($order_t_qty[$key]),0) }}</td>
                                                                                                     </tr>
                                                                                                 @endforeach
                                                                                             @endif
                                                                                             </tbody>
                                                                                             <tfoot class="table-footer">
                                                                                             <tr>
                                                                                                 <td></td>
                                                                                                 <td></td>
                                                                                                 <td class="text-center">{{ $val->order_tickets }}</td>
                                                                                                 <td></td>
                                                                                                 <td class="text-right">{!! use_currency()->symbol !!} {{ $val->order_amount }}</td>
                                                                                             </tr>
                                                                                             </tfoot>
                                                                                         </table>
                                                                                     </div>
                                                                                 </div>
                                                                                 <!-- Modal footer -->
                                                                                 <div class="modal-footer">
                                                                                     <button type="button"
                                                                                             class="btn btn-sm btn-flat btn-danger"
                                                                                             data-dismiss="modal">@lang('words.view_ord_tbl.view_ord_tbl_6')</button>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </td>
                                                                 <td>
                                                                     <div class="gernal-label">
                                                                         @if($val->order_status == 1)
                                                                             <label class="label label-publish">@lang('words.view_ord_tbl.view_order_label')</label>
                                                                         @elseif($val->order_status == 2)
                                                                             <label class="label label-draft">@lang('words.view_ord_tbl.view_cancel_label')</label>
                                                                         @else
                                                                             <label class="label label-status">@lang('words.view_ord_tbl.view_progress_label')</label>
                                                                         @endif
                                                                     </div>
                                                                 </td>
                                                             </tr>
                                                         @endforeach
                                                     @else
                                                         <tr>
                                                             <td  colspan="7" align="center">
                                                             @lang('words.mng_eve.eve_not_f_t')
                                                            </td>
                                                         </tr>
                                                     @endif
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <!-- -->


                             <!--Enregistrés -->
                             <div class="tab-pane" id="tab-2">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>@lang('words.eve_book_mark.eve_book_tbl_tit')</h3>
                                             </div>
                                             <div class="table-responsive">
                                                 <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                     <thead class="table-head">
                                                     <tr>
                                                         <th>@lang('words.eve_book_mark.eve_book_tbl_1')</th>
                                                         <th>@lang('words.eve_book_mark.eve_book_tbl_2')</th>
                                                         <th>@lang('words.eve_book_mark.eve_book_tbl_3')</th>
                                                     </tr>
                                                     </thead>
                                                     <tbody>
                                                     @if(count($databook) > 0 )
                                                         @foreach($databook as $key => $val)
                                                             <tr>
                                                                 <td>{{ $val->fnm }} {{ $val->lnm }}</td>
                                                                 <td>{{ $val->mail }}</td>
                                                                 <td>{{ date_format($val->created_at,'d-m-y h:i A') }}</td>
                                                             </tr>
                                                         @endforeach
                                                     @else
                                                         <tr>
                                                             <td colspan="6" align="center">
                                                             @lang('words.eve_book_mark.eve_no_an_sav')
                                                             <td/>
                                                         </tr>
                                                     @endif
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <!-- -->

                             <!--Gains-->
                             <div class="tab-pane" id="tab-3">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>@lang('words.eve_book_earn.earn_eve_tit')</h3>
                                             </div>
                                             <div class="table-responsive">
                                                 <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                     <thead class="table-head">
                                                     <tr>
                                                         <th width="30%">@lang('words.eve_book_earn.earn_tbl_1')</th>
                                                         <th width="10%">@lang('words.eve_order.eve_book_tbl_1')</th>
                                                         <th class="text-center">@lang('words.eve_book_earn.earn_tbl_2')</th>
                                                         <th width="15%"
                                                             class="text-right">@lang('words.eve_book_earn.earn_tbl_3')</th>
                                                         <th width="15%"
                                                             class="text-right">@lang('words.eve_book_earn.earn_tbl_4')</th>
                                                         <th width="15%"
                                                             class="text-right">@lang('words.eve_book_earn.earn_tbl_5')</th>
                                                         <th width="15%"
                                                             class="text-right">@lang('words.eve_book_earn.earn_tbl_6')</th>
                                                     </tr>
                                                     </thead>
                                                     <tbody>
                                                     @if(count($data) > 0 )
                                                         @foreach($data as $okey => $order)
                                                             @php
                                                             $tickets    = unserialize($order->order_t_id);
                                                             $ttitle        = unserialize($order->order_t_title);
                                                             $tqty        = unserialize($order->order_t_qty);
                                                             $tprice        = unserialize($order->order_t_price);
                                                             $tfees        = unserialize($order->order_t_fees);
                                                             @endphp
                                                             @foreach($tickets as $key => $val)
                                                                 <tr>
                                                                     <td>{{ $ttitle[$key] }}</td>
                                                                     <td>{{ $order->order_id }}</td>
                                                                     <td class="text-center">{{ $tqty[$key] }}</td>
                                                                     <td class="text-right">
                                                                         @if($tprice[$key] > 0 )
                                                                             {!! use_currency()->symbol !!} {{ $tprice[$key] }}
                                                                         @else
                                                                             <b>Gratuit</b>
                                                                         @endif
                                                                     </td>
                                                                     <td class="text-right">
                                                                         @if($tprice[$key] > 0 )
                                                                             {!! use_currency()->symbol !!} {{ number_format($tprice[$key]*$tqty[$key], 0) }}
                                                                         @else
                                                                             <b> - </b>
                                                                         @endif
                                                                     </td>
                                                                     <td class="text-right">
                                                                         @if($tprice[$key] > 0 )
                                                                             {!! use_currency()->symbol !!} {{ number_format($tfees[$key]*$tqty[$key], 0) }}
                                                                         @else
                                                                             <b> - </b>
                                                                         @endif
                                                                     </td>
                                                                     <td class="text-right">
                                                                         @if($tprice[$key] > 0 )
                                                                             {!! use_currency()->symbol !!} {{ number_format(($tfees[$key] + $tprice[$key])*$tqty[$key], 0) }}
                                                                         @else
                                                                             <b>Gratuit</b>
                                                                         @endif
                                                                     </td>
                                                                 </tr>
                                                                 @php $price_total[] = number_format($tprice[$key], 0) @endphp
                                                                 @php $total_price[] = number_format($tprice[$key]*$tqty[$key],
                                                                 0) @endphp
                                                                 @php $total_commi[] = number_format($tfees[$key]*$tqty[$key],
                                                                 0) @endphp
                                                                 @php $final_total[] = number_format(($tfees[$key] +
                                                                 $tprice[$key])*$tqty[$key], 0) @endphp
                                                                 @php $total_qty[]    = $tqty[$key]  @endphp
                                                             @endforeach
                                                         @endforeach
                                                     @else
                                                         <tr>
                                                             <td colspan="">
                                                             @lang('words.mng_eve.eve_not_f_t')
                                                             <td/>
                                                         </tr>
                                                     @endif
                                                     </tbody>
                                                     <tfoot class="table-footer">
                                                     <tr>
                                                         <td colspan="2"></td>
                                                         <td class="text-center">
                                                             @if(!empty($total_qty))
                                                                 {{ array_sum($total_qty) }}
                                                             @endif
                                                         </td>
                                                         <td class="text-right">
                                                             @if(!empty($price_total))
                                                                 {!! use_currency()->symbol !!} {{ number_format(array_sum($price_total),0) }}
                                                             @endif
                                                         </td>
                                                         <td class="text-right">
                                                             @if(!empty($total_price))
                                                                 {!! use_currency()->symbol !!} {{ number_format(array_sum($total_price),0) }}
                                                             @endif
                                                         </td>
                                                         <td class="text-right">
                                                             @if(!empty($total_commi))
                                                                 {!! use_currency()->symbol !!} {{ number_format(array_sum($total_commi),0) }}
                                                             @endif
                                                         </td>
                                                         <td class="text-right">
                                                             @if(!empty($final_total))
                                                                 {!! use_currency()->symbol !!} {{ number_format(array_sum($final_total),0) }}
                                                             @endif
                                                         </td>
                                                     </tr>
                                                     </tfoot>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!--Ajout participants -->
                             <div class="tab-pane" id="tab-4">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>@lang('words.events_tik_tbl.eve_tik_tit')</h3>
                                             </div>

                                             <div class="alert alert-primary mt-2 mb-2" role="alert">
                                                 <i class="fas fa-info-circle"></i>
                                              <small>   @lang('words.events_tik_tbl.evet_checked_status')</small>
                                             </div>

                                             <div class="table-responsive">
                                                 <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                     <thead class="table-head">
                                                     <tr>
                                                         <th>@lang('words.events_tik_tbl.eve_tik_1')</th>
                                                         <th>@lang('words.events_tik_tbl.eve_tik_2')</th>
                                                         <th>@lang('words.events_tik_tbl.eve_tik_3')</th>
                                                         <th>@lang('words.events_tik_tbl.eve_tik_4')</th>
                                                         <th>@lang('words.events_tik_tbl.eve_tik_5')</th>
                                                     </tr>
                                                     </thead>
                                                     <tbody>

                                                     @if(count($eventTicket) > 0 )
                                                         @php $order_id = ''; @endphp
                                                         @foreach($eventTicket as $key => $val)
                                                             @if($val->order_status == 1)
                                                                 @if($order_id != $val->ot_order_id)
                                                                     <tr style="background:#fcfcfc; font-weight:700;">
                                                                         <td colspan="1">
                                                                             <strong>@lang('words.events_tik_tbl.eve_tik_1')
                                                                                 : </strong> <strong
                                                                                     style="letter-spacing:2px;">{{ $val->ot_order_id }}</strong>
                                                                         </td>
                                                                         <td colspan="2">
                                                                             @if(! is_null($val->gust_id))
                                                                                 {{ $val->ot_f_name }}
                                                                             @else
                                                                                 {{ $val->USER_FNAME }} {{ $val->USER_LNAME }}
                                                                             @endif
                                                                         </td>
                                                                         <td colspan="2">
                                                                             {{ $val->ot_email }}
                                                                         </td>
                                                                     </tr>
                                                                 @endif
                                                                 @php $order_id = $val->ot_order_id; @endphp
                                                                 <tr>
                                                                     <td>{{ $val->ot_order_id }}</td>
                                                                     <td>{{ $val->ot_qr_code }}</td>
                                                                     <td>{{ $val->TICKE_TITLE }}</td>
                                                                     <td>{{ $val->ot_f_name }} {{ $val->ot_l_name }}</td>
                                                                     <td>
                                                                         <div class="gernal-label">
                                                                             {{--Si ot_status == 1 alors le ticket à déjà été scanné--}}
                                                                             @if($val->ot_status==0)
                                                                                 <label class="label label-status"
                                                                                        style="width:85px;">@lang('words.events_tik_tbl.eve_tik_6')</label>
                                                                             @else
                                                                                 <label class="label label-publish "
                                                                                        style="width:85px;">@lang('words.events_tik_tbl.eve_tik_7')</label>
                                                                             @endif
                                                                         </div>
                                                                     </td>
                                                                 </tr>
                                                             @endif
                                                         @endforeach
                                                     @else
                                                         <tr>
                                                             <td colspan="4">
                                                             @lang('words.events_tik_tbl.eve_not_fo')
                                                             <td/>
                                                         </tr>
                                                     @endif
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!--Contact  participants -->
                             <div class="tab-pane" id="tab-5">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>Ajout de participant</h3>
                                             </div>
                                             {!! Form::open(['route' => 'attendee.book','method' => 'post']) !!}
                                             <input type="hidden" name="item_id" value="{{ $gadget->item_unique_id }}">

                                             <div class="table-responsive"   id="tblProducts">
                                                 <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                     <thead class="table-head">
                                                     <tr>
                                                         <th>Type de ticket</th>
                                                         <th>Vendu</th>
                                                         <th>Prix *</th>
                                                         <th>Quantité</th>
                                                         <th>Montant payé</th>
                                                     </tr>
                                                     </thead>
                                                     <tbody>
                                                     @if(! $eventOrderTickets->isEmpty())
                                                         @foreach($eventOrderTickets as $attekey => $attenkets)
                                                             <tr>
                                                                 <td>{{ $attenkets->TICKE_TITLE }}</td>
                                                                 <td>{{ $attenkets->TICKE_QTY - $attenkets->ticket_remaning_qty }}
                                                                     / {{ $attenkets->TICKE_QTY }}</td>
                                                                 <td>
                                                                     @if($attenkets->TICKE_PRICE_ACTUAL > 0)
                                                                         {{ use_currency()->symbol }} {{ $attenkets->TICKE_PRICE_ACTUAL }}
                                                                     @else
                                                                         @if($attenkets->ticket_type == 0)
                                                                             Gratuit
                                                                         @else
                                                                             Dons
                                                                         @endif
                                                                     @endif
                                                                     <input type="hidden" name="price[]"
                                                                            value="{{ $attenkets->TICKE_PRICE_ACTUAL }}"
                                                                            class="price">
                                                                     <input type="hidden" name="ticket_id[]"
                                                                            value="{{ $attenkets->ticket_id }}">
                                                                     <input type="hidden" name="tid[]"
                                                                            value="{{ $attenkets->id }}">
                                                                     <input type="hidden" name="total_ticket" value=""
                                                                            id="total_tik">
                                                                 </td>
                                                                 <td>
                                                                     @if($attenkets->ticket_type != 2)
                                                                         <input type="text" class="qty" name="ticket_type_qty[]"
                                                                                value="0"
                                                                                data-remain="{{$attenkets->ticket_remaning_qty}}"/>
                                                                     @else
                                                                         Donation
                                                                     @endif
                                                                 </td>
                                                                 <td class="my-total">
                                                                     @if($attenkets->ticket_type == 2)
                                                                         <input type="text" name="ticket_type_dns[{{$attekey}}]"
                                                                                class="donation subtot">
                                                                         <input type="hidden" name="ticket_type_qty[]" value="1"
                                                                                disabled="" id="donation-tik">
                                                                     @else
                                                                         <input type="text" name="amount[]" class="subtot"
                                                                                value="0.00" disabled="">
                                                                     @endif
                                                                     <span class="curency-span">{{use_currency()->symbol}}</span>
                                                                 </td>
                                                             </tr>
                                                         @endforeach
                                                     @else
                                                         <tr class="text-center">
                                                             <td colspan="5">{{--Not found.--}}Aucun</td>
                                                         </tr>
                                                     @endif
                                                     </tbody>
                                                     @if(! $eventOrderTickets->isEmpty())
                                                         <tfoot>
                                                         <tr>
                                                             <td></td>
                                                             <td></td>
                                                             <td></td>
                                                             <td class="text-right"><p class="total-text">Total</p></td>
                                                             <td class="my-total">
                                                                 <input type="text" class="grdtot subtots" value="0.00"
                                                                        name="total_amount" disabled/>
                                                                 <span class="curency-span">{{ use_currency()->symbol}}</span>
                                                             </td>
                                                         </tr>
                                                         </tfoot>
                                                     @endif
                                                 </table>
                                             </div>
                                             @if(! $eventOrderTickets->isEmpty())
                                                 <div>
                                                     <div class="alert alert-warning" role="alert">
                                                             <i class="fas fa-exclamation-triangle"></i> <small>
                                                             Les tickets ajoutés manuellement ne seront pas traités via l'application. Vous devez traiter manuellement ces transactions.
                                                         </small>
                                                     </div>
                                                     <br>
                                                     <br>

                                                     <div class="row">
                                                         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                             <select id="pp_payment_status" name="pp_payment_status"
                                                                     class="form-control form-textbox">
                                                                 <option value="check">{{--Paid with check--}}Payé par chèque</option>
                                                                 <option value="cash">{{--Paid with cash--}}Payé en espèce</option>
                                                                 <option value="paypal">{{--Paid directly online with PayPal--}}Payé directement en ligne avec PayPal</option>
                                                                 <option value="online">{{--Paid online non-PayPal--}}Payé en ligne non-PayPal</option>
                                                                 <option value="comp">{{--Complimentary--}}Gratuit</option>
                                                                 <option value="free">{{--No payment necessary--}}Aucun paiement nécessaire</option>
                                                                 <option value="voucher">{{--Paid With Voucher--}}Payé avec bon</option>
                                                                 <option value="credit">{{--Paid Directly By Credit Card--}}Payé directement par carte de crédit</option>
                                                                 <option value="debit">{{--Paid Directly By Debit Card--}}Payé directement par carte de débit</option>
                                                                 <option value="other">{{--Other--}}Autre</option>
                                                             </select>
                                                         </div>
                                                         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                             <button class="btn add-event-live" type="submit" disabled
                                                                     id="mual-con">Continue
                                                             </button>
                                                         </div>
                                                     </div>
                                                     <br>
                                                 </div>
                                             @endif
                                             {!! Form::close() !!}
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!--Embed  Events -->
                             <div class="tab-pane" id="tab-6">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>Contact des participants</h3>
                                             </div>
                                             <div class="table-responsive" id="tblProducts">
                                                 <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                                     <thead class="table-head">
                                                     <tr>
                                                         <th><input type="checkbox" name="multi_sends" id="multi_send"
                                                                    class="checkbox">&nbsp;Select All
                                                         </th>
                                                         <th>#id du ticket</th>
                                                         <th>Nom complet</th>
                                                         <th>Email</th>
                                                         <th>Type de paiement</th>
                                                         <!--<th class="text-center">Action</th>-->
                                                     </tr>
                                                     </thead>
                                                     <tbody>
                                                     @if(! $contactAttendes->isEmpty())
                                                         @foreach($contactAttendes as $keylor => $kcontactAttendes)
                                                             <tr>
                                                                 <td>
                                                                     <input type="checkbox" name="multi_send_email"
                                                                            id="multi_send_{{$kcontactAttendes->ot_order_id}}"
                                                                            value="{{$kcontactAttendes->ot_email}}"
                                                                            data-id="{{$kcontactAttendes->ot_order_id}}"
                                                                            data-email="{{$kcontactAttendes->ot_email}}"
                                                                            class="checkbox multi_send button-email">
                                                                 </td>
                                                                 <td>#{{ $kcontactAttendes->ot_order_id}}</td>
                                                                 <td>{{ $kcontactAttendes->ot_f_name }} {{ $kcontactAttendes->ot_l_name }}</td>
                                                                 <td>{{ $kcontactAttendes->ot_email }}</td>
                                                                 <td>{{ ucwords($kcontactAttendes->payment_gateway) }}</td>
                                                             </tr>
                                                         @endforeach
                                                     @else
                                                         <tr>
                                                             <td colspan="5">Aucun particpant</td>
                                                         </tr>
                                                     @endif
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="tab-pane" id="tab-7">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>Inclure l'événement</h3>
                                             </div>
                                             <div class="iframe-snip">
                                                 <iframe src="{{ route('snippet.event',\Crypt::encrypt($gadget->item_slug)) }}"
                                                         allow="fullscreen" width="420" height="420"></iframe>
                                             </div>
                                             <div class="">
                                                 <br>
                                                 <button type="button" class="snippet-btn"><img
                                                             src="{{ asset('/img/loader.gif') }}" id="load-img"
                                                             style="display: none;"> Générer
                                                 </button>
                                                 <div id="proceed" onclick="copyDivToClipboard()" data-toggle="tooltip"
                                                      title="Click to copy" style="display: none;">
                                                     &lt;iframe
                                                     src="{{route('snippet.event',Crypt::encrypt($gadget->item_slug))}}"
                                                     width="420" height="420" allow="fullscreen" style="border: 0;"
                                                     scrolling="no">&lt;/iframe&gt;
                                                 </div>
                                             </div>

                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="tab-pane" id="tab-8">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="tickets-type">
                                             <div class="header">
                                                 <h3>Lien personnalisé</h3>
                                             </div>
                                             @if(! is_null($gadget->item_link_slug))
                                                 <label class="text-uppercase label-text">Link:</label>
                                                 <div id="link-status">
                                                     <a href="{{ route('custom.slug',$gadget->item_link_slug) }}"
                                                        target="_blank">{{ route('custom.slug',$gadget->item_link_slug) }}</a>
                                                 </div>
                                             @else
                                                 <label class="text-uppercase label-text" id="links-show" style="display: none;">Link:</label>
                                                 <div id="link-status"></div>
                                             @endif
                                             <div class="form-group">
                                                 <label class=" label-text">Lien personnalisé</label>

                                                 <div class="input-group mb-3">
                                                     <div class="input-group-prepend">
                                                <span class="input-group-text form-textbox" id="basic-addon3">{{URL::to('/')}}
                                                    /</span>
                                                     </div>
                                                     <input type="text" name="item_link_slug" class="form-control form-textbox"
                                                            id="basic-url" aria-describedby="basic-addon3"
                                                            value="{{ $gadget->item_link_slug }}">
                                                 </div>
                                                 <input type="submit" name="send" id="linkgenerate" value="Générer"
                                                        class="btn btn-primary form-textbox" data-id="{{ $gadget->id }}">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>


                <!--Autres stats-->
                <div class="tab-pane" id="tab-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tickets-type">
                                <div class="header">
                                    <h3>@lang('words.events_tik_tbl.eve_tik_tit')</h3>
                                </div>

                                <div class="alert alert-primary mt-2 mb-2" role="alert">
                                    <i class="fas fa-info-circle"></i>
                                    <small>   @lang('words.events_tik_tbl.evet_checked_status')</small>
                                </div>

                                <div class="table-responsive">
                                    <table id="tableaux" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="table-head">
                                        <tr>
                                            <th>@lang('words.events_tik_tbl.eve_tik_1')</th>
                                            <th>@lang('words.events_tik_tbl.eve_tik_2')</th>
                                            <th>@lang('words.events_tik_tbl.eve_tik_3')</th>
                                            <th>@lang('words.events_tik_tbl.eve_tik_4')</th>
                                            <th>@lang('words.events_tik_tbl.eve_tik_5')</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($eventTicket) > 0 )
                                            @php $order_id = ''; @endphp
                                            @foreach($eventTicket as $key => $val)
                                                @if($val->order_status != 1)
                                                    @if($order_id != $val->ot_order_id)
                                                        <tr style="background:#fcfcfc; font-weight:700;">
                                                            <td colspan="1">
                                                                <strong>@lang('words.events_tik_tbl.eve_tik_1')
                                                                    : </strong> <strong
                                                                        style="letter-spacing:2px;">{{ $val->ot_order_id }}</strong>
                                                            </td>
                                                            <td colspan="2">
                                                                @if(! is_null($val->gust_id))
                                                                    {{ $val->ot_f_name }}
                                                                @else
                                                                    {{ $val->USER_FNAME }} {{ $val->USER_LNAME }}
                                                                @endif
                                                            </td>
                                                            <td colspan="2">
                                                                {{ $val->ot_email }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @php $order_id = $val->ot_order_id; @endphp
                                                    <tr>
                                                        <td>{{ $val->ot_order_id }}</td>
                                                        <td>{{ $val->ot_qr_code }}</td>
                                                        <td>{{ $val->TICKE_TITLE }}</td>
                                                        <td>{{ $val->ot_f_name }} {{ $val->ot_l_name }} </td>
                                                        <td>
                                                            <div class="gernal-label">
                                                                {{--Si ot_status == 1 alors le ticket à déjà été scanné--}}
                                                                @if($val->ot_status==0)
                                                                    <label class="label label-status"
                                                                           style="width:85px;">@lang('words.events_tik_tbl.eve_tik_6') {{ $val->PAYMENT_GATE }}</label>
                                                                @else
                                                                    <label class="label label-publish "
                                                                           style="width:85px;">@lang('words.events_tik_tbl.eve_tik_7')</label>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                @lang('words.events_tik_tbl.eve_not_fo')
                                                <td/>
                                            </tr>
                                        @endif
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
             </div>
             </div>


                {{--<div class="row">--}}
                    {{--<div class="col-lg-3 col-md-4 col-sm-12">--}}
                        {{--<div class="event-sidebar">--}}
                            {{--<ul class="nav nav-tabs text-capitalize">--}}
                                {{--<li>--}}
                                    {{--<a  class="active show" data-toggle="tab" href="#item2">@lang('words.mng_dash_tab.mng_tab_2') </a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item3">@lang('words.mng_dash_tab.mng_tab_3') </a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item4">@lang('words.mng_dash_tab.mng_tab_4') </a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item5">@lang('words.mng_dash_tab.mng_tab_5') </a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item6">Add Attendees</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item7">Contact Attendees</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item8">Event Snippet</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a data-toggle="tab" href="#item9">Custom Link</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                            {{--<div><a href="{{ route('events.attendee', $gadget->item_unique_id) }}"--}}
                                    {{--class="add_tickets pro-choose-file" style="width: auto !important;"><i class="fas fa-download"></i> Télécharger la liste des participants</a></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-9 col-md-8 col-sm-12">--}}
                        {{--<div class="tab-content">--}}
                            {{--<div id="item2" class="tab-pane fade in active">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>@lang('words.eve_order.eve_book_tbl_tit')</h3>--}}
                                    {{--</div>--}}
                                    {{--<div class="table-responsive">--}}
                                         {{--<table class="table table-bordered">--}}
                                            {{--<thead class="table-head">--}}
                                            {{--<tr>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_1')</th>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_2')</th>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_3')</th>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_4')</th>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_5')</th>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_6')</th>--}}
                                                {{--<th>@lang('words.eve_order.eve_book_tbl_7')</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}
                                            {{--@if(count($bookedeve) > 0 )--}}
                                                {{--@foreach($bookedeve as $key => $val)--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{ $val->order_id }}</td>--}}
                                                        {{--<td>--}}
                                                            {{--@if(! is_null($val->gust_id))--}}
                                                                {{--{{ $val->user_name }}--}}
                                                            {{--@else--}}
                                                                {{--{{ $val->fnm }} {{ $val->lnm }}--}}
                                                            {{--@endif--}}
                                                        {{--</td>--}}
                                                        {{--<td class="text-center">{{ $val->order_tickets }}</td>--}}
                                                        {{--<td>{!! use_currency()->symbol !!} {{ $val->order_amount }}</td>--}}
                                                        {{--<td>{{ date_format($val->created_at,'M, d Y')}}</td>--}}
                                                        {{--<td>--}}
                                                            {{--@php--}}
                                                            {{--$order_t_id = unserialize($val->order_t_id);--}}
                                                            {{--$order_t_title = unserialize($val->order_t_title);--}}
                                                            {{--$order_t_price = unserialize($val->order_t_price);--}}
                                                            {{--$order_t_fees = unserialize($val->order_t_fees);--}}
                                                            {{--$order_t_qty = unserialize($val->order_t_qty);--}}
                                                            {{--@endphp--}}
                                                            {{--<button data-toggle="modal"--}}
                                                                    {{--data-target="#Model-{{ $val->order_id }}"><i--}}
                                                                        {{--class="fa fa-eye"></i>&nbsp; @lang('words.eve_order.view_ord_vew')--}}
                                                            {{--</button>--}}
                                                            {{--<div class="modal fade" id="Model-{{ $val->order_id }}">--}}
                                                                {{--<div class="modal-dialog modal-lg">--}}
                                                                    {{--<div class="modal-content">--}}
                                                                        {{--<!-- Modal Header -->--}}
                                                                        {{--<div class="modal-header">--}}
                                                                            {{--<h4 class="modal-title"> {{ $val->order_id }}</h4>--}}
                                                                        {{--</div>--}}

                                                                        {{--<!-- Modal body -->--}}
                                                                        {{--<div class="modal-body">--}}
                                                                            {{--<div class="text-body">--}}
                                                                                {{--<p>--}}
                                                                                    {{--<strong>--}}
                                                                                        {{--@if(! is_null($val->gust_id))--}}
                                                                                            {{--{{ $val->user_name }}--}}
                                                                                        {{--@else--}}
                                                                                            {{--{{ $val->fnm }} {{ $val->lnm }}--}}
                                                                                        {{--@endif--}}
                                                                                    {{--</strong>--}}
                                                                                    {{--({{ ! is_null($val->gust_id)?$val->guest_email:$val->mail }}--}}
                                                                                    {{--)--}}
                                                                                    {{--on {{ date_format($val->created_at,'M d, Y  h:i A') }}--}}
                                                                                {{--</p>--}}

                                                                                {{--<div class="gernal-label">--}}
                                                                                    {{--@if($val->order_status == 1)--}}
                                                                                        {{--<label class="label label-publish">@lang('words.view_ord_tbl.view_order_label')</label>--}}
                                                                                    {{--@elseif($val->order_status == 2)--}}
                                                                                        {{--<label class="label label-draft">@lang('words.view_ord_tbl.view_cancel_label')</label>--}}
                                                                                    {{--@else--}}
                                                                                        {{--<label class="label label-status">@lang('words.view_ord_tbl.view_progress_label')</label>--}}
                                                                                        {{--@endif--}}
                                                                                                {{--<!-- <span>Free Order</span> -->--}}
                                                                                {{--</div>--}}
                                                                            {{--</div>--}}
                                                                            {{--<hr/>--}}
                                                                            {{--<div class="tickets-type table-responsive">--}}
                                                                                 {{--<table class="table table-bordered">--}}
                                                                                    {{--<thead class="table-head">--}}
                                                                                    {{--<tr>--}}
                                                                                        {{--<th>@lang('words.view_ord_tbl.view_ord_tbl_1')</th>--}}
                                                                                        {{--<th>@lang('words.view_ord_tbl.view_ord_tbl_2')</th>--}}
                                                                                        {{--<th class="text-center">@lang('words.view_ord_tbl.view_ord_tbl_3')</th>--}}
                                                                                        {{--<th class="text-right">@lang('words.view_ord_tbl.view_ord_tbl_4')</th>--}}
                                                                                        {{--<th class="text-right">@lang('words.view_ord_tbl.view_ord_tbl_5')</th>--}}
                                                                                    {{--</tr>--}}
                                                                                    {{--</thead>--}}
                                                                                    {{--<tbody>--}}
                                                                                    {{--@if(!empty($order_t_id))--}}
                                                                                        {{--@foreach($order_t_id as $key => $ticket)--}}
                                                                                            {{--<tr>--}}
                                                                                                {{--<td width="30%">{{ $order_t_title[$key] }}</td>--}}
                                                                                                {{--<td>@php $tType--}}
                                                                                                    {{--=(floatval($order_t_price[$key])>0)?'paid':'free' @endphp {{$tType}}</td>--}}
                                                                                                {{--<td class="text-center">{{ $order_t_qty[$key] }}</td>--}}
                                                                                                {{--<td class="text-right">{!! use_currency()->symbol !!} {{ number_format((floatval($order_t_price[$key]) + floatval($order_t_fees[$key])),0) }}</td>--}}
                                                                                                {{--<td class="text-right">{!! use_currency()->symbol !!} {{ number_format((floatval($order_t_price[$key]) + floatval($order_t_fees[$key])) * intval($order_t_qty[$key]),0) }}</td>--}}
                                                                                            {{--</tr>--}}
                                                                                        {{--@endforeach--}}
                                                                                    {{--@endif--}}
                                                                                    {{--</tbody>--}}
                                                                                    {{--<tfoot class="table-footer">--}}
                                                                                    {{--<tr>--}}
                                                                                        {{--<td></td>--}}
                                                                                        {{--<td></td>--}}
                                                                                        {{--<td class="text-center">{{ $val->order_tickets }}</td>--}}
                                                                                        {{--<td></td>--}}
                                                                                        {{--<td class="text-right">{!! use_currency()->symbol !!} {{ $val->order_amount }}</td>--}}
                                                                                    {{--</tr>--}}
                                                                                    {{--</tfoot>--}}
                                                                                {{--</table>--}}
                                                                            {{--</div>--}}
                                                                        {{--</div>--}}
                                                                        {{--<!-- Modal footer -->--}}
                                                                        {{--<div class="modal-footer">--}}
                                                                            {{--<button type="button"--}}
                                                                                    {{--class="btn btn-sm btn-flat btn-danger"--}}
                                                                                    {{--data-dismiss="modal">@lang('words.view_ord_tbl.view_ord_tbl_6')</button>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</td>--}}
                                                        {{--<td>--}}
                                                            {{--<div class="gernal-label">--}}
                                                                {{--@if($val->order_status == 1)--}}
                                                                    {{--<label class="label label-publish">@lang('words.view_ord_tbl.view_order_label')</label>--}}
                                                                {{--@elseif($val->order_status == 2)--}}
                                                                    {{--<label class="label label-draft">@lang('words.view_ord_tbl.view_cancel_label')</label>--}}
                                                                {{--@else--}}
                                                                    {{--<label class="label label-status">@lang('words.view_ord_tbl.view_progress_label')</label>--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}
                                                        {{--</td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<tr>--}}
                                                    {{--<td colspan="">--}}
                                                    {{--@lang('words.mng_eve.eve_not_f_t')--}}
                                                    {{--<td/>--}}
                                                {{--</tr>--}}
                                            {{--@endif--}}
                                            {{--</tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div id="item3" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>@lang('words.eve_book_mark.eve_book_tbl_tit')</h3>--}}
                                    {{--</div>--}}
                                    {{--<div class="table-responsive">--}}
                                         {{--<table class="table table-bordered">--}}
                                            {{--<thead class="table-head">--}}
                                            {{--<tr>--}}
                                                {{--<th>@lang('words.eve_book_mark.eve_book_tbl_1')</th>--}}
                                                {{--<th>@lang('words.eve_book_mark.eve_book_tbl_2')</th>--}}
                                                {{--<th>@lang('words.eve_book_mark.eve_book_tbl_3')</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}
                                            {{--@if(count($databook) > 0 )--}}
                                                {{--@foreach($databook as $key => $val)--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{ $val->fnm }} {{ $val->lnm }}</td>--}}
                                                        {{--<td>{{ $val->mail }}</td>--}}
                                                        {{--<td>{{ date_format($val->created_at,'d-m-y h:i A') }}</td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<tr>--}}
                                                    {{--<td colspan="">--}}
                                                    {{--@lang('words.eve_book_mark.eve_no_an_sav')--}}
                                                    {{--<td/>--}}
                                                {{--</tr>--}}
                                            {{--@endif--}}
                                            {{--</tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div id="item4" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>@lang('words.eve_book_earn.earn_eve_tit')</h3>--}}
                                    {{--</div>--}}
                                    {{--<div class="table-responsive">--}}
                                         {{--<table class="table table-bordered">--}}
                                            {{--<thead class="table-head">--}}
                                            {{--<tr>--}}
                                                {{--<th width="30%">@lang('words.eve_book_earn.earn_tbl_1')</th>--}}
                                                {{--<th width="10%">@lang('words.eve_order.eve_book_tbl_1')</th>--}}
                                                {{--<th class="text-center">@lang('words.eve_book_earn.earn_tbl_2')</th>--}}
                                                {{--<th width="15%"--}}
                                                    {{--class="text-right">@lang('words.eve_book_earn.earn_tbl_3')</th>--}}
                                                {{--<th width="15%"--}}
                                                    {{--class="text-right">@lang('words.eve_book_earn.earn_tbl_4')</th>--}}
                                                {{--<th width="15%"--}}
                                                    {{--class="text-right">@lang('words.eve_book_earn.earn_tbl_5')</th>--}}
                                                {{--<th width="15%"--}}
                                                    {{--class="text-right">@lang('words.eve_book_earn.earn_tbl_6')</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}
                                            {{--@if(count($data) > 0 )--}}
                                                {{--@foreach($data as $okey => $order)--}}
                                                    {{--@php--}}
                                                    {{--$tickets    = unserialize($order->order_t_id);--}}
                                                    {{--$ttitle        = unserialize($order->order_t_title);--}}
                                                    {{--$tqty        = unserialize($order->order_t_qty);--}}
                                                    {{--$tprice        = unserialize($order->order_t_price);--}}
                                                    {{--$tfees        = unserialize($order->order_t_fees);--}}
                                                    {{--@endphp--}}
                                                    {{--@foreach($tickets as $key => $val)--}}
                                                        {{--<tr>--}}
                                                            {{--<td>{{ $ttitle[$key] }}</td>--}}
                                                            {{--<td>{{ $order->order_id }}</td>--}}
                                                            {{--<td class="text-center">{{ $tqty[$key] }}</td>--}}
                                                            {{--<td class="text-right">--}}
                                                                {{--@if($tprice[$key] > 0 )--}}
                                                                    {{--{!! use_currency()->symbol !!} {{ $tprice[$key] }}--}}
                                                                {{--@else--}}
                                                                    {{--<b>FREE</b>--}}
                                                                {{--@endif--}}
                                                            {{--</td>--}}
                                                            {{--<td class="text-right">--}}
                                                                {{--@if($tprice[$key] > 0 )--}}
                                                                    {{--{!! use_currency()->symbol !!} {{ number_format($tprice[$key]*$tqty[$key], 0) }}--}}
                                                                {{--@else--}}
                                                                    {{--<b> - </b>--}}
                                                                {{--@endif--}}
                                                            {{--</td>--}}
                                                            {{--<td class="text-right">--}}
                                                                {{--@if($tprice[$key] > 0 )--}}
                                                                    {{--{!! use_currency()->symbol !!} {{ number_format($tfees[$key]*$tqty[$key], 0) }}--}}
                                                                {{--@else--}}
                                                                    {{--<b> - </b>--}}
                                                                {{--@endif--}}
                                                            {{--</td>--}}
                                                            {{--<td class="text-right">--}}
                                                                {{--@if($tprice[$key] > 0 )--}}
                                                                    {{--{!! use_currency()->symbol !!} {{ number_format(($tfees[$key] + $tprice[$key])*$tqty[$key], 0) }}--}}
                                                                {{--@else--}}
                                                                    {{--<b>FREE</b>--}}
                                                                {{--@endif--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                        {{--@php $price_total[] = number_format($tprice[$key], 0) @endphp--}}
                                                        {{--@php $total_price[] = number_format($tprice[$key]*$tqty[$key],--}}
                                                        {{--0) @endphp--}}
                                                        {{--@php $total_commi[] = number_format($tfees[$key]*$tqty[$key],--}}
                                                        {{--0) @endphp--}}
                                                        {{--@php $final_total[] = number_format(($tfees[$key] +--}}
                                                        {{--$tprice[$key])*$tqty[$key], 0) @endphp--}}
                                                        {{--@php $total_qty[]    = $tqty[$key]  @endphp--}}
                                                    {{--@endforeach--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<tr>--}}
                                                    {{--<td colspan="">--}}
                                                    {{--@lang('words.mng_eve.eve_not_f_t')--}}
                                                    {{--<td/>--}}
                                                {{--</tr>--}}
                                            {{--@endif--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot class="table-footer">--}}
                                            {{--<tr>--}}
                                                {{--<td colspan="2"></td>--}}
                                                {{--<td class="text-center">--}}
                                                    {{--@if(!empty($total_qty))--}}
                                                        {{--{{ array_sum($total_qty) }}--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                                {{--<td class="text-right">--}}
                                                    {{--@if(!empty($price_total))--}}
                                                        {{--{!! use_currency()->symbol !!} {{ number_format(array_sum($price_total),0) }}--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                                {{--<td class="text-right">--}}
                                                    {{--@if(!empty($total_price))--}}
                                                        {{--{!! use_currency()->symbol !!} {{ number_format(array_sum($total_price),0) }}--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                                {{--<td class="text-right">--}}
                                                    {{--@if(!empty($total_commi))--}}
                                                        {{--{!! use_currency()->symbol !!} {{ number_format(array_sum($total_commi),0) }}--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                                {{--<td class="text-right">--}}
                                                    {{--@if(!empty($final_total))--}}
                                                        {{--{!! use_currency()->symbol !!} {{ number_format(array_sum($final_total),0) }}--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div id="item5" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>@lang('words.events_tik_tbl.eve_tik_tit')</h3>--}}
                                    {{--</div>--}}
                                    {{--<span style="color: #f16334;font-size: 14px;">@lang('words.events_tik_tbl.evet_checked_status')</span>--}}

                                    {{--<div class="table-responsive">--}}
                                         {{--<table class="table table-bordered">--}}
                                            {{--<thead class="table-head">--}}
                                            {{--<tr>--}}
                                                {{--<th>@lang('words.events_tik_tbl.eve_tik_1')</th>--}}
                                                {{--<th>@lang('words.events_tik_tbl.eve_tik_2')</th>--}}
                                                {{--<th>@lang('words.events_tik_tbl.eve_tik_3')</th>--}}
                                                {{--<th>@lang('words.events_tik_tbl.eve_tik_4')</th>--}}
                                                {{--<th>@lang('words.events_tik_tbl.eve_tik_5')</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}

                                            {{--@if(count($eventTicket) > 0 )--}}
                                                {{--@php $order_id = ''; @endphp--}}
                                                {{--@foreach($eventTicket as $key => $val)--}}
                                                    {{--@if($order_id != $val->ot_order_id)--}}
                                                        {{--<tr style="background:#fcfcfc; font-weight: 700;">--}}
                                                            {{--<td colspan="1">--}}
                                                                {{--<strong>@lang('words.events_tik_tbl.eve_tik_1')--}}
                                                                    {{--: </strong> <strong--}}
                                                                        {{--style="letter-spacing:2px;">{{ $val->ot_order_id }}</strong>--}}
                                                            {{--</td>--}}
                                                            {{--<td colspan="2">--}}
                                                                {{--@if(! is_null($val->gust_id))--}}
                                                                    {{--{{ $val->ot_f_name }}--}}
                                                                {{--@else--}}
                                                                    {{--{{ $val->USER_FNAME }} {{ $val->USER_LNAME }}--}}
                                                                {{--@endif--}}
                                                            {{--</td>--}}
                                                            {{--<td colspan="2">--}}
                                                                {{--{{ $val->ot_email }}--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                    {{--@endif--}}
                                                    {{--@php $order_id = $val->ot_order_id; @endphp--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{ $val->ot_order_id }}</td>--}}
                                                        {{--<td>{{ $val->ot_qr_code }}</td>--}}
                                                        {{--<td>{{ $val->TICKE_TITLE }}</td>--}}
                                                        {{--<td>{{ $val->ot_f_name }} {{ $val->ot_l_name }}</td>--}}
                                                        {{--<td>--}}
                                                            {{--<div class="gernal-label">--}}
                                                                {{--@if($val->ot_status==0)--}}
                                                                    {{--<label class="label label-status"--}}
                                                                           {{--style="width:85px;">@lang('words.events_tik_tbl.eve_tik_6')</label>--}}
                                                                {{--@else--}}
                                                                    {{--<label class="label label-publish "--}}
                                                                           {{--style="width:85px;">@lang('words.events_tik_tbl.eve_tik_7')</label>--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}
                                                        {{--</td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<tr>--}}
                                                    {{--<td colspan="4">--}}
                                                    {{--@lang('words.events_tik_tbl.eve_not_fo')--}}
                                                    {{--<td/>--}}
                                                {{--</tr>--}}
                                            {{--@endif--}}
                                            {{--</tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- Add Attendees -->--}}
                            {{--<div id="item6" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>Ajout de participants</h3>--}}
                                    {{--</div>--}}
                                    {{--{!! Form::open(['route' => 'attendee.book','method' => 'post']) !!}--}}
                                    {{--<input type="hidden" name="item_id" value="{{ $gadget->item_unique_id }}">--}}

                                    {{--<div class="table-responsive">--}}
                                        {{--<table class="table" id="tblProducts">--}}
                                            {{--<thead class="table-head">--}}
                                            {{--<tr>--}}
                                                {{--<th>Type de ticket</th>--}}
                                                {{--<th>Vendu</th>--}}
                                                {{--<th>Prix *</th>--}}
                                                {{--<th>Quantité</th>--}}
                                                {{--<th>Montant payé</th>--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}
                                            {{--@if(! $eventOrderTickets->isEmpty())--}}
                                                {{--@foreach($eventOrderTickets as $attekey => $attenkets)--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{ $attenkets->TICKE_TITLE }}</td>--}}
                                                        {{--<td>{{ $attenkets->TICKE_QTY - $attenkets->ticket_remaning_qty }}--}}
                                                            {{--/ {{ $attenkets->TICKE_QTY }}</td>--}}
                                                        {{--<td>--}}
                                                            {{--@if($attenkets->TICKE_PRICE_ACTUAL > 0)--}}
                                                                {{--{{ use_currency()->symbol }} {{ $attenkets->TICKE_PRICE_ACTUAL }}--}}
                                                            {{--@else--}}
                                                                {{--@if($attenkets->ticket_type == 0)--}}
                                                                    {{--FREE--}}
                                                                {{--@else--}}
                                                                    {{--Donation--}}
                                                                {{--@endif--}}
                                                            {{--@endif--}}
                                                            {{--<input type="hidden" name="price[]"--}}
                                                                   {{--value="{{ $attenkets->TICKE_PRICE_ACTUAL }}"--}}
                                                                   {{--class="price">--}}
                                                            {{--<input type="hidden" name="ticket_id[]"--}}
                                                                   {{--value="{{ $attenkets->ticket_id }}">--}}
                                                            {{--<input type="hidden" name="tid[]"--}}
                                                                   {{--value="{{ $attenkets->id }}">--}}
                                                            {{--<input type="hidden" name="total_ticket" value=""--}}
                                                                   {{--id="total_tik">--}}
                                                        {{--</td>--}}
                                                        {{--<td>--}}
                                                            {{--@if($attenkets->ticket_type != 2)--}}
                                                                {{--<input type="text" class="qty" name="ticket_type_qty[]"--}}
                                                                       {{--value="0"--}}
                                                                       {{--data-remain="{{$attenkets->ticket_remaning_qty}}"/>--}}
                                                            {{--@else--}}
                                                                {{--Donation--}}
                                                            {{--@endif--}}
                                                        {{--</td>--}}
                                                        {{--<td class="my-total">--}}
                                                            {{--@if($attenkets->ticket_type == 2)--}}
                                                                {{--<input type="text" name="ticket_type_dns[{{$attekey}}]"--}}
                                                                       {{--class="donation subtot">--}}
                                                                {{--<input type="hidden" name="ticket_type_qty[]" value="1"--}}
                                                                       {{--disabled="" id="donation-tik">--}}
                                                            {{--@else--}}
                                                                {{--<input type="text" name="amount[]" class="subtot"--}}
                                                                       {{--value="0.00" disabled="">--}}
                                                            {{--@endif--}}
                                                            {{--<span class="curency-span">{{use_currency()->symbol}}</span>--}}
                                                        {{--</td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<tr class="text-center">--}}
                                                    {{--<td colspan="5">Not found.</td>--}}
                                                {{--</tr>--}}
                                            {{--@endif--}}
                                            {{--</tbody>--}}
                                            {{--@if(! $eventOrderTickets->isEmpty())--}}
                                                {{--<tfoot>--}}
                                                {{--<tr>--}}
                                                    {{--<td></td>--}}
                                                    {{--<td></td>--}}
                                                    {{--<td></td>--}}
                                                    {{--<td class="text-right"><p class="total-text">Total</p></td>--}}
                                                    {{--<td class="my-total">--}}
                                                        {{--<input type="text" class="grdtot subtots" value="0.00"--}}
                                                               {{--name="total_amount" disabled/>--}}
                                                        {{--<span class="curency-span">{{ use_currency()->symbol}}</span>--}}
                                                    {{--</td>--}}
                                                {{--</tr>--}}
                                                {{--</tfoot>--}}
                                            {{--@endif--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                    {{--@if(! $eventOrderTickets->isEmpty())--}}
                                        {{--<div>--}}
                                            {{--<span><font color="#F16334">Manually added tickets will NOT be processed via--}}
                                                    {{--the application. You MUST manually process these--}}
                                                    {{--transactions.</font></span>--}}
                                            {{--<br>--}}
                                            {{--<br>--}}

                                            {{--<div class="row">--}}
                                                {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">--}}
                                                    {{--<select id="pp_payment_status" name="pp_payment_status"--}}
                                                            {{--class="form-control form-textbox">--}}
                                                        {{--<option value="check">Paid with check</option>--}}
                                                        {{--<option value="cash">Paid with cash</option>--}}
                                                        {{--<option value="paypal">Paid directly online with PayPal</option>--}}
                                                        {{--<option value="online">Paid online non-PayPal</option>--}}
                                                        {{--<option value="comp">Complimentary</option>--}}
                                                        {{--<option value="free">No payment necessary</option>--}}
                                                        {{--<option value="voucher">Paid With Voucher</option>--}}
                                                        {{--<option value="credit">Paid Directly By Credit Card</option>--}}
                                                        {{--<option value="debit">Paid Directly By Debit Card</option>--}}
                                                        {{--<option value="other">Other</option>--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">--}}
                                                    {{--<button class="btn add-event-live" type="submit" disabled--}}
                                                            {{--id="mual-con">Continue--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<br>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                    {{--{!! Form::close() !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- Add Attendees -->--}}
                            {{--<!-- Contact Attendees -->--}}
                            {{--<div id="item7" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>Contact To Attendes</h3>--}}
                                    {{--</div>--}}
                                    {{--<div class="table-responsive">--}}
                                        {{--<table class="table" id="tblProducts">--}}
                                            {{--<thead class="table-head">--}}
                                            {{--<tr>--}}
                                                {{--<th><input type="checkbox" name="multi_sends" id="multi_send"--}}
                                                           {{--class="checkbox">&nbsp;Select All--}}
                                                {{--</th>--}}
                                                {{--<th>#OrderId</th>--}}
                                                {{--<th>Full Name</th>--}}
                                                {{--<th>Email</th>--}}
                                                {{--<th>Payment Type</th>--}}
                                                {{--<!--<th class="text-center">Action</th>-->--}}
                                            {{--</tr>--}}
                                            {{--</thead>--}}
                                            {{--<tbody>--}}
                                            {{--@if(! $contactAttendes->isEmpty())--}}
                                                {{--@foreach($contactAttendes as $keylor => $kcontactAttendes)--}}
                                                    {{--<tr>--}}
                                                        {{--<td>--}}
                                                            {{--<input type="checkbox" name="multi_send_email"--}}
                                                                   {{--id="multi_send_{{$kcontactAttendes->ot_order_id}}"--}}
                                                                   {{--value="{{$kcontactAttendes->ot_email}}"--}}
                                                                   {{--data-id="{{$kcontactAttendes->ot_order_id}}"--}}
                                                                   {{--data-email="{{$kcontactAttendes->ot_email}}"--}}
                                                                   {{--class="checkbox multi_send button-email">--}}
                                                        {{--</td>--}}
                                                        {{--<td>#{{ $kcontactAttendes->ot_order_id}}</td>--}}
                                                        {{--<td>{{ $kcontactAttendes->ot_f_name }} {{ $kcontactAttendes->ot_l_name }}</td>--}}
                                                        {{--<td>{{ $kcontactAttendes->ot_email }}</td>--}}
                                                        {{--<td>{{ ucwords($kcontactAttendes->payment_gateway) }}</td>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                            {{--@else--}}
                                                {{--<tr>--}}
                                                    {{--<td colspan="5">Not found.</td>--}}
                                                {{--</tr>--}}
                                            {{--@endif--}}
                                            {{--</tbody>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            {{--</div>--}}
                            {{--<!-- Contact Attendees -->--}}
                            {{--<!-- Event Snippet start -->--}}
                            {{--<div id="item8" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>Event Snippet</h3>--}}
                                    {{--</div>--}}
                                    {{--<div class="iframe-snip">--}}
                                        {{--<iframe src="{{ route('snippet.event',\Crypt::encrypt($gadget->item_slug)) }}"--}}
                                                {{--allow="fullscreen" width="420" height="420"></iframe>--}}
                                    {{--</div>--}}
                                    {{--<div class="">--}}
                                        {{--<br>--}}
                                        {{--<button type="button" class="snippet-btn"><img--}}
                                                    {{--src="{{ asset('/img/loader.gif') }}" id="load-img"--}}
                                                    {{--style="display: none;"> Generate Snippet--}}
                                        {{--</button>--}}
                                        {{--<div id="proceed" onclick="copyDivToClipboard()" data-toggle="tooltip"--}}
                                             {{--title="Click to copy" style="display: none;">--}}
                                            {{--&lt;iframe--}}
                                            {{--src="{{route('snippet.event',Crypt::encrypt($gadget->item_slug))}}"--}}
                                            {{--width="420" height="420" allow="fullscreen" style="border: 0;"--}}
                                            {{--scrolling="no">&lt;/iframe&gt;--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<!-- Event Snippet Close-->--}}
                            {{--<div id="item9" class="tab-pane fade">--}}
                                {{--<div class="tickets-type">--}}
                                    {{--<div class="header">--}}
                                        {{--<h3>Custom Link</h3>--}}
                                    {{--</div>--}}
                                    {{--@if(! is_null($gadget->item_link_slug))--}}
                                        {{--<label class="text-uppercase label-text">Link:</label>--}}
                                        {{--<div id="link-status">--}}
                                            {{--<a href="{{ route('custom.slug',$gadget->item_link_slug) }}"--}}
                                               {{--target="_blank">{{ route('custom.slug',$gadget->item_link_slug) }}</a>--}}
                                        {{--</div>--}}
                                    {{--@else--}}
                                        {{--<label class="text-uppercase label-text" id="links-show" style="display: none;">Link:</label>--}}
                                        {{--<div id="link-status"></div>--}}
                                    {{--@endif--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label class="text-uppercase label-text">Custom link:</label>--}}

                                        {{--<div class="input-group mb-3">--}}
                                            {{--<div class="input-group-prepend">--}}
                                                {{--<span class="input-group-text form-textbox" id="basic-addon3">{{URL::to('/')}}--}}
                                                    {{--/</span>--}}
                                            {{--</div>--}}
                                            {{--<input type="text" name="item_link_slug" class="form-control form-textbox"--}}
                                                   {{--id="basic-url" aria-describedby="basic-addon3"--}}
                                                   {{--value="{{ $gadget->item_link_slug }}">--}}
                                        {{--</div>--}}
                                        {{--<input type="submit" name="send" id="linkgenerate" value="Generate"--}}
                                               {{--class="btn btn-primary form-textbox" data-id="{{ $gadget->id }}">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}



            </div>
        </section>
    </div>
@endsection
@section('pageScript')
    <script type="text/javascript" src="{{ asset('/js/dharmesh.js') }}"></script>
    <script type="text/javascript">

        $('#links-short').click(function (event) {
            $('#shtrlink').show();
        });

        function copyToClipboard() {
            var range = document.getSelection().getRangeAt(0);
            range.selectNode(document.getElementById("shtrlink"));
            window.getSelection().addRange(range);
            document.execCommand("copy")
            $('#shtrlink').tooltip('show');
        }

        $('body').on('click', '#linkgenerate', function () {
            var basicurl = $('#basic-url').val();
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('events.generate') }}",
                type: 'POST',
                dataType: 'json',
                data: {_token: "{{ csrf_token() }}", item_link_slug: basicurl, id: id},
                success: function (data) {
                    if (data.success == undefined) {
                        swal("Cancelled", data, "error");
                    } else {
                        $('#links-show').show();
                        $('#link-status').html(' ')
                        $('#link-status').html('<a href="' + data.url + '" target="_blank">' + data.url + '</a>')
                        swal("Good job!", data.success, "success")
                    }
                }
            })
        });
    </script>
@endsection