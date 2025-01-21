@inject('eveentCount','App\Event')
@inject('bookCount','App\Booking')
@inject('fCount','App\Frontuser')
@inject('dataCount','App\Booking')
@inject('eventlist','App\Event')


@extends($AdminTheme)
@section('title','Admin')
@section('content-header')
<h1>
  {{--Dashboard--}}Tableau de bord
  <small>Tout commence par ici</small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
  <li class="active">{{--Dashboard--}}Tableau de bord</li>
</ol>
@endsection
@section('content')
<section class="content">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{--Events--}}Evénements</span>
          <span class="info-box-number">{{ $eveentCount->count() }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-tag"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Réservations</span>
          <span class="info-box-number">{{ $bookCount->CountOrder() }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Utilisateurs</span>
          <span class="info-box-number">
            {{ $fCount->CountAll() }}
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-comments"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{--Feedback--}}Commentaire</span>
          <span class="info-box-number">
            @php
            $countFeedback = DB::table('contacts')->count();
            @endphp
            {{ $countFeedback }}
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

  </div>
</section>
@endsection