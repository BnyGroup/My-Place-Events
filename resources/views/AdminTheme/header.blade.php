@php Jenssegers\Date\Date::setLocale('fr'); @endphp

    <a href="#" class="logo">
      
      <span class="logo-mini"><b>E</b></span>
      <span class="logo-lg"><b>{{ forcompany() }}</b></span>
    </a>
    
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">{{--Toggle navigation--}}Basculer la navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if((auth()->user()->oauth_provider)== null)
                <img src="{{ setThumbnail(auth()->user()->profile_pic) }}"
                     class="user-image" alt="User Image">
              @else
                <img src="{{ url(auth()->user()->profile_pic) }}"
                     class="user-image" alt="User Image">
              @endif
              {{--<img src="{{ setThumbnail(auth()->user()->profile_pic) }}" class="user-image" alt="User Image">--}}
              <span class="hidden-xs">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }} </span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ setThumbnail(auth()->user()->profile_pic) }}" class="img-circle" alt="User Image">

                <p>
                  {{ str_limit(auth()->user()->firstname,13)}} {{ str_limit(auth()->user()->lastname,7) }} <br>
                 @if(auth()->user()->admin_type == 0){{--Master Admin--}}Admin principal @else {{--Sub Admin--}}Second Admin</p>@endif
                  <small>{{--Member since --}}Membre depuis{{ date_format(auth()->user()->created_at,'M Y') }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('user.index') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat"
                     href="{{ route('logout') }}">
                      {{--Sign out--}}Se Déconnecter
                  </a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    