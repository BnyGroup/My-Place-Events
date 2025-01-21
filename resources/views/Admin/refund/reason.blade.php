<div id="myModal{{ $value->id }}" class="modal fade" role="dialog">
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
							<label>{{--Reason--}}Raison : </label>
							{!! $value->reject_note !!}
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat close-canel" data-dismiss="modal">{{--Close--}}Fermer</button>
			</div>
		</div>
	</div>
</div>