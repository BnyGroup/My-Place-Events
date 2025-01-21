@inject('dataCount','App\Booking')


@extends($theme)
@section('meta_title',setMetaData()->user_account_title)
@section('meta_description',setMetaData()->user_account_desc)
@section('meta_keywords',setMetaData()->user_account_keyword)
@section('content')
<div class="container page-main-contain">
  <div class="row">
    <div class="col-lg col-md col-sm-12">
      <h1 class="profile-title">@lang('words.ac_info_page.ac_pg_tit')</h1>
    </div>
    <div class="col-lg col-md col-sm-12 text-right text-capitalize">
      <p class="accoutn-setting-tag">{{ forcompany() }} @lang('words.ac_info_page.ac_pg_eas') le
        {{ /*date_format($data->created_at,'d, M Y')*/ucwords(Jenssegers\Date\Date::parse($data->created_at)->format('l j F Y')) }}
      </p>
    </div>
  </div>
  <div class="row page-main-contain">
    <div class="col-lg-3 col-sm-12 col-md-3">
      <ul class="list-inline acc-info-menu box-aacoun-info">
        {{--<li><a href=""><i class="fa fa-cog"></i>&nbsp; @lang('words.mng_prfile_tabing.tabl_tit')</a>
			</li>--}}
        <ul class="nav nav-tabs collapse-menus">
          <li><a href="#profile" data-toggle="tab" class="tabs {{ \Request::is('user/profile')?'col-menu-active':'' }}"
              data-url="profile"
              data-hover="@lang('words.mng_prfile_tabing.tabl_tab_1')">@lang('words.mng_prfile_tabing.tabl_tab_1')</a>
          </li>
          <li><a href="#wallet" data-toggle="tab" class="tabs {{ \Request::is('user/wallet')?'col-menu-active':'' }}"
              data-url="wallet"
              data-hover="@lang('words.mng_wallet_tabing.wallet_1')">@lang('words.mng_prfile_tabing.tabl_tab_5')</a>
          </li>
          <li><a href="#bonus" data-toggle="tab" class="tabs {{ \Request::is('user/bonus')?'col-menu-active':'' }}"
              data-url="bonus"
              data-hover="@lang('words.mng_wallet_tabing.wallet_1')">@lang('words.mng_prfile_tabing.tabl_tab_6')</a>
          </li>
          <li><a href="#buzz" data-toggle="tab" class="tabs {{ \Request::is('user/buzz')?'col-menu-active':'' }}"
              data-url="buzz"
              data-hover="@lang('words.mng_prfile_tabing.tabl_tab_2')">@lang('words.mng_prfile_tabing.tabl_tab_2')</a>
          </li>
          {{--<li><a href="#references" data-toggle="tab"  class="tabs {{ \Request::is('user/references')?'col-menu-active':'' }}"
          data-url="references"
          data-hover="@lang('words.mng_prfile_tabing.tabl_tab_3')">@lang('words.mng_prfile_tabing.tabl_tab_3')</a></li>
          <li><a href="#bank" data-toggle="tab" class="tabs {{ \Request::is('user/bank')?'col-menu-active':'' }}"
              data-url="bank" data-hover="@lang('words.mng_prfile_tabing.tabl_tab_4')">Bank Details</a></li>--}}
          <li><a href="#close" data-toggle="tab" class="tabs {{ \Request::is('user/close')?'col-menu-active':'' }}"
              data-url="close"
              data-hover="@lang('words.mng_prfile_tabing.tabl_tab_5')">@lang('words.mng_prfile_tabing.tabl_tab_4')</a>
          </li>
        </ul>
      </ul>
    </div>
    <div class="col-lg-9 col-sm-12 col-md-9">
      <div class="tab-content">
        <!-- tab one-->
        <div role="tabpanel"
          class="tab-pane fade in @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									@if($properties['native'] === 'Français') {{ Request::is('fr/user/profile')?'active':''}} @elseif($properties['native'] === 'English') {{ Request::is('en/user/profile')?'active':''}} @endif @endforeach"
          id="profile">
          <div class="row accumn-info">
            <div class="col-lg-12 col-sm-12 col-md-12">
              <h1 class="profile-title profile-title-text page-header">@lang('words.ac_info_page.ac_pg_hed')</h1>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12">
              <div class="row main-form-contain-acc">
                <div class="col-md-12 col-lg-12 col-sm-12">
                  @if($success = Session::get('success'))
                  <div class="alert alert-success">{{ $success }}</div>
                  @endif
                </div>
                <div class="col-md-12 col-sm-12 col-lg-12">
                  <p class="email-account-title text-capitalize">@lang('words.ac_info_page.ac_pg_emi')</p>
                  <p class="email-contain">{{ $data->email }}</p>
                </div>

                {!! Form::model($data,['route'=>['user.pro.update','id' => $data->id],'method'=>'patch','files' =>
                'true']) !!}
                <div class="col-lg-12 col-sm-12 col-md-12">
                  <br>
                  <label class="label-text">@lang('words.ac_info_page.ac_pg_pro')<span
                      class="text-danger">*</span></label>
                  <div class="form-textbox">
                    <input type="file" name="profile_pic" id="imgInp" style="display: none;" />
                    @if((auth()->guard('frontuser')->user()->oauth_provider)== null)
                    <img src="{{ setThumbnail($data->profile_pic) }}" id="ingOup" class="img-thumbnail"
                      onclick="document.getElementById('imgInp').click();" style="height: 150px;" />
                    @else
                    <img src="{{ url(auth()->guard('frontuser')->user()->profile_pic) }}" id="ingOup"
                      class="img-thumbnail" onclick="document.getElementById('imgInp').click();"
                      style="height: 150px;" />
                    @endif

                  </div>
                  {!! Form::hidden('old_image',$data->profile_pic) !!}
                  @if($errors->has('profile_pic')) <span class="error">{{ $errors->first('profile_pic') }}</span> @endif
                </div>
                <div class="col-lg-12 col-sm-12 col-md-12 contect-form">
                  <p class="email-account-title">@lang('words.ac_info_page.ac_con_1')</p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                      <label class="label-text">@lang('words.ac_info_page.ac_con_2'):<span
                          class="text-danger">*</span></label>
                      {!! Form::text('firstname',$data->firstname,['class'=>'form-control form-textbox']) !!}
                      @if($errors->has('firstname')) <span class="error">{{ $errors->first('firstname') }}</span> @endif
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                      <label class="label-text">@lang('words.ac_info_page.ac_con_3'):<span
                          class="text-danger">*</span></label>
                      {!! Form::text('lastname',$data->lastname,['class'=>'form-control form-textbox']) !!}
                      @if($errors->has('lastname')) <span class="error">{{ $errors->first('lastname') }}</span> @endif
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 form-group">
                      <label class="label-text">@lang('words.ac_info_page.ac_con_4'):</label>
                      <input type="text" class="form-control bfh-phone form-textbox" data-format="dddddddddd"
                        data-number="1234567890"
                        value="{{(Input::old('cellphone'))?Input::old('cellphone'):$data->cellphone}}" name="cellphone">
                      @if($errors->has('cellphone')) <span class="error">{{ $errors->first('cellphone') }}</span> @endif
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                      <label class="label-text">@lang('words.ac_info_page.ac_con_5'):</label>
                      <span style="font-size:12px;letter-spacing:1px;color:#777;"> (eg :
                        "http://www.myplace-events.com")</span>
                      {!! Form::text('website',$data->website,['class'=>'form-control form-textbox']) !!}
                      @if($errors->has('website')) <span class="error">{{ $errors->first('website') }}</span> @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 form-group mb-2">
                      <br>
                      <p class="email-account-title">@lang('words.ac_info_page.ac_con_add')</p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                      <label class="label-text">@lang('words.ac_info_page.ac_coa_1'):<span
                          class="text-danger">*</span></label>
                      {!! Form::textarea('address',$data->address,['class'=>'form-control form-textbox','size'=>'3x5'])
                      !!}
                      @if($errors->has('address')) <span class="error">{{ $errors->first('address') }}</span> @endif
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-6 form-group">
                      <label class="label-text"> @lang('words.ac_info_page.ac_coa_2'):<span
                          class="text-danger">*</span></label>
                      {!! Form::text('city',$data->city,['class'=>'form-control form-textbox']) !!}
                      @if($errors->has('city')) <span class="error">{{ $errors->first('city') }}</span> @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      <label class="label-text"> @lang('words.ac_info_page.ac_coa_3'):</label>
                      <input type="text" class="form-control bfh-phone form-textbox" data-format="dddddd"
                        data-number="1234567890"
                        value="{{(Input::old('postalcode'))?Input::old('postalcode'):$data->postalcode}}"
                        name="postalcode">
                      @if($errors->has('postalcode')) <span class="error">{{ $errors->first('postalcode') }}</span>
                      @endif
                    </div>
                    <div class="col-sm-12 col-lg-6 col-md-6 form-group">
                      <label class="label-text"> @lang('words.ac_info_page.ac_coa_4'):<span
                          class="text-danger">*</span></label>
                      <select id="countries_states1" class="k-state form-control bfh-countries form-textbox"
                        name="country"
                        data-country="{{(Input::old('country'))?Input::old('country'):$data->country}}"></select>
                      @if($errors->has('country')) <span class="error">{{ $errors->first('country') }}</span> @endif
                    </div>
                    <div class="col-sm-12 col-lg-6 col-md-6 form-group">
                      <label class=" label-text"> @lang('words.ac_info_page.ac_coa_5'):<span
                          class="text-danger">*</span></label>
                      <select class="form-control bfh-states form-textbox k-state" data-country="countries_states1"
                        name="state" data-state="{{(Input::old('state'))?Input::old('state'):$data->state}}"></select>
                      @if($errors->has('state')) <span class="error">{{ $errors->first('state') }}</span> @endif
                    </div>
                    <div class="col-md-4 col-sm-12 col-lg-4 form-group">
                      {!! Form::submit(trans('words.ac_info_page.ac_coa_btn'),['class'=>'pro-choose-file
                      text-uppercase']) !!}
                    </div>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel"
          class="tab-pane fade in @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									@if($properties['native'] === 'Français') {{ Request::is('fr/user/wallet')?'active':''}} @elseif($properties['native'] === 'English') {{ Request::is('en/user/wallet')?'active':''}} @endif @endforeach"
          id="wallet">
          <div class="row accumn-info">
            <div class="col-lg-12 col-sm-12 col-md-12">
              <h1 class="profile-title profile-title-text page-header">Mon crédit virtuel</h1>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12">
              <div class="row main-form-contain-acc">
                <div class="col-md-12 col-lg-12 col-sm-12">
                  @if($success = Session::get('success'))
                  <div class="alert alert-success">{{ $success }}</div>
                  @endif
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12 xs-12" style="color: #000;margin-bottom: 30px">
                  <div class="creditBlock">
                    <h5>Solde Wallet</h5>
                    <span class="solde">@if($wallet) {{ number_format($wallet, 0,'', ' ') }} <span
                        class="currency">FCFA</span> @else 0 <span class="currency">FCFA</span> @endif </span>
                    <div class="lastMeta">
                      @if($amountLastTransaction && $dateLastTransaction)
                      <h6 class="Recharge">Dernière opération</h6>
                      <span class="LastSolde">{{ number_format($amountLastTransaction, 0,'', ' ') }} <span
                          class="currency">FCFA</span></span>
                      <span class="lastDate">
                        {{ /*date_format($dateLastTransaction,'d, M Y - H:i')*/ucwords(Jenssegers\Date\Date::parse($dateLastTransaction)->format('l j F Y - H:i')) }}
                      </span>
                      @endif
                      <span class="LastPlace">{{$data->address}}</span>
                      <a href="tel: 07 08 09 82 84" data-tooltip="Appelez: 00 00 00 00 00" data-flow="bottom">Rechargez
                        votre wallet</a>
                    </div>
                  </div>
                </div>
                <div class="ActivityList col-md-8 col-lg-8 col-sm-12 xs-12" style="color: #000">
                  <div class="Activityheader" style="">
                    <img src="http://test.lv-3d.fr/public/default/Activities-Icon.png">
                    <h4>Liste des points et Gadgets</h4>
                  </div>
                  <div class="Activitybody">
                  @if(count($data->transactions) > 0)
                    <ul>
                    @foreach($transactions as $transaction)
                      <li style="font-size:.8rem">
                        <div class="type">
                        @if($transaction->type === "deposit")
                            <span class="type badge-deposit"> + </span>
                        @else
                          <span class="type badge-Withdraw"> - </span>
                        @endif
                        </div>
                        <div class="Date">
                          {{ /*date_format($transaction->created_at,'d, M Y')*/ucwords(Jenssegers\Date\Date::parse($transaction->created_at)->format('l j F Y')) }}
                        </div>
                        <div class="Description "style="margin-right:1rem">
                          {{ $transaction->meta["description"] }}
                        </div>
                        <div class="amount">
                          {{ number_format($transaction->amount, 0,'.', ' ') }} <span class="currency">FCFA</span>
                        </div>

                      </li>
                      @endforeach
                    </ul>
                  @else
                    <p class="text-center" colspan="4">Aucune Transaction ! </p>
                  @endif
                  </div>
                </div>
                <div class="ActivityBottom" style="margin: 0% 0 5% 0;color: #000">
                  <p><strong>MY PLACE WALLET</strong> est le système mis à votre disposition pour faciliter votre
                    processus d'achat de vos bilets, et de passer vos commandes avec plus d’aisance.</p>
                  <p>Plus besoin de rentrer vos données bancaires ou de vos cartes E-monney.</p>
                  <p>Vous pourrez tout simplement rechargez votre compte MY PLACE WALLET dans nos point de rechargement
                    à tout moment.</p>
                  <p>Pour plus de renseignements veuillez nous contacter aux numéros suivants:</p>
                  <p><strong>1- +225 07.47.97.45.05</strong></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel"
          class="tab-pane fade in @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									@if($properties['native'] === 'Français') {{ Request::is('fr/user/bonus')?'active':''}} @elseif($properties['native'] === 'English') {{ Request::is('en/user/bonus')?'active':''}} @endif @endforeach"
          id="bonus">
          <div class="row accumn-info">
            <div class="col-lg-12 col-sm-12 col-md-12">
              <h1 class="profile-title profile-title-text page-header">Mes points bonus</h1>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12">
              <div class="row main-form-contain-acc">
                <div class="col-md-12 col-lg-12 col-sm-12">
                  @if($success = Session::get('success'))
                  <div class="alert alert-success">{{ $success }}</div>
                  @endif
                </div>
                <div class="col-md-4 col-lg-4 col-sm-4 xs-12" style="color: #000">
                  <div class="creditBlock">
                    <h5>Solde Point bonus</h5>
                    <span class="solde">@if($bonus) {{ number_format($bonus, 0,'', ' ') }} <span
                        class="currency">Points</span> @else 0 <span class="currency">Points</span> @endif </span>
                  </div>
                </div>
                <div class="ActivityList col-md-8 col-lg-8 col-sm-8 xs-12" style="color: #000">
                  <div class="Activityheader" style="">
                    <img src="http://test.lv-3d.fr/public/default/Activities-Icon.png">
                    <h4>Liste des points et Gadgets</h4>
                  </div>
                  <div class="Activitybody">
                  @if(count($data->transactions) > 0)
                    <ul>
                    @foreach($transactionsBonus as $transaction)
                      <li style="font-size:.8rem">
                        <div class="Date">
                          {{ /*date_format($transaction->created_at,'d, M Y')*/ucwords(Jenssegers\Date\Date::parse($transaction->created_at)->format('l j F Y')) }}
                        </div>
                        <div class="Description "style="margin-right:1rem">
                          {{ $transaction->meta["description"] }}
                        </div>
                        <div class="type">
                        @if($transaction->type === "deposit")
                            <span class="type badge-deposit"> + </span>
                        @else
                          <span class="type badge-Withdraw"> - </span>
                        @endif
                        </div>
                        <div class="amount">
                          {{ number_format($transaction->amount, 0,'.', ' ') }} <span class="currency">@if($transaction->amount > 1)Points @else Point @endif</span>
                        </div>

                      </li>
                      @endforeach
                    </ul>
                  @else
                    <p class="text-center" colspan="4">Aucune Transaction ! </p>
                  @endif
                  </div>
                </div>
                <div class="ActivityBottom" style="margin: 0% 0 5% 0;color: #000">
                  <p><strong>POINT BONUS </strong> est le système mis en place pour récompenser vos
                    enormes éffort. Pour toutes vos commandes et/ou réservations, sur notre site, vous béneficiez de
                    points cumulables qui vous donnent droit à un rechargement automatique de votre Portefeuille Virtuel.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- tab one-->
        <!-- tab two-->
        <div role="tabpanel"
          class="tab-pane fade @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									@if($properties['native'] === 'Français') {{ Request::is('fr/user/buzz')?'active':''}} @elseif($properties['native'] === 'English') {{ Request::is('en/user/buzz')?'active':''}} @endif @endforeach"
          id="buzz">
          <div class="row accumn-info">
            <div class="col-lg-12 col-sm-12 col-md-12">
              <h1 class="profile-title profile-title-text page-header">@lang('words.ac_pwd_res.ac_res_tit')</h1>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 main-form-contain-acc">
              @if($error = Session::get('error'))
              <div class="alert alert-danger">{{ $error }}</div>
              @endif
              @if($success = Session::get('success'))
              <div class="alert alert-success">{{ $success }}</div>
              @endif
              {!! Form::open(['route'=>'password.pro.update','method' => 'post']) !!}
              @isset(Auth::guard('frontuser')->user()->password)
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                  <label class="label-text">@lang('words.ac_pwd_res.ac_res_cun') :</label>
                  {!! Form::hidden('id',$data->id) !!}
                  {!! Form::password('password',['class'=>'form-control form-textbox','required']) !!}
                  @if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span>@endif
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                  <label class=" label-text">@lang('words.ac_pwd_res.ac_res_new') :</label>
                  {!! Form::password('new_password',['class'=>'form-control form-textbox','required']) !!}
                  @if($errors->has('new_password')) <span
                    class="error">{{ $errors->first('new_password') }}</span>@endif
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                  <label class=" label-text">@lang('words.ac_pwd_res.ac_res_cpw') :</label>
                  {!! Form::password('repeat_new_password',['class'=>'form-control form-textbox','required']) !!}
                  @if($errors->has('repeat_new_password')) <span
                    class="error">{{ $errors->first('repeat_new_password') }}</span>@endif
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-4 form-group">
                  <input type="submit" value="@lang('words.ac_pwd_res.ac_res_btn')"
                    class="pro-choose-file text-uppercase" />
                </div>
              </div>
              @else
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                  <label class="text-uppercase label-text">@lang('words.ac_pwd_res.ac_res_new') :</label>
                  {!! Form::hidden('id',$data->id) !!}
                  {!! Form::password('new_password',['class'=>'form-control form-textbox','required']) !!}
                  @if($errors->has('new_password')) <span
                    class="error">{{ $errors->first('new_password') }}</span>@endif
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-12 form-group">
                  <label class="text-uppercase label-text">@lang('words.ac_pwd_res.ac_res_cpw') :</label>
                  {!! Form::password('repeat_new_password',['class'=>'form-control form-textbox','required']) !!}
                  @if($errors->has('repeat_new_password')) <span
                    class="error">{{ $errors->first('repeat_new_password') }}</span>@endif
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4 col-sm-12 col-md-4 form-group">
                  <input type="submit" value="@lang('words.ac_pwd_res.ac_res_btn')"
                    class="pro-choose-file text-uppercase" />
                </div>
              </div>
              @endisset
              {!! Form::close() !!}
            </div>
          </div>
        </div>
        <!-- tab- two-->
        <!-- tab- three-->
        {{--<div role="tabpanel" class="tab-pane fade {{ Request::is('user/references')?'active':''}}" id="references">
        <div class="row accumn-info">
          <div class="col-lg-12 col-sm-12 col-md-12">
            <h1 class="profile-title profile-title-text page-header">@lang('words.ac_soc_pg.ac_soc_pg')</h1>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 main-form-contain-acc">
            <p>@lang('words.ac_soc_pg.ac_soc_tag') {{ forcompany() }}</p>
            <br>
            <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with"
              data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
          </div>
        </div>
      </div>
      <!-- tab- tree-->
      <!-- tab-four-->
      <div role="tabpanel" class="tab-pane fade {{ Request::is('user/bank')?'active':''}}" id="bank">
        <div class="row accumn-info">
          <div class="col-lg-12 col-sm-12 col-md-12">

            @if($success = Session::get('bank'))
            <div class="alert alert-success">{{ $success }}</div>
            @endif

            @if(!empty($errors->all()))
            <ul class="alert alert-danger">
              @foreach($errors->all() as $er)
              <li>{{ ucfirst(str_replace('-',' ',$er)) }}</li>
              @endforeach
            </ul>
            @endif
            <h3 class="profile-title-text page-header" style="font-weight:bold;">PayPal account used for
              {{ forcompany() }} referral payouts</h3>
            {!! Form::open(['route'=>'upaypal.email','method'=>'post']) !!}
            <div class="row">
              <div class="col-md-8 col-sm-12 col-lg-8">
                <div class="form-group">
                  <label>PayPal Email</label>
                  <input type="email" name="paypal_payment_email" class="form-control form-textbox"
                    placeholder="Paypal Email"
                    value="@if(isset($bd['paypal_payment_email'])){{ $bd['paypal_payment_email'] }}@endif">
                </div>
              </div>
              <div class="col-md-4 col-sm-12 col-lg-4">
                <label>&nbsp;</label>
                <input type="submit" value="Submit" class="btn btn-info form-textbox btn-block">
              </div>
            </div>
            {!! Form::close(); !!}

            <hr />
            <h3 class="profile-title-text page-header" style="font-weight:bold;">Bank Details</h3>

            @if(!$bank->isEmpty())
            {!! Form::open(['route' => 'ubank.details','method' => 'post']) !!}
            <div class="row">
              @foreach($bank as $key => $val)
              @if($val['type'] == 'text')
              <div class="col-md-6 col-sm-12 col-lg-6">
                <div class="form-group">
                  <label>{{ $val->fieldname }}</label> <span style="color:red;margin-left:10px;">{{ $val->note }}</span>
                  <input type="{{$val->type}}" name="{{$val->slug}}" class="form-control form-textbox"
                    placeholder="{{ $val->placeholder }}"
                    value="@if(isset($bd[$val->slug])){{ $bd[$val->slug] }}@endif">
                </div>
              </div>
              @endif

              @if($val['type'] == 'email')
              <div class="col-md-6 col-sm-12 col-lg-6">
                <div class="form-group">
                  <label>{{ $val->fieldname }}</label> <span style="color:red;margin-left:10px;">{{ $val->note }}</span>
                  <input type="{{$val->type}}" name="{{ $val->slug }}" class="form-control form-textbox"
                    placeholder="{{ $val->placeholder }}"
                    value="@if(isset($bd[$val->slug])){{ $bd[$val->slug] }}@endif">
                </div>
              </div>
              @endif

              @if($val['type'] == 'textarea')
              <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="form-group">
                  <label>{{$val->fieldname}}</label> <span style="color:red;margin-left:10px;">{{ $val->note }}</span>
                  <textarea name="{{ $val->slug }}" class="form-control form-textbox"
                    placeholder="{{ $val->placeholder }}">@if(isset($bd[$val->slug])){{ $bd[$val->slug]  }}@endif</textarea>

                </div>
              </div>
              @endif
              @endforeach
              <div class="col-md-12 col-sm-12 col-lg-12">
                <input type="submit" value="Submit" class="btn btn-info form-textbox">
              </div>
            </div>
            {!! Form::close(); !!}
            @endif
          </div>
        </div>
      </div>--}}
      <!--tab four-->
      <!--tabl five -->
      <div role="tabpanel"
        class="tab-pane fade @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									@if($properties['native'] === 'Français') {{ Request::is('fr/user/close')?'active':''}} @elseif($properties['native'] === 'English') {{ Request::is('en/user/close')?'active':''}} @endif @endforeach"
        id="close">
        <div class="row accumn-info">
          <div class="col-lg-12 col-sm-12 col-md-12">
            <h1 class="profile-title profile-title-text page-header">@lang('words.mng_prfile_tabing.tabl_tab_4')</h1>
          </div>
          <div class="col-lg-12 col-sm-12 col-md-12">
            <br>
            <p class="accoutn-setting-tag">@lang('words.ac_clo_ac.ac_clos_tag_1') {{ forcompany() }}.
              @lang('words.ac_clo_ac.ac_clos_tag_2')</p><br>
            <p class="accoutn-setting-tag">@lang('words.ac_clo_ac.ac_clos_pls'):</p>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12">
            @if($error = Session::get('error'))
            <div class="alert alert-danger">{{ $error }}</div>
            @endif
            {!! Form::open(['route' => 'close.account','method'=>'post']) !!}
            {!! Form::hidden('id',$data->id) !!}
            <div class="form-group">
              <input type="radio" name="reason" value="1" class="reason-text" id="label"> <label for="label">
                @lang('words.ac_clo_ac.ac_clos_re_1') </label><br>
              <input type="radio" name="reason" value="2" class="reason-text" id="2"> <label for="2">
                @lang('words.ac_clo_ac.ac_clos_re_2') </label><br>
              <input type="radio" name="reason" value="3" class="reason-text" id="3"> <label for="3">
                @lang('words.ac_clo_ac.ac_clos_re_3') </label><br>
              <input type="radio" name="reason" value="4" class="reason-text" id="4"> <label for="4">
                @lang('words.ac_clo_ac.ac_clos_re_4') </label> <br>
              <input type="radio" name="reason" value="5" class="reason-text" id="5"> <label for="5">
                @lang('words.ac_clo_ac.ac_clos_re_5') </label> <br>
              <input type="radio" name="reason" value="6" class="reason-text" id="6"> <label for="6">
                @lang('words.ac_clo_ac.ac_clos_re_6')</label><br>
              <input type="radio" name="reason" value="7" class="reason-text" id="7"> <label for="7">
                @lang('words.ac_clo_ac.ac_clos_re_7') {{ forcompany() }}</label> <br>
              <input type="radio" name="reason" value="8" class="reason-text" id="select-id"> <label for="select-id">
                @lang('words.ac_clo_ac.ac_clos_re_8')</label><br>
              @if($errors->has('reason')) <span class="error">{{ $errors->first('reason') }}</span>@endif
            </div>
            <div class="form-group hides-text" style="display: none;">
              <input type="text" name="other_reason" class="form-control form-textbox"
                placeholder="@lang('words.ac_clo_ac.ac_clos_re_p')" />
              @if($errors->has('other_reason')) <span class="error">{{ $errors->first('other_reason') }}</span>@endif
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12">
            <p class="accoutn-setting-tag"><span class="error"></span> @lang('words.ac_clo_ac.ac_clos_r_p1')</p>
            <div class="form-group">
              <input type="password" name="password" class="form-control form-textbox"
                placeholder="@lang('words.ac_clo_ac.ac_clos_r_p2')" required />
              @if($errors->has('password')) <span class="error">{{ $errors->first('password') }}</span>@endif
            </div>
          </div>
          <div class="col-md-4 col-ms-12 col-lg-4">
            <input type="submit" value="@lang('words.ac_clo_ac.ac_clos_r_p3')" class="pro-choose-file text-uppercase" />
            {!! Form::close() !!}
          </div>
        </div>
      </div>


      <!-- @foreach($errors->all() as $er)
						{{ $er }}
					@endforeach -->


      <!--tabl five -->
    </div>
  </div>
</div>
</div>
@endsection