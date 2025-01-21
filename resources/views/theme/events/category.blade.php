@inject(eventCat,'App\EventCategory')
@extends($theme)
@section('content')
<section class="section-bg home-section-bg mt-md-5 artistes-card">
    <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 20px;" class="section-title">Liste des <span class="primary-color ">Catégories</span></h1>
        <div class="col-md-12">
            <div class="title-style fiche-events">
                <div class="icon-bg"><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                <hr align="center">
            </div>
        </div>
    </div>
    <div class="container">

        <!--popular events box-->
        <div class="row">
            @foreach($eventCat->getAllList() as $key => $data)
                @if($data->status == 1)
                    <div class="col-sm-3 hover">
                        <div class="box" style="position: relative;">
                            <a href="{{ route('e.detail',$data->url_slug) }}"><img src="{{ getImage($data->category_image,'thumb')  }}" alt="{{ $data->category_name }}"  class="img-fluid"></a>
                            <div class="box-content card__padding">
                                <h4 class="card-title"><a href="{{ route('pre.detail',$data->url_slug) }}">{{ $nom }}</a>
                                </h4>
                                <div class="badge category" style="cursor: default">
                                      <span class="">
                                          {{ $data->activites }}
                                      </span>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <div class="card__action">
                                <div class="card__location">
                                    <div class="card__location-content">
                                        <i class="fas fa-map-marker-alt primary-color"></i>
                                        <a href="" rel="tag" class="third-color bold"> {{ $data->adresse_geo}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg text-center">
                <br>
                <a class="text-uppercase btn-seemore btn" href="{{ route('prestataire') }}">@lang('words.home_content.event_more_btn')</a>
            </div>
        </div>
        {{--<div class="row">
            <div class="col-lg text-center">
                <br>
                <a class="text-uppercase btn-seemore btn" href="{{ route('events') }}">@lang('words.home_content.event_more_btn')</a>
            </div>
        </div>--}}
    </div>
    <!--popular events box over-->

    <!--Events sur la Maps -->

    <!--container start-->
    <div class="container" style="display: none;">
        <div class="row">
            <div class="col-lg text-center categories-browse-title">
                <h1>@lang('words.home_content.cat_title')</h1>
            </div>
        </div>
    </div>
</section>

@endsection