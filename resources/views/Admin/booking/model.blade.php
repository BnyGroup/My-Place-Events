<div class="modal fade" id="{{ $val->order_id }}-modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{--Booking Details --}}Détails d'achat</h4>
              </div>
              <div class="modal-body">
                <table class="table table-bordered table-striped">
                  <tbody>
                    <tr class="text-center">
                      <td colspan="2"><h3>{{ $val->enm }}</h3></td>
                    </tr>
                    <tr class="text-center">
                      <td colspan="2">{{--Order--}}Commande #{{ $val->order_id }} on {{ Carbon\Carbon::parse($val->upat)->format('F d, Y') }}
                          <br>
                          @php
                            $startdate  = Carbon\Carbon::parse($val->event_start_datetime)->format('l, F j, Y');
                            $enddate  = Carbon\Carbon::parse($val->event_end_datetime)->format('l, F j, Y');
                            $starttime  = Carbon\Carbon::parse($val->event_start_datetime)->format('h:i A');
                            $endtime  = Carbon\Carbon::parse($val->event_end_datetime)->format('h:i A');
                          @endphp
                          @if($startdate == $enddate)
                            {{ $startdate }}
                            {{ $starttime }} To {{ $endtime }}
                          @else
                            {{ $startdate }}, {{ $starttime }} To
                             {{ $enddate }}, {{ $endtime }}
                          @endif
                      </td>
                    </tr>
                  </tbody>  
                </table>
            @php 
              $tickets  = unserialize($val->order_t_id);
              $ttitle   = unserialize($val->order_t_title);
              $tqty   = unserialize($val->order_t_qty);
              $tprice   = unserialize($val->order_t_price);
              $tfees    = unserialize($val->order_t_fees);
            @endphp
            <span class="tickets-pays text-left"><b>Tickets</b></span>
            <span class="tickets-pays text-right pull-right"><p><b>{{--Tickets Buyer --}}Acheteur de billets- </b> {{ $val->fnm }} {{ $val->lnm }}</p></span>
              <table class="table table-bordered table-striped">
                <thead class="text-center">
                  <th class="text-center">{{--Ticket Name--}}Nom du Ticket</th>
                  <th class="text-center">{{--Ticket Price--}}Prix du Tickte</th>
                  <th class="text-center">{{--Ticket Qty--}}Qté de Tickets</th>
                  <th class="text-center">{{--Ticket Sub Total--}}Sous Total de Ticket</th>
                </thead>
                <tbody>
                @foreach($tickets as $key => $ticket)
                    <tr class="text-center">
                      <td>{{$ttitle[$key]}}</td>
                      <td>
                        {{ (floatval($tprice[$key]) == 0 )?'Free': floatval($tprice[$key]) /*+ floatval($tfees[$key])*/ }}
                    </td>
                      <td>{{ $tqty[$key] }}</td>
                      <td>{{ (floatval($tprice[$key]) == 0 )?'Free': (floatval($tprice[$key]) /*+ floatval($tfees[$key])*/ ) * intval($tqty[$key]) }}</td>
                    </tr>
                @endforeach           
                <tr>
                  <th colspan="3" class="text-right">{{--Order Total--}}Commande Totale</th>
                  <th class="text-center">{{ $val->order_amount }}</th>
                </tr>
                  </tbody>
              </table>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{--Close--}}Fermer</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>