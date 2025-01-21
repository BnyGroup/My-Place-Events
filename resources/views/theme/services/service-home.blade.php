@extends($theme)
@section('meta_title',setMetaData()->e_list_title )
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)
@section('content')

    <div class="">
        {{--    Couverture  --}}
        {{--<section class="page-title page-title-4 image-bg overlay parallax">
            <div class="background-image-holder fadeIn" style="transform: translate3d(0px, 0px, 0px); background: url(&quot;https://myplace-events.com/wp-content/uploads/2018/03/pexels-photo-139387.jpeg&quot;); top: -135px;">

                <img src="https://myplace-events.com/wp-content/uploads/2018/03/pexels-photo-139387.jpeg" alt="" class="background-image" style="display: none;">

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2 class="mb0">Services</h2>
                    </div>

                    <div class="breadcrumb breadcrumb-2 text-center">
                        <p id="breadcrumbs"><span><span><a href="https://myplace-event.com/">Accueil</a> / <strong class="breadcrumb_last" aria-current="page">Services</strong></span></span></p>
                    </div>

                </div>
                <!--end of row-->
            </div>
            <!--end of container-->
        </section>--}}
        <div class="list-bg page-title-special service-list"><h2 align="center">Services</h2>
        </div>
    </div>
    {{--@include("theme.events.event-search-form")--}}
    <div class="container">
        <div class="row mt-md-5">
            {{--@if(!empty($services))
                @foreach($services as $service)

                @endforeach
            @endif--}}

            {{--    Liste des services  --}}
        </div>

    </div>

    <section id="services">

<div class="container">
    @foreach($services as $val)
    @php $image = ($val->service_icon!= '')? getImage($val->service_icon, 'thumb'): asset('/default/thumb-image-not-found.jpg') ;  @endphp
    <div class="col-md-12 service-item-content" style="font-size: 18px" id="billetterie-en-ligne">
        <div class="row">
            <div class="col-md-4">
                <div class="feature feature-1  bordered radius v-align-children primary-bg" style="height: 320px;">
                    <div class="text-center  icon-text">
                        <!--icone-->

                        <img src="{{ $image }}"
                             alt="Services My Place Events" style="margin: auto;width: 50%;">

                        <!--icone-->

                        <h3 class="white-color mb0"><strong>{{ $val->service_title }}</strong></h3>
                    </div>
                </div>
                <div class="tiangle triangle-right"></div>
            </div>
            <div class="col-md-8">
                <div class="feature feature-1 bordered radius" style="height: 320px;">
                    <div class="text-center">
                        <p style="text-align: center;">{{ $val->service_description }}</p>

                        <p style="text-align: center;">


                            <a class="btn btn-filled mb0"
                               href="{{ $val->service_link }}">Adhérer</a>


                        </p></div>


                </div>
            </div>
        </div>

    </div>
    @endforeach
</div>

{{--

    <div class="col-md-12 service-item-content" style="font-size: 18px" id="promotion-prestataires">
        <div class="row">
            <div class="col-md-4">
                <div class="feature feature-1  bordered radius v-align-children primary-bg" style="height: 320px;">
                    <div class="text-center  icon-text">
                        <!--icone-->

                        <img src="https://myplace-events.com/wp-content/uploads/2018/03/myplace-events-white_promotion-artistes.png"
                             alt="Services My Place Events" style="margin: auto">

                        <!--icone-->

                        <h3 class="white-color mb0"><strong>Promotion Prestataire</strong></h3>
                    </div>
                </div>
                <div class="tiangle triangle-right"></div>
            </div>
            <div class="col-md-8">
                <div class="feature feature-1 bordered radius" style="height: 320px;">
                    <div class="text-center">
                        <p style="text-align: center;">Développez des opportunités d’affaires en partageant votre
                            savoir-faire au grand public et aux organisateurs d’événements. Grâce à ces nouveaux
                            clients
                            qui donneront un vrai coup de boost à votre activité, vous deviendrez rapidement un
                            partenaire incontournable.</p>

                        <p style="text-align: center;">


                            <a class="btn btn-filled mb0"
                               href="https://myplace-events.com/creer-un-artiste">Adhérer</a>


                        </p></div>


                </div>
            </div>
        </div>


    </div>


    <div class="col-md-12 service-item-content" style="font-size: 18px" id="mise-a-la-une">
        <div class="row">
            <div class="col-md-4">
                <div class="feature feature-1  bordered radius v-align-children primary-bg" style="height: 282px;">
                    <div class="text-center  icon-text">
                        <!--icone-->

                        <img src="https://myplace-events.com/wp-content/uploads/2018/03/myplace-events-white_mise-a-la-une.png"
                             alt="Services My Place Events" style="margin: auto">

                        <!--icone-->

                        <h3 class="white-color mb0"><strong>Mise à la Une</strong></h3>
                    </div>
                </div>
                <div class="tiangle triangle-right"></div>
            </div>


            <div class="col-md-8">
                <div class="feature feature-1 bordered radius" style="height: 282px;">
                    <div class="text-center">
                        <p>Multipliez vos chances d’être remarqué et d’atteindre vos objectifs. En haut de liste, en
                            tête de site, en photo de couverture…A vous de choisir l’option la plus adaptée pour
                            mettre
                            en avant votre événement ou votre activité.</p>

                        <p style="text-align: center;">


                            <!--Modal-->
                        </p>

                        <div class="modal-container">
                            <a class="btn btn-filled mb0 btn-modal" modal-link="0" href="#">Adhérer</a>

                            <div class="foundry_modal modal-acknowledged">

                            </div>
                        </div>
                    </div>
                    <!--Modal-->

                </div>


            </div>
        </div>
    </div>

    <div class="col-md-12 service-item-content" style="font-size: 18px" id="publicite">
        <div class="row">
            <div class="col-md-4">
                <div class="feature feature-1  bordered radius v-align-children primary-bg" style="height: 280px;">
                    <div class="text-center  icon-text">
                        <!--icone-->

                        <img src="https://myplace-events.com/wp-content/uploads/2018/03/myplace-events-white_publicite.png"
                             alt="Services My Place Events" style="margin: auto">

                        <!--icone-->

                        <h3 class="white-color mb0"><strong>Publicité</strong></h3>
                    </div>
                </div>
                <div class="tiangle triangle-right"></div>
            </div>
            <div class="col-md-8">
                <div class="feature feature-1 bordered radius" style="height: 280px;">
                    <div class="text-center">
                        <div align="left">
                            <p dir="ltr" style="text-align: center;">Vous êtes une marque ? S<span
                                        style="color: #000000;">aisissez&nbsp;</span>l’occasion <span
                                        style="color: #000000;">de</span> créer un lien avec notre communauté<span
                                        style="color: #000000;"> à travers la diffusion de bannières publicitaires, en présentant vos offres les plus attractives.</span>
                            </p>
                        </div>
                        <p dir="ltr" style="text-align: center;">


                            <!--Modal-->
                        </p>

                        <div class="modal-container">
                            <a class="btn btn-filled mb0 btn-modal" modal-link="1" href="#">Adhérer</a>

                            <div class="foundry_modal modal-acknowledged">
                            </div>
                        </div>
                        <!--Modal-->

                    </div>


                </div>
            </div>

        </div>

    </div>


    <div class="col-md-12 service-item-content" style="font-size: 18px" id="web-tv">
        <div class="row">
            <div class="col-md-4">
                <div class="feature feature-1  bordered radius v-align-children primary-bg" style="height: 280px;">
                    <div class="text-center  icon-text">
                        <!--icone-->

                        <img src="https://myplace-events.com/wp-content/uploads/2018/03/myplace-events-white_web-tv.png"
                             alt="Services My Place Events" style="margin: auto">

                        <!--icone-->

                        <h3 class="white-color mb0"><strong>Web TV</strong></h3>
                    </div>
                </div>
                <div class="tiangle triangle-right"></div>
            </div>
            <div class="col-md-8">
                <div class="feature feature-1 bordered radius" style="height: 280px;">
                    <div class="text-center">
                        <p>Nous développons des contenus créatifs en collaboration avec les organisateurs
                            d’événements
                            et prestataires événementiels, afin d’améliorer l’expérience utilisateur.</p>

                        <p style="text-align: center;">


                            <a class="btn btn-filled mb0"
                               href="https://myplace-events.com/nos-services/web-tv/">Adhérer</a>

                        </p></div>


                </div>
            </div>
        </div>


    </div>

</div>
--}}

    </section>
    <!--call to action creation événements-->
    <section class="secondary-bg  newsletter-bloc text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb5 inline-block p0-xs">@lang('words.Prest.texte_1') </h3>
                    <br>
                    <a class="btn btn-filled mb0" href="{{ route('events.create') }}"> <i class="ti-plus">
                            &nbsp;</i> @lang('words.user_menus.usr_mnu_log_3')</a>

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
        $(document).ready(function () {
            /* $('#home-search-form input[type="submit"]').on('click', function() {
             var i = 0;
             var selectEnfants = $('#home-search-form select[name="event_country"]').children();
             var selectNombreEnfant = selectEnfants.length;
             }); */

            $('#forDateContent').hide()
            $('#forDate').on('mousedown', function () {
                $('#forDateContent').toggle();
            });

            $("#forDateContent a").on('click', function () {
                var inputValue = $(this).text();
                $('#forDate').val(inputValue);
                $('#forDate').val().replace(' ', '');

                if ($("#forDate").val() == $("#forDateContent li:last").text()) {
                    $('#forDate').val('cdate');
                }
            });

            $('#custom_date').on('click', function () {
                $("#forDateContent li:last").toggle();
            });

            var div_cliquable = $('#forDate');
            $(document.body).click(function (e) {
                // Si ce n'est pas #ma_div ni un de ses enfants
                if (!$(e.target).is(div_cliquable) && !$.contains(div_cliquable[0], e.target) && !$(e.target).is($('#forDateContent')) && !$.contains($('#forDateContent')[0], e.target)) {
                    $('#forDateContent').hide(); // masque #ma_div en fondu
                }
            });

            var emptyDateF = $('#list-search-form input #forDate').val();
            var emptyDateD = $('#list-search-form input #forDate').val();
            $('#list-search-form input[type="submit"]').on('click', function () {
                if ((emptyDateF).empty() && !emptyDateD.empty()) {
                    $('#list-search-form input #forDate').val(emptyDateD);
                }
            });

        });
    </script>
    <script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    <!-- USER NOT LOGIN MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog"
         aria-labelledby="sighupalert" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>

                    <p class="modal-text">@lang('words.save_eve_content')</p>

                    <div class="model-btn">
                        <a href="{{ route('user.signup') }}"
                           class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>

                        <p class="modal-text-small">
                            @lang('words.save_eve_login_txt') <a
                                    href="{{ route('user.login') }}">@lang('words.save_eve_login_btn')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- USER NOT LOGIN MODEL -->
    <!-- SHARE EVENT MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>

                    <div class="share" id="share-body">
                        <a href="" class="social-button social-logo-detail facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail google">
                            <i class="fa fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SHARE EVENT MODEL -->
@endsection
@section('pageScript')
    <script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    <!-- USER NOT LOGIN MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog"
         aria-labelledby="sighupalert" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>

                    <p class="modal-text">@lang('words.save_eve_content')</p>

                    <div class="model-btn">
                        <a href="{{ route('user.signup') }}"
                           class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>

                        <p class="modal-text-small">
                            @lang('words.save_eve_login_txt') <a
                                    href="{{ route('user.login') }}">@lang('words.save_eve_login_btn')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- USER NOT LOGIN MODEL -->
    <!-- SHARE EVENT MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>

                    <div class="share" id="share-body">
                        <a href="" class="social-button social-logo-detail facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail google">
                            <i class="fa fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SHARE EVENT MODEL -->
@endsection
