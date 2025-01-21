<div id="myModal{{ $value->id }}" class="modal fade" role="dialog">
{!! Form::open(['route' => 'refund.rejcte.cancel','method' => 'post']) !!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-canel" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">{{ $value->event_name }} - #{{ $value->order_id }}</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
					<div class="print-error-msg" style="display: block; color: red; font-weight: bolder;"></div>
						<div class="form-group" style="width:100%">
							{!! Form::label('canel','Reject reason :') !!}
							{!! Form::hidden('order_id',$value->order_id) !!}
							{!! Form::hidden('event_id',$value->event_id) !!}
							{!! Form::hidden('user_id',$value->user_id) !!}
							{!! Form::textarea('reject_reason',null,['class' => 'form-control','rows' => '5','style'=>'width:100%','id' => 'canel','required']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btn-flat cancel-rason">{{--Submit--}}Envoyer</button>
				<button type="button" class="btn btn-default btn-flat close-canel" data-dismiss="modal">{{--Close--}}Fermer</button>
			</div>
		</div>
	</div>
{!! Form::close() !!}
</div>