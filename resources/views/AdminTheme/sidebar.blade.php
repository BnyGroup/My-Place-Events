@inject('countData','App\User')
@inject('page','App\Page')

@php
  $currentPageURL = URL::current();
  $pageArray = explode('/', $currentPageURL);
  $pageActive = isset($pageArray[4]) ? $pageArray[4] : '';
  $pageActive_sub = isset($pageArray[5]) ? $pageArray[5] : '';
  $pageActive_subsub = isset($pageArray[6]) ? $pageArray[6] : '';
@endphp

<section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ setThumbnail(auth()->user()->profile_pic) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <?php 
            $name = auth()->user()->firstname.' '.auth()->user()->lastname
          ?>
          <p title="{{ $name }}">{{ str_limit($name,18)}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> En ligne</a>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Navigation</li>
        
        @permission('dashboard-listing')
          <li class="{{ $pageActive == 'dashboard' ? 'active' : ''  }}">
            <a href="{{ route('admin.index') }}">
              <i class="fa fa-dashboard"></i> <span>{{--Dashboard--}}Tableau de bord</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        @endpermission

        @permission('role-list')
           <li class="{{ $pageActive == 'roles' ? 'active' : ''  }}">
            <a href="{{ route('roles.index') }}">
              <i class="fa fa-check-square-o"></i><span>Roles</span>
            </a>
          </li>
        @endpermission

          @permission('slider-list')
          <li class="{{ $pageActive == 'sliders' ? 'active' : ''  }}">
              <a href="{{ route('sliders.index') }}">
                  <i class="fa fa-check-square-o"></i><span>Slider Accueil</span>
              </a>
          </li>
          @endpermission

        @permission('admin-user-listing')
            <li class="{{ $pageActive == 'users' ? 'active' : ''  }}">
          <a href="{{ route('users.index') }}">
            <i class="fa fa-users"></i> <span>Utilisateurs Admin</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">{{ $countData->countData() }}</small>
            </span>
          </a>
        </li>
        @endpermission
        @permission('front-user-list')
          <li class="{{ $pageActive == 'frontuser' ? 'active' : ''  }}">
            <a href="{{ route('frontuser.index') }}">
              <i class="fa fa-users"></i><span>Liste utilisateurs</span>
            </a>
          </li>
        @endpermission

        @permission('event-categories-list')
        <li class="{{ $pageActive == 'categories' ? 'active' : ''  }}">
          <a href="{{ route('categories.index') }}">
            <i class="fa fa-folder"></i><span>Catégories d'Events</span>
          </a>
        </li>
        @endpermission

        @permission('service-list')
          <li class="{{ $pageActive == 'service' ? 'active' : ''  }}">
              <a href="{{ route('service.index') }}">
                  <i class="fa fa-check-square-o"></i><span>Services</span>
              </a>
          </li>
        @endpermission
        

        @permission('event-list')
         <li class="{{ $pageActive == 'events' ? 'active' : ''  }}">
          <a href="{{ route('event.list') }}">
            <i class="fa fa-list-alt"></i><span>Liste Events</span>
          </a>
        </li>
        @endpermission
		  
		 @permission('event-list')
         <li class="{{ $pageActive == 'banner-immanquables' ? 'active' : ''  }}">
          <a href="{{ route('admin.bannerimmanquables') }}">
            <i class="fa fa-list-alt"></i><span>Les Immanquables</span>
          </a>
        </li>
        @endpermission 

          <li class="{{ $pageActive == 'liste-livraison' ? 'active' : ''  }}">
              <a href="{{ route('delivery.list') }}">
                  <i class="fa fa-money"></i><span>Livraison de Billets</span>
              </a>
          </li>

      @permission('prestataire-list')
      <li class="{{ $pageActive == 'prestataire' ? 'active' : ''  }}">
          <a href="{{ route('pres.list') }}">
              <i class="fa fa-list-alt"></i><span>Liste des Blogs</span>
          </a>
      </li>
      @endpermission

    @permission('newsletter-abonnes')
    <li class="{{ $pageActive == 'newsletter-abonnes' ? 'active' : '' }}">
        <a href="{{ route('newsletter.abonnes') }}">
            <i class="fa fa-envelope"></i><span>abonnés à la newsletter</span>
        </a>
    </li>
     @endpermission

      @permission('a-la-une-list')
      <li class="{{ $pageActive == 'a_la_une' ? 'active' : ''  }}">
          <a href="{{ route('alu.list') }}">
              <i class="fa fa-list-alt"></i><span>Mise à la une</span>
          </a>
      </li>
      @endpermission
		  
		  
		<li class="{{ $pageActive == 'booking' ? 'active' : ''  }}">
          <a href="{{ route('booking.user') }}">
            <i class="fa fa fa-tag"></i><span>Réservation utilisateur</span>
          </a>
        </li>  
		  
		 <li class="treeview 
                        @if (
                            request()->is([
                                'products',
                                'products/*',
                                'products/product-order',
                                'products/product-order/*'
                            ]) 
                            && 
                            !request()->is([
                                'products/product-inventory',
                                'products/attributes',
                                'products/coupons',
                                'products/ratings',
                                'products/product-order'
                            ])
                        ) 
                                active 
                        @endif"
                    >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-dropbox"></i><span>{{ __('Gestion de la Boutique') }}</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                             
                            <li class="{{ active_menu('products') }}">
                                <a href="{{ route('admin.products.all') }}">{{ __('Gestion des Produits') }}</a>
                            </li>
                             
                            <li class="{{ active_menu('products/deleted') }}">
                                <a href="{{ route('admin.products.deleted.all') }}">{{ __('Produits supprimés') }}</a>
                            </li>
                             
                            <li class="{{ active_menu('products/categories') }}">
                                <a href="{{ route('admin.products.category.all') }}">{{ __('Catégorie') }}</a>
                            </li>
                             
                            <li class="{{ active_menu('products/sub-categories') }}">
                                <a href="{{ route('admin.products.subcategory.all') }}">{{ __('Sous-Catégorie') }}</a>
                            </li>
                             
                            <li class="{{ active_menu('products/tags') }}">
                                <a href="{{ route('admin.products.tag.all') }}">{{ __('Tags') }}</a>
                            </li>
							<li><hr></li>
							<li><a href="">Gestion des commandes</a></li>
                            <li><a href="{{ route('admin.banner.store') }}">Gestion des bannières du Store</a></li>
                        </ul>
                    </li> 
		  
		  

      @permission('webtv-list')
      <li class="{{ $pageActive == 'webtv' ? 'active' : ''  }}">
          <a href="{{ route('webtv.index') }}">
              <i class="fa fa-list-alt"></i><span>FARAFI TV</span>
          </a>
      </li>
      @endpermission

        @permission('organization-list')
        <li class="{{ $pageActive == 'org' ? 'active' : ''  }}">
          <a href="{{ route('org.indexs') }}">
            <i class="fa fa-list-alt"></i><span>Liste Organisation</span>
          </a>
        </li>
        @endpermission



        @permission('booking-list')
        <li class="{{ $pageActive == 'booking' ? 'active' : ''  }}">
          <a href="{{ route('booking.user') }}">
            <i class="fa fa fa-tag"></i><span>Réservation utilisateur</span>
          </a>
        </li>
        @endpermission
          
       @permission('booking-list')
        <li class="{{ $pageActive == 'coupons' ? 'active' : ''  }}">
          <a href="{{ route('coupons.tickets') }}">
            <i class="fa fa fa-tag"></i><span>Gestion Codes Coupons</span>
          </a>
        </li>
        @endpermission  

        <li class="{{ Request::is('admin/sold/tickets') || Request::is('admin/manage/events/*') || Request::is('admin/order/earn/*')?'active':''  }}">
          <a href="{{ route('sold.tik') }}">
            <i class="fa fa fa-tag"></i><span>Gérer les tickets et gains</span>
          </a>
        </li>

        <li class="treeview {{ $pageActive == 'refund' ? 'menu-open' : ''  }}">
            <a href="">
                <i class="fa fa-cog"></i><span>Commande &  Remboursement </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu" style="display: {{ $pageActive == 'refund' ? 'block' : 'none'  }}; padding-left:0px; " >
                  <li class="{{ $pageActive_sub == 'pending' ? 'active' : ''  }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                    <a href="{{ route('request.refund') }}"><i class="fa fa-cog"></i>Remboursement en attente</a>
                  </li>
                  <li class="{{ $pageActive_sub == 'accept' ? 'active' : ''  }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                    <a href="{{ route('accept.refund') }}"><i class="fa fa-cog"></i>Remboursement accepté</a>
                  </li>
                  <li class="{{ $pageActive_sub == 'reject' ? 'active' : ''  }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                    <a href="{{ route('reject.refund') }}"><i class="fa fa-cog"></i>Remboursement refusé</a>
                  </li>
                </ul>
          </li>


        @permission('feedback-list')
        <li class="{{ $pageActive == 'feedback' ? 'active' : ''  }}">
          <a href="{{ route('feedback.index') }}">
            <i class="fa fa fa-file-text-o"></i><span>Feedback</span>
          </a>
        </li>
        @endpermission
        @permission('contact-page')
            <li class="{{ $pageActive == 'contact' ? 'active' : ''  }}">
              <a href="{{ route('contact.index')}}"><i class="fa fa-file-text-o"></i>Contactez-nous</a>
            </li>
        @endpermission

         @permission('menu-setting')
            <li class="{{ $pageActive == 'menu' ? 'active' : ''  }}">
              <a href="{{ route('menus.index')}}"><i class="fa fa-file-text-o"></i>Configuration Menu</a>
            </li>
        @endpermission

          <li class="{{ $pageActive == 'menu' ? 'active' : ''  }}">
              <a href="{{ route('litige') }}"><i class="fa fa-file-text-o"></i>Cas litigieux</a>
          </li>

        @permission('pages-menu')
        <li class="treeview {{ $pageActive == 'pages'   ? 'menu-open' : ''  }}">
              <a href="">
                <i class="fa fa-files-o"></i><span>Pages</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            <ul class="treeview-menu" style="display: {{ $pageActive == 'pages' ? 'block' : 'none'  }}; padding-left:0px; " >
              <li class="{{ $pageActive_sub == 'create' ? 'active' : ''  }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                <a href="{{ route('page.index') }}"><i class="fa fa-file-text-o"></i>Création page</a>
              </li>
              @foreach($page->getList() as $key => $data)
              <li class="{{ $pageActive_sub == $data->page_slug ? 'active' : ''}}">
                <a href="{{ route('pages.index',$data->page_slug) }}"><i class="fa fa-file-text-o"></i>{{ $data->page_title }}</a>
              </li>
              @endforeach
            </ul>
          </li>
        @endpermission

        <!-- @permission('pages-menu')
         <li class="treeview {{ $pageActive_sub == 'pages' ? 'active' : ''  }}">
          <a href="">
            <i class="fa fa-files-o"></i><span>Page Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        @endpermission
          <ul class="treeview-menu">
            @permission('aboutus-page')
            <li class="{{ $pageActive == 'aboutus' ? 'active' : ''  }}">
              <a href="{{ route('aboutus.index')}}"><i class="fa fa-file-text-o"></i>About Us</a>
            </li>
            @endpermission
            @permission('terms-page')
            <li class="{{ $pageActive == 'terms' ? 'active' : ''  }}">
              <a href="{{ route('terms.index')}}"><i class="fa fa-file-text-o"></i>Terms & Condition</a>
            </li>
            @endpermission
            @permission('privacy-page')
            <li class="{{ $pageActive == 'privacy' ? 'active' : ''  }}">
              <a href="{{ route('privacy.index')}}"><i class="fa fa-file-text-o"></i>Privacy Policy</a>
            </li>
            @endpermission
            @permission('faq-page')
            <li class="{{ $pageActive == 'faqs' ? 'active' : ''  }}">
              <a href="{{ route('faqs.index')}}"><i class="fa fa-file-text-o"></i>FAQS</a>
            </li>
            @endpermission
            @permission('support-page')
            <li class="{{ $pageActive == 'support' ? 'active' : ''  }}">
              <a href="{{ route('support.index')}}"><i class="fa fa-file-text-o"></i>Support</a>
            </li>
            @endpermission
            @permission('server-requre-page')
            <li class="{{ $pageActive == 'faqs' ? 'active' : ''  }}">
              <a href="{{ route('sreqrmnt.index')}}"><i class="fa fa-file-text-o"></i>Server Requirement</a>
            </li>
            @endpermission
          </ul> -->
          @permission('website-setting-data')
           <li class="treeview {{ $pageActive == 'settings'   ? 'menu-open' : ''  }}">
              <a href="">
                <i class="fa fa-cog"></i><span>Paramètres</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display: {{ $pageActive == 'settings' ? 'block' : 'none'  }}; padding-left:0px; " >
                <li class="{{ $pageActive_sub == 'index' ? 'active' : ''  }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                  <a href="{{ route('settings.index') }}"><i class="fa fa-cog"></i>Paramètre du site</a>
                </li>
                <li class="{{ $pageActive_sub == 'configuration'?'active':'' }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                  <a href="{{ route('settings.configuration') }}"><i class="fa fa-cog"></i>Configuration du site</a>
                </li>
				 <li class="{{ $pageActive_sub == 'configuration'?'active':'' }}" style="border-bottom:1px solid #222d32;padding-bottom:5px;">
                  <a href="{{ route('langues.list') }}"><i class="fa fa-cog"></i>Langue & Traduction</a>
                </li>
              </ul>
          </li>
          @endpermission



          @permission('seo-meta-settings')
          <li class="{{ $pageActive == 'seometa' ? 'active' : ''  }}">
            <a href="{{ route('seometa.index')}}"><i class="fa fa-cog"></i>SEO Meta</a>
          </li>
          @endpermission
          
          {{--<li class="{{ $pageActive == 'Bank' ? 'active' : ''  }}">
            <a href="{{ route('bank.create')}}"><i class="fa fa-cog"></i>Bank Details</a>
          </li>--}}
        </li>
      </ul>
    </section>

