@inject('page',App\Page)
 

  <div id="newsletter">
  <div id="mobile-title">
    <p style="color: #fff;">Abonne toi à la newsletter</p>
  </div>
  <div id="titlenewletter">
    <h1 id="titl_mobile">MPE-NEWSLETTER</h1>
  </div>
  <div id="container_news">
    <p>soit informé de nos événemenets partenaires,de nos <br> dernières actualités et plus!</p>
  </div>

 <form id="newsletter-form" action="{{ route('subscribe') }}" method="POST">
    {{ csrf_field() }}
    <div class="input-wrapper">
      <input type="email" name="email" placeholder="Entre ton adresse email" required>
      <button id="button-newletter" type="submit"><span id="text-butt-newlet">je m'abonne</span> </button>
    </div>
</form>
</div>

<style type="text/css">
  #titlenewletter {
    color: #D600A9;
    text-align: center;
  }

  #container_news {
    color: #000D8C;
    text-align: center;
    margin-bottom: 20px;
  }

  #newsletter {
    font-family: Arial, sans-serif;
    background-color: #FFF;
    font-size: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;

  }

  .input-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    width: 100%;
  }

  input[type="email"] {
    width: 250px;
    padding: 10px;
    border: 1px solid #D600A9;
    border-radius: 30px 30px 30px 30px;
  }

  #button-newletter {
    position: relative;
    right: 23%;
    width: 80px;
    height: 37px;
    background-color: #D600A9;
    color: white;
    border: none;
    border-radius: 20px 20px 20px 20px;
    cursor: pointer;
  }

     #text-butt-newlet{
         font-size: 1em;
    }

  @media screen and (max-width: 768px) {
  /* Ajustements pour les appareils Apple */
  #newsletter {
    padding: 20px 10px; /* Ajuster le padding pour un meilleur ajustement */
  }

  .input-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    width: 100%;
  }

  input[type="email"] {
    width: 200px; /* Ajuster la largeur de l'input */
    padding: 10px;
    border: 1px solid #D600A9;
    border-radius: 30px 30px 30px 30px; /* Ajuster le border-radius */
    margin-right: 10px; /* Espacement entre l'input et le bouton */
  }

  #button-newletter {
    width: auto; /* Ajuster la largeur du bouton pour s'adapter au contenu */
    height: 37px;
    padding: 0 20px; /* Ajuster le padding pour un meilleur ajustement */
    font-size: 1em;
     /* Ajuster la taille de la police */
     position: relative;
     right: 90px;
  }
     #text-butt-newlet{
         font-size: 1em;
    }
}
  @media screen and (max-width: 400px) {
  

    .input-wrapper {
     display: flex;
     justify-content: space-around;
     position: relative;
      left: 15%;
    }

    input[type="email"] {
      width: 200px;
      margin-bottom: 10px;
      font-size: 8px;
    }

    #button-newletter{
      width: 80px;
      border-radius: 30px 30px 30px 30px;
      position: relative;
      height: 35px;
      bottom: 5px;
    }
     #text-butt-newlet{
       font-size: 0.739em;
    }
  }
</style>
<footer class="footer-1 third-bg text-center-xs">

    <div class="container">

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 info-contact text-center-xs" style="margin-right: 45px;">
                <div class="widget">
					<div class="row">
					  <div class="col-lg-12 text-center content-title">
						<h1 class="top-presta section-title"><a href="#">MY PLACE EVENTS</a></h1>
					  </div>
					</div>
					<hr>

                    <!--Infos contacts -->
                    <p style="margin-top: 40px;">
                        <i class="fas fa-map-marker-alt secondary-color"></i> Immeuble Arc-en-ciel, 2ème étage, avenue Chardy, Abidjan Plateau
                        <br>

                        <a class="color-white" style="font-weight: normal" href="mailto:contact@myplace-events.com"> <i class="fas fa-envelope secondary-color"></i> contact@myplace-events.com </a>
                        <br>
                        <i class="fas fa-phone secondary-color"></i> +225 07 47 97 45 05
                    </p>
                    <!--./Infos contacts -->

                </div>

            </div>

            <!--Qr Code Scan-->
            <div class="col-lg-2 col-md-6 col-sm-12 text-center-xs hide-991" style="margin-right: 45px;">
                <div class="widget">
					<div class="row">
					  <div class="col-lg-12 text-center content-title">
						<h1 class="top-presta section-title"><a href="#">SCAN TICKETS</a></h1>
					  </div>
					</div>
					<hr>
 					<div align="center"style="margin-top: 40px;">
                     <img src="{{ url('public/img/scanqrcode.png')}}">
					</div>
                </div>

            </div>
            <!--Qr Code Scan-->

            <!--Présentation application mobile footer-->
            <div class="col-lg-4 col-md-6 col-sm-12 text-center-xs apps-logo">
                <div class="widget">
					<div class="row">
					  <div class="col-lg-12 text-center content-title">
						<h1 class="top-presta section-title"><a href="#">@lang('words.footer.footer_stay_connected')</a></h1>
					  </div>
					</div>
					<hr>
                     

                    <div class="text-justify mb16" style="margin-top: 45px;">
                        <ul class="list-inline social-list">
							<li>
								<a href="https://www.linkedin.com/company/my-place-events/?originalSubdomain=ci" target="_blank">
									<i class="ti-linkedin"></i>
								</a>
							</li>
							<li>
								<a href="https://www.facebook.com/myplaceeventscom/" target="_blank">
									<i class="ti-facebook"></i>
								</a>
							</li>
							<li>
								<a href="https://www.instagram.com/myplace_events/" target="_blank">
									<i class="fa fa-instagram" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank">
									<i class="fa fa-youtube-play" aria-hidden="true"></i>
								</a>
							</li>

						</ul>
                    </div>
            
                     

                </div>

            </div>
            <!--Présentation application mobile footer-->

            
        </div>

<hr>
<div class="footer-legals no-print">
    <a href="https://myplace-events.com/fr/pages/conditions-generales-dutilisation">Conditions générales de vente</a> |
     <a target="_blank" href="https://myplace-events.com/fr/pages/politique-de-confidentialite-des-donnees-personnelles">Politique de confidentialité</a> | 
     <a href="https://myplace-events.com/fr/contacts/index" target="_blank">Aide / FAQ / Contact</a>
</div>



<!--copyright-->
<div class="col-md-12 text-center-xs copy-right-wrapper" id="copyright">
    <div class="container" style="padding: 20px 0 90px 15px;">
        <div class="row">
            <div class="col-md-6 copyrightText">
                    <span class="">
                        <small>
                            @lang('words.copyright') {{date('Y')}} @lang('words.copy_year')<br> created by <a class="color-white"
                                                                                               href="https://bny-group.com/"
                                                                                               target="_blank"
                                                                                               title="BNY GROUP"
                                                                                               style="display: inline-block;font-size: 20px;font-weight: bold;">BNY GROUP
                               <?php /*?> <img class="comfordev"
                                     src="{{ url('public/img/builder-icon/comfordev-agence-communication-cote-ivoire.png') }}"
                                     alt="Comfordev | Agence Web Abidjan" style="display: inline-block;"><?php */?>
                            </a>
                        </small>
                    </span>
            </div>
            <div class="col-sm-6 text-right social-icon">
                
            </div>
        </div>
    </div>
</div>

    </div>
      <!-- button abonnement -->

<!--     <div class="abonnement">  
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsletterModal">
    S'abonner à la newsletter
</button> -->

<!-- Modale pour saisir l'e-mail -->
<!-- <div class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="newsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsletterModalLabel">S'abonner à notre newsletter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php /*{{ route('subscribe') }} */ ?>" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre adresse e-mail" required>
                    </div>
                    <button type="submit" class="btn btn-primary">S'abonner</button>
                </form>
            </div>
        </div>
    </div>
</div> -->   
<!-- </div>  -->  
<!-- button abonnement --> 

  <!--   <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Écouteur d'événement pour la soumission du formulaire
        document.getElementById('subscriptionForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher la soumission du formulaire par défaut

            // Envoyer une requête AJAX pour soumettre le formulaire
            fetch(this.action, {
                method: this.method,
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                // Vérifier si une erreur a été renvoyée
                if (data.error) {
                    // Mettre à jour le contenu du modal avec le message d'erreur
                    document.getElementById('subscriptionError').innerText = data.error;
                    document.getElementById('subscriptionError').style.display = 'block';
                } else {
                    // Rediriger avec un message de succès si aucune erreur
                    window.location.reload('abonnement effectuer');
                }
            });
        });
    });
</script> -->
        
</footer>

<style type="text/css">


    .modal-open .modal {
        overflow-x: hidden !important;
        overflow-y: auto !important;
        z-index: 9999999 !important;
    }

    .ticket-registion .modal-body {
        min-height: 320px !important;
        overflow-y: auto !important;
    }
 

    @media screen and (max-width:730px){
        input#btnBookTicket {
            display: block !important;
            width: 100% !important;
            float: none !important;
            position: relative !important;
            margin-top: 20px;
        }
        .modal-content .modal-footer {
            padding: 10px !important;
            display: block !important;
        }
        .modal-footer .total-qty, .modal-footer .total-amount {
            width: 43% !important;
            display: inline-block !important;
        }
    }
</style>

