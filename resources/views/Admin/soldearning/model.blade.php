@isset($event->children)
<div class="modal fade" id="{{ $event->event_unique_id }}" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{--Sold Tickets--}}Billets vendus</h4>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped text-center">
              <thead>
                  <tr>
                      <th>No.</th>
                      <th>{{--Tickets title--}}Titre Tickets</th>
                      <th>{{--Total tickets--}}Tickets Total</th>
                      <th>{{--Sold tickets--}}Tickets Vendu</th>
                      <th>{{--Remaining tickets--}}Billets restants</th>
                  </tr>
              </thead>
              <tbody>
                @if(! $event->children->isEmpty())
                @php
                  $datas = [];
                @endphp
                  @foreach($event->children as $keys =>$val)
                    @php
                      $datas['total'][$keys] = $val->ticket_qty;
                      $datas['sold'][$keys] = $val->ticket_qty - $val->ticket_remaning_qty;
                      $datas['remain'][$keys] = $val->ticket_remaning_qty;
                    @endphp

                  <tr>
                      <td>{{ ++$keys }}</td>
                      <td>{{ $val->ticket_title }}</td>
                      <td>{{ $val->ticket_qty }}</td>
                      <td>{{ $val->ticket_qty - $val->ticket_remaning_qty }}</td>
                      <td>{{ $val->ticket_remaning_qty }}</td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5"> {{--Tickets not found.--}}Billets non trouvé</td>
                  </tr>
                @endif
              </tbody>
                <tfoot>
                  @if(isset($datas) && !empty($datas))
                  <tr>
                    <th colspan="2">Total</th>
                    <th>{{ array_sum(isset($datas['total'])?$datas['total']:0) }} </th>
                    <th>{{ array_sum(isset($datas['sold'])?$datas['sold']:0) }} </th>
                    <th>{{ array_sum($datas['remain']) }}</th>
                  </tr>
                  @endif
                </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{--Close--}}Fermer</button>
        </div>
      </div>
    </div>
  </div>
@else
<div class="modal fade" id="{{ $orders->order_id }}" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-left">Tickets wise details</h4>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped text-center">
              <thead>
                  <tr>
                      <th>No.</th>
                      <th>{{--Tickets title--}}Titre Tickets</th>
                      <th>{{--Tickets QTY--}}QTE Tickets</th>
                      <th>{{--Ticket price--}}Prix Tickets</th>
                      <th>{{--Ticket fees--}}Commission Ticket</th>
                      <th>{{--Paid Amount--}}Montant Payé</th>
                  </tr>
              </thead>
              <tbody>
                @php
                  $tik_tit  = unserialize($orders->order_t_title);
                  $otys     = unserialize($orders->order_t_qty);
                  $ottp     = unserialize($orders->order_t_price);
                  $otf      = unserialize($orders->order_t_fees);
                  $otc      = unserialize($orders->order_t_commission);
                @endphp
                @isset($tik_tit)
                    @foreach($tik_tit as $keyss => $toktik)
                      @php
                        $ot=$ottp[$keyss] * $otys[$keyss];
                        
                        $tikp[$keyss] = number_format((floatval($ottp[$keyss]) + floatval($otf[$keyss]* $otys[$keyss])),2);
                        $tikc[$keyss] = number_format(floatval($otc[$keyss]) * floatval($otys[$keyss]),2);
                        $tofp[$keyss] = number_format(( floatval($tikp[$keyss]) -floatval($tikc[$keyss])),2);
                      @endphp
                    <tr>
                      <td>{{ $keyss + 1 }}</td>
                      <td>{{ $toktik }}</td>
                      <td>{{ $otys[$keyss] }}</td>
                      <td>{{ use_currency()->symbol }} {{ $tikp[$keyss] }}</td>
                      <td>{{ use_currency()->symbol }} {{ $tikc[$keyss] }}</td>
                      <td>{{ use_currency()->symbol }} {{ $tofp[$keyss] }}</td>
                    </tr>
                    @endforeach
                @else
                  <tr>
                    <td colspan="6"> {{--Tickets not found--}}Ticket introuvable.</td>
                  </tr>
                @endisset
              </tbody>
                <tfoot>
                  <tr>
                    <th colspan="2">Total</th>
                    <th>{{ array_sum($otys) }}</th>
                    <th>{{ use_currency()->symbol }} {{ number_format(array_sum($tikp),2) }}</th>
                    <th>{{ use_currency()->symbol }} {{ number_format(array_sum($tikc),2) }}</th>
                    <th>{{ use_currency()->symbol }} {{ number_format(array_sum($tofp),2) }}</th>
                  </tr>
                </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{--Close--}}Fermer</button>
        </div>
      </div>
    </div>
  </div>
@endisset



