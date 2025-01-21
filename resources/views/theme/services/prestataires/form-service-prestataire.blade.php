<div class="modal fade" id="demandeService" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" id="style-service-prestataire">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Demande de service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="font-size: medium">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-shooting" role="tab" aria-controls="pills-shooting" aria-selected="true">Shooting Photo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-capsules" role="tab" aria-controls="pills-shooting" aria-selected="false">Capsules Vidéos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-animation-rs" role="tab" aria-controls="pills-animation-rs" aria-selected="false">Animation Réseau Sociaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-clip" role="tab" aria-controls="pills-clip" aria-selected="false">Clip Musical</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-placement" role="tab" aria-controls="pills-placement" aria-selected="false">Placements Evenements</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-shooting" role="tabpanel" aria-labelledby="pills-home-tab">

                    </div>
                    <div class="tab-pane fade" id="pills-capsules" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                    <div class="tab-pane fade" id="pills-animation-rs" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                    <div class="tab-pane fade" id="pills-clip" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                    <div class="tab-pane fade" id="pills-placement" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                </div>
                --}}
                <div class="row">
                    <div class="col-md-3 col-sm-12 side-nav">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="width: 100%;font-size: medium; text-align: left;">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-shooting" role="tab" aria-controls="v-pills-home" aria-selected="true" style="margin-bottom:15px;"><i class="fa fa-camera" aria-hidden="true"></i> &nbsp; Shooting Photo</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-capsules" role="tab" aria-controls="v-pills-profile" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-video-camera" aria-hidden="true"></i> &nbsp; Capsules Vidéos</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-animation-rs" role="tab" aria-controls="v-pills-messages" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-share-alt-square" aria-hidden="true"></i> &nbsp; Réseaux Sociaux</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-clip" role="tab" aria-controls="v-pills-settings" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-music" aria-hidden="true"></i> &nbsp; Clip Musical</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-placement" role="tab" aria-controls="v-pills-settings" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Placement Événements</a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="tab-content" id="v-pills-tabContent" style="font-size: medium">
                            <div class="tab-pane fade show active" id="v-pills-shooting" role="tabpanel" aria-labelledby="v-pills-home-tab" >
                                <div class="col-12 cover-image" {{--style=" background-image:url('{{ url('public/img/prest-service/shooting-photo.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"--}}></div>
                                <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="type_service" value="Séance de Shooting">
                                    {{--<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                        <div class="col-sm-10">
                                            <select name="prestataire" class="form-control">
                                                @foreach($datas as $key => $val)
                                                    <option class="form-control" value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="type_service" value="Séance de Shooting">
                                        </div>
                                    </div>--}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="nom_prenoms">Nom et prénoms</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nom_prenoms" id="nom_prenoms" placeholder="Insérez votre nom et prénoms">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="adresse_mail">Adresse mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="adresse_mail" id="adresse_mail" placeholder="(ex : abcd@email.com)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telephone" class="col-sm-2 col-form-label">Téléphone<span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="telephone" required="" name="telephone" placeholder="(ex : +22501234567)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="duree" class="col-sm-2 col-form-label">Durée <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="duree" required="" name="duree" placeholder="1 Heure">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lieu" class="col-sm-2 col-form-label">Lieu <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="lieu" required="" name="lieu" placeholder="Indiquez le lieu du shooting">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 col-form-label">Date <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="date" required="" name="date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="categorie" class="col-sm-2 col-form-label"> Catégorie <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="categorie" required="" name="categorie" placeholder="(ex : mariage, anniversaire, séance photo ...)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="message" class="col-sm-2 col-form-label"> Message </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="message" placeholder="Laissez un message"></textarea>
                                        </div>
                                    </div>
                                    <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander une séance de Shooting">
                                </form>
                            </div>


                            <div class="tab-pane fade" id="v-pills-capsules" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="col-12 cover-image" {{--style=" background-image:url('https://images.pexels.com/photos/2228831/pexels-photo-2228831.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');background-size: cover; height: 200px; margin-bottom: 21px;"--}}></div>
                                <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="type_service" value="Capsules Vidéos">
                                    {{--<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                        <div class="col-sm-10">
                                            <select name="prestataire" class="form-control">
                                                @foreach($datas as $key => $val)
                                                    <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('prestataire')) <span class="error">{{ $errors->first('prestataire') }}</span> @endif
                                        </div>
                                    </div>--}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="nom_prenoms">Nom et prénoms</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nom_prenoms" id="nom_prenoms" placeholder="Insérez votre nom et prénoms">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="adresse_mail">Adresse mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="adresse_mail" id="adresse_mail" placeholder="(ex : abcd@email.com)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telephone" class="col-sm-2 col-form-label">Téléphone<span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="telephone" required="" name="telephone" placeholder="(ex : +22501234567)">
                                        </div>
                                        @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="duree" class="col-sm-2 col-form-label">Durée <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="duree" required="" name="duree" placeholder="(ex : 5 minutes)">
                                        </div>
                                        @if($errors->has('duree')) <span class="error">{{ $errors->first('duree') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="message" class="col-sm-2 col-form-label">Message </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="message" placeholder="Laissez un message"></textarea>
                                        </div>
                                        @if($errors->has('message')) <span class="error">{{ $errors->first('message') }}</span> @endif
                                    </div>
                                    <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander une Capsule Vidéo">
                                </form>
                            </div>


                            <div class="tab-pane fade" id="v-pills-animation-rs" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="col-12 cover-image" {{--style=" background-image:url('{{ url('public/img/prest-service/reseau-sociaux.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"--}}></div>
                                <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="type_service" value="Animation Des Réseaux Sociaux">
                                    {{--<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                        <div class="col-sm-10">
                                            <select name="prestataire" class="form-control">
                                                @foreach($datas as $key => $val)
                                                    <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                @endforeach
                                            </select>
                                           </div>
                                    </div>--}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="nom_prenoms">Nom et prénoms</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nom_prenoms" id="nom_prenoms" placeholder="Insérez votre nom et prénoms">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="adresse_mail">Adresse mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="adresse_mail" id="adresse_mail" placeholder="(ex : abcd@email.com)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telephone" class="col-sm-2 col-form-label">Téléphone <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="telephone" required="" name="telephone" placeholder="(ex : +22501234567)">
                                        </div>
                                        @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="message" class="col-sm-2 col-form-label">Message </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="message" placeholder="Laissez un message"></textarea>
                                        </div>
                                        @if($errors->has('message')) <span class="error">{{ $errors->first('message') }}</span> @endif
                                    </div>
                                    <div style=" text-align: left;">
                                        <div class="form-group row">
                                            <label for="message" class="col-sm-2 col-form-label"> Catégorie du service <span style="color : red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="service[]" value="Création Graphique" id="creation-graphique"> <label for="creation-graphique"> Création Graphique </label>&nbsp; <br>
                                                <input type="checkbox" name="service[]" value="Rédaction" id="redaction"> <label for="redaction"> Rédaction </label>
                                            </div>
                                            @if($errors->has('service')) <span class="error">{{ $errors->first('service') }}</span> @endif
                                        </div>
                                        <div class="form-group row">
                                            <label for="message" class="col-sm-2 col-form-label"> Réseaux sociaux concernés <span style="color : red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="reseau[]" value="Facebook" id="facebook"> <label for="facebook"> <i class="fab fa-facebook"></i> Facebook</label><br>
                                                <input type="checkbox" name="reseau[]" value="Instagram" id="instagram"> <label for="instagram"> <i class="fab fa-instagram"></i> Instagram </label><br>
                                                <input type="checkbox" name="reseau[]" value="Twitter" id="twitter"> <label for="twitter"> <i class="fab fa-twitter"></i>Twitter</label> <br>
                                                <input type="checkbox" name="reseau[]" value="Whatsapp" id="whatsapp"> <label for="whatsapp"><i class="fab fa-whatsapp"></i> Whatsapp </label><br>
                                                <input type="checkbox" name="reseau[]" value="YouTube" id="youtube"> <label for="youtube"> <i class="fab fa-youtube"></i> YouTube  </label>
                                            </div>
                                            @if($errors->has('reseau')) <span class="error">{{ $errors->first('reseau') }}</span> @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="frequence" class="col-sm-2 col-form-label">Fréquence de publication<span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="frequence" required="" name="frequence" placeholder="(ex : 5/Semaine )">
                                        </div>
                                        @if($errors->has('frequence')) <span class="error">{{ $errors->first('frequence') }}</span> @endif
                                    </div>
                                    <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander l'animation de mes pages">
                                </form>
                            </div>


                            <div class="tab-pane fade" id="v-pills-clip" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="col-12 cover-image" {{--style=" background-image:url('{{ url('public/img/prest-service/clip-musical.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"--}}></div>
                                <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="type_service" value="Clip Musical">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="nom_prenoms">Nom et prénoms</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nom_prenoms" id="nom_prenoms" placeholder="Insérez votre nom et prénoms">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="adresse_mail">Adresse mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="adresse_mail" id="adresse_mail" placeholder="(ex : abcd@email.com)">
                                        </div>
                                    </div>
                                    {{--<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                        <div class="col-sm-10">
                                            <select name="prestataire" class="form-control">
                                                @foreach($datas as $key => $val)
                                                    <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                @endforeach
                                            </select>
                                            </div>
                                    </div>--}}
                                    <div class="form-group row">
                                        <label for="telephone" class="col-sm-2 col-form-label">Téléphone<span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="telephone" required="" name="telephone" placeholder="(ex : +22501234567)">
                                        </div>
                                        @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                    </div>
                                    <div style="text-align: left;">
                                        <div class="form-group row">
                                            <label for="recherche_lieu" class="col-sm-2 col-form-label"> Recherche du lieu <span style="color : red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="radio" name="recherche_lieu" value="Oui" checked id="recherche_lieu_oui"> <label for="recherche_lieu_oui"> OUI &nbsp; </label><input type="radio" name="recherche_lieu" value="Non" id="recherche_lieu_non"> <label for="recherche_lieu_non"> NON </label>
                                            </div>
                                            @if($errors->has('recherche_lieu')) <span class="error">{{ $errors->first('recherche_lieu') }}</span> @endif
                                        </div>
                                        <div class="form-group row">
                                            <label for="booking_figurants" class="col-sm-2 col-form-label"> Booking figurants <span style="color : red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="radio" name="booking_figurants" value="Oui" checked id="booking_figurants_oui"> <label for="booking_figurants_oui"> OUI </label>&nbsp; <input type="radio" name="booking_figurants" value="Non" id="booking_figurants_non"> <label for="booking_figurants_non"> NON</label>
                                            </div>
                                            @if($errors->has('booking_figurants')) <span class="error">{{ $errors->first('booking_figurants') }}</span> @endif
                                        </div>
                                        <div class="form-group row">
                                            <label for="proposition_artistique" class="col-sm-2 col-form-label"> Proposition artistique <span style="color : red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="radio" name="proposition_artistique" value="Oui" checked id="proposition_artistique_oui"> <label for="proposition_artistique_oui"> OUI </label>&nbsp; <input type="radio" name="proposition_artistique" value="Non" id="proposition_artistique_non"> <label for="proposition_artistique_non"> NON </label>
                                            </div>
                                            @if($errors->has('proposition_artistique')) <span class="error">{{ $errors->first('proposition_artistique') }}</span> @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="duree" class="col-sm-2 col-form-label">Durée<span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="duree" required="" name="duree" placeholder="(ex : 4 minutes)">
                                        </div>
                                        @if($errors->has('duree')) <span class="error">{{ $errors->first('duree') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="message" class="col-sm-2 col-form-label">Message</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="message" required="" name="message" placeholder="Laissez un message">
                                        </div>
                                        @if($errors->has('message')) <span class="error">{{ $errors->first('message') }}</span> @endif
                                    </div>
                                    <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander un clip musical">
                                </form>
                            </div>


                            <div class="tab-pane fade" id="v-pills-placement" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="col-12 cover-image" {{--style=" background-image:url('{{ url('public/img/prest-service/placement-event.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"--}}></div>
                                <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="type_service" value="Placement d'Événements">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="nom_prenoms">Nom et prénoms</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nom_prenoms" id="nom_prenoms" placeholder="Insérez votre nom et prénoms">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-sm-offset-4 col-form-label" for="adresse_mail">Adresse mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="adresse_mail" id="adresse_mail" placeholder="(ex : abcd@email.com)">
                                        </div>
                                    </div>
                                    {{--<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                        <div class="col-sm-10">
                                            <select name="prestataire" class="form-control">
                                                @foreach($datas as $key => $val)
                                                    <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('prestataire')) <span class="error">{{ $errors->first('prestataire') }}</span> @endif

                                        </div>
                                    </div>--}}
                                    <div class="form-group row">
                                        <label for="telephone" class="col-sm-2 col-form-label">Téléphone <span style="color : red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="telephone" required="" name="telephone" placeholder="(ex : +22501234567)">
                                        </div>
                                        @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="categorie" class="col-sm-2 col-form-label" >Catégorie</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="categorie" required="" name="categorie" placeholder="(ex : mariage, anniversaire, séance photo ...)">
                                        </div>
                                        @if($errors->has('categorie')) <span class="error">{{ $errors->first('categorie') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="lieu" class="col-sm-2 col-form-label">Lieu de l'événement</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="lieu" required="" name="lieu" placeholder="Indiquez le lieu souhaité">
                                        </div>
                                        @if($errors->has('lieu')) <span class="error">{{ $errors->first('lieu') }}</span> @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="message" class="col-sm-2 col-form-label"> Message </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="message" placeholder="Laissez un message"></textarea>
                                        </div>
                                        @if($errors->has('message')) <span class="error">{{ $errors->first('message') }}</span> @endif
                                    </div>
                                    <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander un placement d'événement">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
</div>