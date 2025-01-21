<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-toggle.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-datetimepicker.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-formhelpers.min.css')}}" />

<link rel="shortcut icon"  type="image/x-icon" href="{{asset('/img/'.siteSetting()->favilogo)}}"/>
<!-- Latest compiled and minified CSS -->

<link rel="stylesheet" type="text/css" href="{{ asset('/font-awesome/css/font-awesome.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/editor/summernote-lite.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/sweetalert.css')}}" />

<link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/dharmesh.css')}}" />

<link rel="stylesheet" type="text/css" href="{{ asset('/css/themify-icons.css')}}" />
<script src="https://kit.fontawesome.com/570bc6ce92.js" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css?ver=4.9.10" />

<link rel="stylesheet" type="text/css" href="{{ asset('/css/mdtimepicker.css')}}" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/css/lightgallery.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/fh-3.1.6/datatables.min.css"/>

<style type="text/css">
 /* The switch - the box around the slider */
.chked_togal_switch {
  position: relative;
  display: inline-block;
  width: 200px;
  height: 34px;
}

/* Hide default HTML checkbox */
.chked_togal_switch input {display:none;}

/* The slider */
.mrgn-pbls
{
margin-top: -40px !important;
margin-left: 70px;
}
.chked_active_togal {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
}

.chked_active_togal:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .chked_active_togal {
  background-color: #2ab934;
}

input:focus + .chked_active_togal {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .chked_active_togal:before {
  -webkit-transform: translateX(167px);
  -ms-transform: translateX(167px);
  transform: translateX(167px);
}

/* Rounded active_togal */
.chked_active_togal.round {
   border-radius: 34px;
}

.chked_active_togal.round:before {
  border-radius: 50%;
}
.chk-on
{
  display: none;
}

.chk-on, .chk-off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 15px;
  font-weight: bold;
  font-family: Verdana, sans-serif;
}

input:checked+ .chked_active_togal .chk-on
{display: block;}

input:checked + .chked_active_togal .chk-off
{display: none;}

</style>
<style>
    .widget-visible {
        bottom: 30px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/custom_2.css?v1')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.gmaps.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.mmenu.all.css')}}" />