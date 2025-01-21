@inject(paymentState,'App\SouscPrestataire)
@extends($theme)
@section('meta_title',/*setMetaData()->org_title*/'Gestion Prestataire' )
@section('meta_description',setMetaData()->org_desc)
@section('meta_keywords',setMetaData()->org_keyword)
@section('content')
    <div class="col-md-12 page-section" style="border-top: 1px solid #dfdfdf;">
        <div class="row">
            @include('layouts.sidebar')
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-sm-4">
                        <h2 class="events-title font-weight-bold" style="padding-left:20px;"> Prestataire </h2>
                    </div>
                    <div class="col-sm-8 text-right">
                        <div class="events-title font-weight-bold">
                            @if(count($datas) < 10)
                                <a href="{{ route('pre.create') }}" class="btn add-bun"><i class="fa fa-plus"></i> Créer un Prestataire</a><br />
                            @else
                                <span class="error">@lang('words.organizer_page.org_btn_full')</span>
                            @endif
                                {{--<<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#demandeService">
                                    <i class="fas fa-file-contract"></i>
                                    Demander un service
                                </button>
                                <!-- Modal -->
                                div class="modal fade" id="demandeService" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document" id="style-service-prestataire">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Demande de service</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                --}}{{--
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
                                                --}}{{--
                                            <div class="row">
                                                <div class="col-3 side-nav">
                                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="width: 100%;font-size: medium; text-align: left;">
                                                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-shooting" role="tab" aria-controls="v-pills-home" aria-selected="true" style="margin-bottom:15px;"><i class="fa fa-camera" aria-hidden="true"></i> &nbsp; Shooting Photo</a>
                                                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-capsules" role="tab" aria-controls="v-pills-profile" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-video-camera" aria-hidden="true"></i> &nbsp; Capsules Vidéos</a>
                                                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-animation-rs" role="tab" aria-controls="v-pills-messages" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-share-alt-square" aria-hidden="true"></i> &nbsp; Réseaux Sociaux</a>
                                                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-clip" role="tab" aria-controls="v-pills-settings" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-music" aria-hidden="true"></i> &nbsp; Clip Musical</a>
                                                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-placement" role="tab" aria-controls="v-pills-settings" aria-selected="false" style="margin-bottom:15px;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Placements Evenements</a>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="tab-content" id="v-pills-tabContent" style="font-size: medium">
                                                    <div class="tab-pane fade show active" id="v-pills-shooting" role="tabpanel" aria-labelledby="v-pills-home-tab" >
                                                        <div class="col-12 cover-image" style=" background-image:url('{{ url('public/img/prest-service/shooting-photo.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"></div>
                                                        <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                                            {!! csrf_field() !!}
                                                            <div class="form-group row">
                                                                <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                                                <div class="col-sm-10">
                                                                    <select name="prestataire" class="form-control">
                                                                        @foreach($datas as $key => $val)
                                                                            <option class="form-control" value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="type_service" value="Séance de Shooting">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="telephone" class="col-sm-2 col-form-label">Téléphone<span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="telephone" required="" name="telephone">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="duree" class="col-sm-2 col-form-label">Durée <span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="duree" required="" name="duree">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="lieu" class="col-sm-2 col-form-label">Lieu <span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="lieu" required="" name="lieu">
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
                                                                    <input type="text" class="form-control" id="categorie" required="" name="categorie" placeholder="(ex : mariage, anniversaire, séance photo ...">
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
                                                        <div class="col-12 cover-image" style=" background-image:url('https://images.pexels.com/photos/2228831/pexels-photo-2228831.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');background-size: cover; height: 200px; margin-bottom: 21px;"></div>
                                                        <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                                            {!! csrf_field() !!}
                                                            <div class="form-group row">
                                                                <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                                                <div class="col-sm-10">
                                                                    <select name="prestataire" class="form-control">
                                                                        @foreach($datas as $key => $val)
                                                                            <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('prestataire')) <span class="error">{{ $errors->first('prestataire') }}</span> @endif
                                                                    <input type="hidden" name="type_service" value="Capsules Vidéos">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="telephone" class="col-sm-2 col-form-label">Téléphone<span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="telephone" required="" name="telephone">
                                                                </div>
                                                                @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="duree" class="col-sm-2 col-form-label">Durée <span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="duree" required="" name="duree">
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
                                                        <div class="col-12 cover-image" style=" background-image:url('{{ url('public/img/prest-service/reseau-sociaux.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"></div>
                                                        <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                                            {!! csrf_field() !!}
                                                            <div class="form-group row">
                                                                <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                                                <div class="col-sm-10">
                                                                    <select name="prestataire" class="form-control">
                                                                        @foreach($datas as $key => $val)
                                                                            <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="type_service" value="Animation Des Réseaux Sociaux">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="telephone" class="col-sm-2 col-form-label">Téléphone <span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="telephone" required="" name="telephone">
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
                                                                        <input type="checkbox" name="service[]" value="Création Graphique" id="creation-graphique"> <label for="creation-graphique">: Création Graphique </label>&nbsp; <input type="checkbox" name="service[]" value="Rédaction"> <label for="creation-graphique">: Rédaction </label>
                                                                    </div>
                                                                    @if($errors->has('service')) <span class="error">{{ $errors->first('service') }}</span> @endif
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="message" class="col-sm-2 col-form-label"> Réseaux sociaux concernés <span style="color : red">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="checkbox" name="reseau[]" value="Facebook" id="facebook"> : <label for="facebook"> <i class="fab fa-facebook"></i> Facebook &nbsp;</label><input type="checkbox" name="reseau[]" value="Instagram" id="instagram"> :<label for="instagram"> <i class="fab fa-instagram"></i> Instagram </label>&nbsp;
                                                                        <input type="checkbox" name="reseau[]" value="Twitter" id="twitter"> : <label for="twitter"> <i class="fab fa-twitter"></i>Twitter &nbsp;</label> <br> <input type="checkbox" name="reseau[]" value="Whatsapp" id="whatsapp"> : <label for="whatsapp"><i class="fab fa-whatsapp"></i> Whatsapp </label>&nbsp;
                                                                        <input type="checkbox" name="reseau[]" value="YouTube" id="youtube"> : <label for="youtube"> <i class="fab fa-youtube"></i> YouTube  </label>
                                                                    </div>
                                                                    @if($errors->has('reseau')) <span class="error">{{ $errors->first('reseau') }}</span> @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="frequence" class="col-sm-2 col-form-label">Fréquence de publication<span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="frequence" required="" name="frequence">
                                                                </div>
                                                                @if($errors->has('frequence')) <span class="error">{{ $errors->first('frequence') }}</span> @endif
                                                            </div>
                                                            <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander l'animation de mes pages">
                                                        </form>
                                                    </div>


                                                    <div class="tab-pane fade" id="v-pills-clip" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                        <div class="col-12 cover-image" style=" background-image:url('{{ url('public/img/prest-service/clip-musical.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"></div>
                                                        <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                                            {!! csrf_field() !!}
                                                            <div class="form-group row">
                                                                <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                                                <div class="col-sm-10">
                                                                    <select name="prestataire" class="form-control">
                                                                        @foreach($datas as $key => $val)
                                                                            <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="type_service" value="Clip Musical">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="telephone" class="col-sm-2 col-form-label">Téléphone<span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="telephone" required="" name="telephone">
                                                                </div>
                                                                @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                                            </div>
                                                            <div style="text-align: left;">
                                                                <div class="form-group row">
                                                                    <label for="recherche_lieu" class="col-sm-2 col-form-label"> Recherche du lieu <span style="color : red">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="radio" name="recherche_lieu" value="Oui" checked id="recherche_lieu"> <label for="recherche_lieu"> : OUI &nbsp; </label><input type="radio" name="recherche_lieu" value="Non"> <label for="recherche_lieu"> : NON </label>
                                                                    </div>
                                                                    @if($errors->has('recherche_lieu')) <span class="error">{{ $errors->first('recherche_lieu') }}</span> @endif
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="booking_figurants" class="col-sm-2 col-form-label"> Booking figurants <span style="color : red">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="radio" name="booking_figurants" value="Oui" checked id="booking_figurants_oui"> <label for="booking_figurants_oui">: OUI </label>&nbsp; <input type="radio" name="booking_figurants" value="Non" id="booking_figurants_non"> <label for="booking_figurants_non">: NON</label>
                                                                    </div>
                                                                    @if($errors->has('booking_figurants')) <span class="error">{{ $errors->first('booking_figurants') }}</span> @endif
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="proposition_artistique" class="col-sm-2 col-form-label"> Propostiton artistique <span style="color : red">*</span></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="radio" name="proposition_artistique" value="Oui" checked id="proposition_artistique_oui"> <label for="proposition_artistique_oui">: OUI </label>&nbsp; <input type="radio" name="proposition_artistique" value="Non" id="proposition_artistique_non"> <label for="proposition_artistique_non"> : NON </label>
                                                                    </div>
                                                                    @if($errors->has('proposition_artistique')) <span class="error">{{ $errors->first('proposition_artistique') }}</span> @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="duree" class="col-sm-2 col-form-label">Durée<span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="duree" required="" name="duree">
                                                                </div>
                                                                @if($errors->has('duree')) <span class="error">{{ $errors->first('duree') }}</span> @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="message" class="col-sm-2 col-form-label">Message à l'admin</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="message" required="" name="message">
                                                                </div>
                                                                @if($errors->has('message')) <span class="error">{{ $errors->first('message') }}</span> @endif
                                                            </div>
                                                            <input type="submit" id="organizer-form" class="btn btn-flat btn-primary btn-block" value="Demander un clip musical">
                                                        </form>
                                                    </div>


                                                    <div class="tab-pane fade" id="v-pills-placement" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                        <div class="col-12 cover-image" style=" background-image:url('{{ url('public/img/prest-service/placement-event.png') }}');background-size: cover; height: 200px; margin-bottom: 21px;"></div>
                                                        <form id="org-con-form" method="post" action="{{ route('pre.demande') }}">
                                                            {!! csrf_field() !!}
                                                            <div class="form-group row">
                                                                <label for="staticEmail" class="col-sm-2 col-sm-offset-4 col-form-label">Prestataire</label>
                                                                <div class="col-sm-10">
                                                                    <select name="prestataire" class="form-control">
                                                                        @foreach($datas as $key => $val)
                                                                            <option value="{{ $val->url_slug }}"> {{ $val->firstname.' '.$val->lastname }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('prestataire')) <span class="error">{{ $errors->first('prestataire') }}</span> @endif
                                                                    <input type="hidden" name="type_service" value="Placement d'Evénements">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="telephone" class="col-sm-2 col-form-label">Téléphone <span style="color : red">*</span></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="telephone" required="" name="telephone">
                                                                </div>
                                                                @if($errors->has('telephone')) <span class="error">{{ $errors->first('telephone') }}</span> @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="categorie" class="col-sm-2 col-form-label" >Catégorie</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="categorie" required="" name="categorie" placeholder="(ex : mariage, anniversaire, séance photo ...">
                                                                </div>
                                                                @if($errors->has('categorie')) <span class="error">{{ $errors->first('categorie') }}</span> @endif
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="lieu" class="col-sm-2 col-form-label">Lieu de l'événement</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="lieu" required="" name="lieu">
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
                                                --}}{{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}{{--
                                                --}}{{--<button type="button" class="btn btn-primary">Save changes</button>--}}{{--
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>--}}
                        </div>
                    </div>
                <br>
                <!--box start-->
                @if($success = Session::get('success'))
                    <div class="alert alert-success" style="margin-left:25px;">{{$success}}</div>
                @endif
                @if($erreur = Session::get('erreur'))
                    <div class="alert alert-danger" style="margin-left:25px;">{{$erreur}}</div>
                @endif
                <div class="col-lg-12">
                    <div class="row">
                        @php $i=0 @endphp

                        @foreach($datas as $key => $val)
                            @php $i++ @endphp
                            <div class="col-lg-4 col-sm-6 col-xs-12 col-md-6">
                                <div class="row rev-box org-box">
                                    <div class="col-lg-3 col-sm-12 col-md-4 box-imager-wrapper">
                                        <img src="{{ setThumbnail($val->profile_pic) }}" class="box-image-rev">
                                    </div>
                                    <div class="col-lg-9 col-sm-12 col-md-8 col-xs-12">
                                        <p class="text-uppercase box-rev-box-title">{{ /*date_format($val->created_at,'D, M d h:i A')*/ucwords(Jenssegers\Date\Date::parse($val->created_at)->format('l j F Y H:i')) }}</p>
                                        <h5 class="text-capitalize box-conetent-title">{{ $val->firstname.' '.$val->lastname }}</h5>

                                        <br>

                                        <a href="https://web.facebook.com/{{ $val->facebook }}" class="btn btn-sm btn-rds fb" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-facebook-square"></i></a>

                                        <a href="https://twitter.com/{{ $val->twitter }}" class="btn btn-sm btn-rds twt" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-twitter"></i></a>

                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12 valuse-box-org">
                                                <a href="{{route('pre.edit',$val->url_slug) }}" class="btn btn-site-dft btn-sm"><i class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                <a href="{{ route('pre.detail',$val->url_slug) }}" class="btn btn-site-dft btn-sm"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
                                                <a href="{{ route('pre.delete',$val->url_slug) }}" class="btn btn-site-dft btn-sm" onclick=" return confirm('are you sure Delete this item ?')"><i class="fa fa-trash"></i> @lang('words.mng_eve.mng_eve_del')</a>
                                                <!--Creates the popup body-->
                                                @php $datas = $paymentState->getPaymentState($val->id) @endphp
                                                @if(empty($datas))
                                                    @include('theme.services.prestataires.prestataire-paymentstate')
                                                @elseif(!empty($datas))
                                                        @if($datas->status == 0)
                                                            @include('theme.services.prestataires.prestataire-paymentstate')
                                                        @elseif($datas->status == 1)
                                                            <span class="btn-flat btn btn-succes"> Payé </span>
                                                        @endif
                                                @endif
                                                <!-- large modal -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--
                            <script type="text/javascript">
                                $("#formule{{ $i }}").on('change', function(){
                                    var pu = $("#pu{{ $i }}").val();
                                    var formule = $(this).val();
                                    var montant = pu*formule;
                                    $("#montant{{ $i }}").val(montant);
                                });
                            </script>
                            <div class="col-sm-12" style="display: inline-block;">
                            <div class="row">
                                <div id="paypal-button-container{{ $i }}"></div>
                                {{--<a href="{{ route('pp.create',['order_id' =>$bookingdata->order_id]) }}" class="btn btn-success" > Payer avec Paypal </a>--}}
                         <div id="prest_id{{ $i }}" style="display: none;">{{ $val->id }}</div>
                        <div id="montant_euro{{ $i }}" style="display: none;">{{ $val->id }}</div>
                        @endforeach
                        <div id="iteration" style="display: none">{{ $i }}</div>
                    </div>
                </div>
                <br/>
                <!--box end-->
            </div>
        </div>
    </div>
@endsection
@section('pageScript')
    <script src="https://www.paypal.com/sdk/js?client-id={{ Config::get('services.paypal.client_id') }}&currency=EUR"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        <?php
            for($j=1; $j<=$i; $j++){
        ?>
         $("#formule{{ $j }}").on('change', function (){
            var pu = $("#pu{{ $j }}").val();
            var formule = $(this).val();
            var montant = pu*formule;
            $("#montant{{ $j }}").val(montant);
         });

        var montant = $('#montant{{ $i }}').val()/650;
        var montant2 = montant.toFixed(2);
        var reference_id = $('#prest_id{{ $i }}').html();
        var description = $('#formule{{ $i }}').val();
 /*       alert(montant);
        alert(reference_id);
        alert(description);*/

        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: montant2,
                            currency: '{{ Config::get('services.paypal.currency') }}',
                            reference_id: reference_id,
                            description: description,
                        }
                    }],
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    alert('Paiement effectué par ' + details.payer.name.given_name + ' Veuillez patienter quelques secondes');
                    // Call your server to save the transaction
                    fetch('{{ url('prestataire/paypal-transaction-complete') }}/'+ data.orderID, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID
                        })
                    })/*.then(response => {
                        if (response.ok) {
                            window.location.href = "{{route('pre.index')}}";
                        } else {
                            window.location.href = "{{ route('pre.index') }}";
                        }
                    });*/
                })
            }
        }).render('#paypal-button-container{{ $i }}');
        <?php
         }
        ?>
    });
        /*$(document).ready(function(){
            var j = $('#iteration').html();
            for(var i = 1;i <=j;i++){
                $("#formule"+i).on('change', function (){
                    var pu = $("#pu"+i).val();
                    var formule = $(this).val();
                    var montant = pu*formule;
                    $("#montant"+i).val(montant);
                });
            }
        });*/
    </script>
{{--
    <script type="text/javascript">
        $(document).ready(function(){
            $( ".prestPayForm" ).each(function() {
                $(this+'.formule').on('change', function(){
                    var pu = $(this+'.pu').val();
                    var formule = $(this).val();
                    var montant = pu*formule;
                    $(this+'.montant').val(montant);
                });

            });
                /*$("#formule").on('change', function(){
                    var pu = $('#pu').val();
                    var formule = $(this).val();
                    var montant = pu*formule;
                    $("#montant").val(montant);
                });*/
            }}paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: ($("#montant").val()/650)*1.06--}}
{{--{{ number_format(($bookingdata->order_amount/650)*1.06, 2) }}--}}{{--
,
                                currency : '{{ Config::get('services.paypal.currency') }}',
                                reference_id : '--}}
{{--{{ $bookingdata->order_id }}--}}{{--
',
                                description : '--}}
{{--{{ $bookingdata->event_name }}--}}{{--
',
                                invoice_id : '--}}
{{--{{ $bookingdata->order_id }}--}}{{--
',
                            }
                        }],
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Paiement effectué par ' + details.payer.name.given_name +' Veuillez patienter quelques secondes');
                        // Call your server to save the transaction
                        fetch('--}}
{{--{{ url('paypal-transaction-complete/') }}/{{ $bookingdata->order_id }}/+'data.orderID\--}}{{--
', {
                            method: 'post',
                            headers: {
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({
                                orderID: data.orderID
                            })
                        }).then(response => {
                            if (response.ok) {
                                /*response.json()
                                    .then(console.log);*/
                                window.location.href = "--}}
{{--{{ route('ticket.oderdone',$bookingdata->order_id) }}--}}{{--
";
                            } else {
                                window.location.href = "--}}
{{--{{ route('order.cancel',$bookingdata->order_id) }}--}}{{--
";
                                //console.error('server response : ' + response.status);
                            }
                        });
                })}
            }).render('#paypal-button-container');
        });
    </script>
--}}

{{--
        <script type="text/javascript">
            $(document).ready(function(){
                $("#formule").on('change', function(){
                    var pu = $('#pu').val();
                    var formule = $(this).val();
                    var montant = pu*formule;
                    $("#montant").val(montant);
                });

                paypal.Buttons({
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: ($("#montant").val()/650)*1.06--}}
{{--{{ number_format(($bookingdata->order_amount/650)*1.06, 2) }}--}}{{--
,
                                currency : '{{ Config::get('services.paypal.currency') }}',
                                reference_id : '--}}
{{--{{ $bookingdata->order_id }}--}}{{--
',
                                description : '--}}
{{--{{ $bookingdata->event_name }}--}}{{--
',
                                invoice_id : '--}}
{{--{{ $bookingdata->order_id }}--}}{{--
',
                            }
                        }],
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Paiement effectué par ' + details.payer.name.given_name +' Veuillez patienter quelques secondes');
                        // Call your server to save the transaction
                        fetch('--}}
{{--{{ url('paypal-transaction-complete/') }}/{{ $bookingdata->order_id }}/+'data.orderID\--}}{{--
', {
                            method: 'post',
                            headers: {
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({
                                orderID: data.orderID
                            })
                        }).then(response => {
                            if (response.ok) {
                                /*response.json()
                                    .then(console.log);*/
                                window.location.href = "--}}
{{--{{ route('ticket.oderdone',$bookingdata->order_id) }}--}}{{--
";
                            } else {
                                window.location.href = "--}}
{{--{{ route('order.cancel',$bookingdata->order_id) }}--}}{{--
";
                                //console.error('server response : ' + response.status);
                            }
                        });
                })}
            }).render('#paypal-button-container');
        });
    </script>
--}}
@endsection
