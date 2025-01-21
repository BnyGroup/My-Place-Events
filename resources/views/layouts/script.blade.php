<script src="{{ asset('/js/prism.js')}}"></script>
<?php /*?><script src="{{ asset('/js/intlTelInput.js')}}"></script><?php */?>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
 
<script type="text/javascript" src="{{ asset('/js/jquery.min.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('/js/jquery-ui.min.js')}}"></script> -->
<script type="text/javascript" src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-typeahead.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-toggle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-formhelpers.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.form.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery.mockjax.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/editor/summernote-lite.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/share.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/custom.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/dharmesh.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/custom-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/mdtimepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('/js/jquery.gmaps.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery.mmenu.all.js') }}"></script>
<!-- general Page -->
<!-- <script type="text/javascript" src="{{ asset('/js/googlemap.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('services.google.api_key') }}&libraries=places&callback=Autocompleteinit" async defer></script> -->
<!-- general Page -->
<!-- Google Create events Page -->
<script type="text/javascript" src="{{ asset('/js/events/google-custom.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('services.google.api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
<!-- Google Create events Page -->
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js?ver=1.0"></script>

<!-- Add recent  -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/js/lightgallery-all.min.js"></script>
 
<script type="text/javascript" src="{{ asset('/js/jquery.matchHeight-min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/fh-3.1.6/datatables.min.js"></script>
<!-- lightgallery plugins -->
<script src="{{ asset('/js/lg-thumbnail.min.js') }}"></script>
<?php /*?><!--Mobile Nav-->
<nav id="menuMobile">
    <div id="panel-menu">
        <ul>
            <li
                    class="">
                <a href="{{ route('index') }}">Accueil</a></li>
            <li
                    class=""><a
                        href="{{ route('events') }}">Événements</a></li>
            <li
                    class=""><a
                        href="{{ route('prestataire') }}">Prestataires</a></li>
            @if(auth()->guard('frontuser')->check())
            <li
                    class=""><a
                        href="{{ route('events.create') }}"><i class="far fa-calendar-plus"></i> Créer un événement</a></li>
            <li class=""><a
                        href="{{ route('pre.create') }}"><i class="fas fa-utensils"></i> Créer un prestataire</a></li>
            @endif
            {{--<li><a href="{{ route('shop') }}"><i class="fas fa-shopping-cart"></i>Boutique</a></li>--}}
            @if(auth()->guard('frontuser')->check())
            <li
                    class=""><a
                        href="{{ route('shop_item.create') }}"><i class="ti-plus"></i> Créer un gadget</a></li>
            @endif
            {{--<li class=""><a
                        href="{{ route('services') }}">Services</a></li>--}}
            {{--<li class=""><a
                        target="_blank" href="{{ route('farafi_tv') }}">Farafi
                    TV</a></li>--}}
            {{--<li
                    class=""><a
                        href="https://blog.myplace-events.com">Blog</a></li>--}}
            <li
                    class=""><a href="https://blog.myplace-events.com/contact/">Contact</a></li>
            <li
                    class=""><a
                        href="https://myplace-events.com/condition-generales-dutilisation/">CGU</a></li>
            @if(auth()->guard('frontuser')->check())
            @else
                <li class=""><a href="{{ route('user.login') }}" class="primary-bg">Connexion / Inscription</a></li>
            @endif
        </ul>
    </div>

    <div id="panel-account">
        <ul>
            <li><a href="{{ route('user.bookmarks','upcoming') }}"><i class="icon icon-Users myicon-right"></i> Mes Tickets</a></li>
            <li><a href="{{ route('user.bookmarks','saved') }}"><i class="icon icon-Users myicon-right"></i> Evénements enregistrés</a></li>
            <li><span class="line"></span></li>
            <li><a href="{{ route('events.manage') }}"><i class="icon icon-Users myicon-right"></i> Gérer mes Evénements</a></li>
             <li><span class="line"></span></li>
             <li><a href="{{ route('shop.item.manage') }}"><i class="icon icon-Users myicon-right"></i> Gérer mes Gadgets</a></li>
            <li><span class="line"></span></li>
            <li><a href="{{ route('org.index') }}"><i class="icon icon-Users myicon-right"></i> Gérer mes Organisations</a></li>
            <li><span class="line"></span></li>
            <li><a href="{{ route('pre.index') }}"><i class="icon icon-Users myicon-right"></i> Gérer mes Prestataires</a></li>
            <li><a href="{{ route('users.pro','profile') }}"><i class="icon icon-Users myicon-right"></i> Mon Profil</a></li>
            @if(auth()->guard('frontuser')->check())
            <li><span class="line"></span></li>
            <li><a href="{{ route('user.logout') }}"><i class="icon icon-Users myicon-right"></i> Déconnexion</a></li>
            @else
            @endif
        </ul>
    </div>
</nav>
<!--./Mobile Nav-->
<?php */?>
 

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5dcc1a69d96992700fc743b2/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-122929863-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-122929863-1');
</script>



<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script type="text/javascript">
$( document ).ready(function() {
     $('#tags').typeahead({
        ajax: {
            url: "{{URL::route('serach.data')}}",
            method: "get",
            response: function(data) {
            },
            triggerLength: 1
        },
        scrollBar:true,
        onSelect: displayResult
      });

      function displayResult(item) {
        var srchdata = item
        window.location = "{{ route('events') }}?search=" + srchdata.text
      }

    $('.gmaps').gmaps();
});

$('body').on("click", "#select-id", function (event) {
  $('.hides-text').show(600);
});


window.setInterval(function(){
  @if(auth()->guard('frontuser')->check())
    $.ajax({url: "{{route('session.order')}}", success: function(result){
      console.log(result)
    }});
  @else
    console.log('not login')
  @endif
}, 15000);


</script>

<?php /*?><script>
    jQuery(document).ready(function( $ ) {
        $("nav#menuMobile").mmenu({
            "extensions": [
                 'theme-dark',
                "pagedim-black"
            ],
            "counters": true,
            "iconPanels": false,
            "searchfield": {
                placeholder: 'Recherche dans le menu'
            },
            "navbars": [
                {
                    "position": "top",
                    "content": [
                        "searchfield"
                    ]
                },
                {
                    type: 'tabs',
                    content: [
                        '<a href="#panel-menu"><i class="fa fa-bars"></i> <span>Menu</span></a>',
                        @if(auth()->guard('frontuser')->check())
                  '<a href="#panel-account"><i class="fa fa-user"></i> <span>Compte</span></a>'
                        @else
                        @endif
            ]
                },
                {
                    "position": "top"
                },
                {
                    "position": "bottom",
                    "content": ['<a href="#">My Place Events</a>']
                }
            ]
        });
    });
</script><?php */?>
<!--Lightbox-->

<!-- Compte script  -->

<?php /*?><script>
    jQuery(document).ready(function( $ ) {
        $("#menu-compte").mmenu({
            "extensions": [
                'theme-dark',
                "pagedim-black",
                "position-bottom",
                "fullscreen",
                "theme-black",
                "border-full"
            ],
            "counters": true,
            "iconPanels": false,
            "searchfield": {
                placeholder: 'Recherche dans le menu'
            },
            "navbars": [
                {
                    "position": "top",
                    "content": [
                        "searchfield"
                    ]
                },
                {
                    "position": "top"
                },
                {
                    "position": "bottom",
                    "content": ['<a href="#">My Place Events</a>']
                }
            ]
        });
    });
</script><?php */?>


<!-- Compte script  -->
<script>
    $('#aniimated-thumbnials').lightGallery({
        thumbnail:true,
    });
</script>

 
<!--Events same height -->
<script>
    $(function () {
        $('.event-card .card-title').matchHeight();

    });
</script>
<script>
    $(function () {
        $('.card p').matchHeight();

    });
</script>
<script>
    $(function () {
        $('.event-card .card ').matchHeight();

    });
</script>
<script>
    $(function () {
        $('.artistes-card .box ').matchHeight();

    });
</script>
<script>
    $(function () {
        $(' .card .card-title ').matchHeight();

    });
</script>

<script>
    $(function () {
        $(' .col-lg-4 .box ').matchHeight();

    });
</script>
<!--Events same height -->
<!--Blog card same height -->
<script>
    $(function () {
        $('.same-card').matchHeight();
    });
</script>

<script>
    $(function () {
        $('.same-card .title').matchHeight();
    });
</script>

<script>
    $(function () {
        $('#single-artistes .info-box').matchHeight();
    });
</script>
<script>
    $(function () {
        $('#services .feature-1').matchHeight();
    });
</script>

<?php /*?><!--Sticky-->
<script>


    // Sticky navbar
    // =========================
    $(document).ready(function () {
        // Custom function which toggles between sticky class (is-sticky)
        var stickyToggle = function (sticky, stickyWrapper, scrollElement) {
            var stickyHeight = sticky.outerHeight();
            var stickyTop = stickyWrapper.offset().top;
            if (scrollElement.scrollTop() >= stickyTop) {
                stickyWrapper.height(stickyHeight);
                sticky.addClass("is-sticky");
            }
            else {
                sticky.removeClass("is-sticky");
                stickyWrapper.height('auto');
            }
        };

        // Find all data-toggle="sticky-onscroll" elements
        $('[data-toggle="sticky-onscroll"]').each(function () {
            var sticky = $(this);
            var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
            sticky.before(stickyWrapper);
            sticky.addClass('sticky');

            // Scroll & resize events
            $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
                stickyToggle(sticky, stickyWrapper, $(this));
            });

            // On page load
            stickyToggle(sticky, stickyWrapper, $(window));
        });
    });
</script>
<!--Sticky--><?php */?>

<script>
    $('.dropdown-toggle').dropdown()
</script>

<script>
    $('.table-striped.table-bordered').DataTable({
        "language": {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Rechercher&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            },
            "select": {
                "rows": {
                    "_": "%d lignes sélectionnées",
                    "0": "Aucune ligne sélectionnée",
                    "1": "1 ligne sélectionnée"
                }
            }
        }
    });
</script>
