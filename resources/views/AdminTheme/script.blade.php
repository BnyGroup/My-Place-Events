<script type="text/javascript" src="{{ asset('/js/jquery.1.11.1.min.js')}}"></script>
<!-- jQuery 3 -->

<script src="{{ asset('/AdminTheme/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('/AdminTheme/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Bootbox -->
<script src="{{ asset('/AdminTheme/dist/js/bootbox.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('/AdminTheme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/AdminTheme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('/AdminTheme/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/AdminTheme/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/AdminTheme/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/AdminTheme/dist/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-formhelpers.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-select.min.js') }}"></script>

<!-- Custome Js -->
<script type="text/javascript" src="{{ asset('/editor/summernote.js')}}"></script>
<script type="text/javascript" src="{{ asset('/AdminTheme/custom.js')}}"></script>
<script src="{{ asset('/AdminTheme/dist/js/form.js') }}"></script>
<script src="{{ asset('/AdminTheme/dist/js/crud.js') }}"></script>
<Script type="text/javascript" src="{{asset('/js/sweetalert.min.js')}}"></Script>
<script type="text/javascript" src="{{ asset('/js/pagedelete.js') }}"></script>
<script src="{{ asset('/AdminTheme/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ asset('/AdminTheme/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="{{ asset('/js/googlemap.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvbP7wv-LlL3_k_erEoCI7WVgTmkr8oLY&libraries=places&callback=initAutocomplete" async defer></script>
<script>
  	$(document).ready(function () {
    	$('.sidebar-menu').tree()

	    $('.datatable').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : true,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : true
	    })
	})
	
$('.datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      orientation: "bottom auto",
})



$(document).ready(function () {

	    $('.tabels-datas').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : true,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true
	    })

	    $('.my-csutom').DataTable({
			'paging'      : true,
			'lengthChange': true,
			'searching'   : true,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : true
	    })

	    $('.out-orrder').DataTable({
			'paging'      : true,
			'lengthChange': true,
			'searching'   : true,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true
	    })
	})

$('#currency').change(function(){
	var curncy = $(this).val()
	console.log($("#currencySymobl").find(curncy).val());
	//$("#currencySymobl").find(curncy).attr("selected", "selected")
	//$('#currencySymobl').find('option:selected').text()
	//$("option:selected", this).val()
});


</script>