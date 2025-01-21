@extends($theme)
@section('meta_title',setMetaData()->e_list_title )
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)
@section('content')

    <div class="">
        {{--    Couverture  --}}
        <section class="page-title page-title-4 image-bg overlay parallax" style="padding: 0;" >
            <div class="background-image-holder" style=" background: #1d252b;">
                <img src="https://myplace-event.com/public/img//cover-YOUTUBE.gif" alt="" class="background-image img-fluid">
            </div>
            <div class="container" style="display: none;">
                <div class="row">
                    <div class="breadcrumb breadcrumb-2 text-center">
                        <p id="breadcrumbs"><span><span><a href="https://myplace-events.com/">Accueil</a> / <strong class="breadcrumb_last" aria-current="page">Farafi Tv</strong></span></span></p>
                    </div>
                </div>
                <!--end of row-->
            </div>
            <!--end of container-->
        </section>
        <center>
            <br>
            <script src="https://apis.google.com/js/platform.js"></script>
           <div>
               <div class="g-ytsubscribe" data-channelid="UCHAgMo7VQLKQ_BcXAhmGuIw" data-layout="full" data-count="default"></div>
           </div>
        </center>
    </div>
    {{--@include("theme.events.event-search-form")--}}

    <section id="services">

        <div class="container">

            <div class="cont">
                <div class="demo-gallery">
                    <ul id="lightgallery">
                        @if(isset($webtv))
                            @foreach($webtv as $val)
                        <li class="video" data-src="{{ $val->lien_video }}"
                            data-poster="{{ $val->lien_poster }}">
                            <a href="">
                                <img class="img-responsive" src="{{ $val->lien_poster }}">
                                <div class="demo-gallery-poster">
                                    <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
                                </div>
                            </a>
                        </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

        </div>

    </section>
    <!--call to action creation événements-->
    <section class="secondary-bg  newsletter-bloc text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb5 inline-block p0-xs">Découvrez notre chaîne YouTube</h3>
                    <br>
                    <a class="btn btn-filled mb0" href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank"> <i class="fab fa-youtube"></i> Découvrir</a>

                </div>
            </div>

        </div>

    </section>
    <!--call to action creation événements-->
    <!--txt s-e-o-->
    <!--txt s-e-o-->
@endsection

@section('pageScript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#lightgallery').lightGallery();
        });
    </script>
@endsection
