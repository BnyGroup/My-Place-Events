@extends($theme)
{{-- @extends('layouts.master', ['body_class' => 'home-page']) --}}
@section('meta_title',setMetaData()->home_title)
@section('meta_description',setMetaData()->home_desc)
@section('meta_keywords',setMetaData()->home_keyword)
@section('content')

    <!--CONTENT START-->
    <section class="section-bg home-section-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center content-title">
                    <h1 style="margin-bottom: 20px;" class="section-title">  Information produit </h1>
                    <div class="col-md-12">
                        <div class="title-style fiche-events">
                            <div class="icon-bg"><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                            <hr align="center">
                        </div>
                    </div>
                </div>
            </div>
            <!--popular events box-->
             {{--{{ dd($maluInfo) }}--}}
            <div class="row">
                <div class="col-sm-12">
                    @if($error = Session::get('error'))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @elseif($success = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $success }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div content="col-sm-12">
                    @if($maluInfo->type_service == 'Slider')
                         <div class="row">
                             <div class="col-sm-12">
                                 <h2>{{ $maluInfo->type_service }}</h2>
                             </div>
                             <div content="col-sm-8">
                                <p>Durée du service : {{ $maluInfo->duree_service }}</p>
                                 <p>Montant à payer {{ $maluInfo->montant }}</p>
                                 <p>Titre : {{ $maluInfo->titre_slide}}</p>
                                 <p>Description : {{ $maluInfo->description_slide }}</p>
                                 <p>Lien de redirection : {{ $maluInfo->url_entete_slide }}</p>
                                 <p>Texte du bouton : {{ $maluInfo->slide_btn_text}}</p>
                                 <p>Texte du bouton : {{ $maluInfo->slide_btn_text}}</p>
                             </div>
                             <div content="col-sm-4">
                                <img src="{{ url($maluInfo->image_slide_entete) }}" style="width: 60%;">
                             </div>
                         </div>
                     @else
                        <div class="row">
                            <div class="col-sm-12">
                                <h2>{{ $maluInfo->type_service }}</h2>
                            </div>
                            <div content="col-sm-8">
                                <p>Durée du service : {{ $maluInfo->duree_service }}</p>
                                <p>Montant à payer {{ $maluInfo->montant }}</p>
                                <p>Lien de redirection : {{ $maluInfo->url_entete_slide }}</p>
                            </div>
                            <div content="col-sm-4">
                                <img src="{{ url($maluInfo->image_slide_entete) }}" style="width: 60%;">
                            </div>
                        </div>
                     @endif
                </div>
            </div>
            <div class="row">
                {!! Form::open(['method'=>'post','route'=>'alu.pay']) !!}
                    <div class="col-lg text-center">
                        <br>
                        <input type="hidden" name="slug" value="{{ $maluInfo->slug }}" id="slug"/>
                        <input type="hidden" name="duree" value="{{ $maluInfo->duree_service }} " id="duree">
                        <input type="hidden" name="montant" value="{{ $maluInfo->montant }}" id="montant"/>
                        <input type="hidden" name="designation" value="{{ $maluInfo->type_service }}" id="service"/>
                        <input type="submit" value="En attente de paiement" class="btn-paiement">

                        <button type="submit" class="text-uppercase btn-seemore btn"> Passer la commande </button>
                    </div>
                {!! Form::close() !!}
                <div>
                    <a href={{ route('alu.index') }}> Retour </a>
                </div>
            </div>
        </div>
    </section>
@endsection