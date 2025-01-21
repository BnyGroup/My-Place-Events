<div class="modal fade" id="{{ $val->id }}-modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{--User View--}}Vue Utilisateur</h4>
              </div>
              <div class="modal-body">
                <table class="table table-bordered table-striped">
                  <tbody>
                     <tr>
                      <td colspan="2" class="text-center">
                        <img src="{{ setThumbnail($val->profile_pic) }}" class="text"  style="border-radius:50%; border:3px solid #afafaf; padding:3px; " />
                      </td>
                    </tr>
                    <tr>
                      <th width="30%">{{--Full Name--}}Nom Complet</th>
                      <td>{{ $val->firstname }} {{ $val->lastname }}</td>
                    </tr>
                    <tr>
                      <th width="30%">Nom d'utilisateur</th>
                      <td>{{ $val->username }}</td>
                    </tr>
                    <tr>
                      <th width="30%">Email</th>
                      <td>{{ $val->email }}</td>
                    </tr>
                    <tr>
                      <th width="30%">{{--Brith Date--}}Date de naissance</th>
                      @if(!is_null($val->brith_date))
                        <td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d',$val->brith_date)->format('d-m-Y'); ?></td>
                      @endif
                    </tr>
                    <tr>
                      <th width="30%">{{--Gender--}}Genre</th>
                      <td>{{ gender($val->gender) }}</td>
                    </tr>
                    <tr>
                      <th width="30%">Status</th>
                      <td>{{ status($val->status) }}</td>
                    </tr>
                    <tr>
                      <th width="30%">{{--Current login--}}Login Actuel</th>
                      <td>{{ $val->current_login }}</td>
                    </tr>
                    <tr>
                      <th width="30%">{{--Last login--}}Dernier Login</th>
                      <td>{{ $val->last_login }}</td>
                    </tr>
                    <tr>
                      <th width="30%">{{--Create Date--}}Créer un login</th>
                      <td>{{ date_format($val->created_at,'d-m-Y') }}</td>
                    </tr>
                    <tr>
                      <th width="30%">{{--Update Date--}}Mettre à jour la date</th>
                      <td>{{ date_format($val->updated_at,'d-m-Y') }}</td>
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