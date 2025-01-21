@extends($AdminTheme)
@section('title','A la Une')
@section('content-header')
    <h1>Langues & Traductions</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Accueil</a></li>
        <li class="active">Langues & Traductions</li>
    </ol>
@endsection

@section('content')


<?php /*?><pre><?
print_r($data);
?></pre><?php */?>
<style>
.listlang{
	border-radius: 0.5rem;
	border: 1px solid #e5e7eb;
	box-sizing: border-box;
	list-style: none;
	padding-left: 0px;
	background-color: #FFFFFF
}
.listlang li{
	border-bottom: 1px solid #e5e7eb;
		padding-left: 40px;
}
.flex {
    display: flex;
}
.w-5 {
    width: 1.25rem;
}
.h-5 {
    height: 2.25rem;
}
.py-4 {
    padding-bottom: 1rem;
    padding-top: 1rem;
}
.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}
.items-center {
    align-items: center;
}
.flex-1 {
    flex: 1 1 0%;
}
.min-w-0 {
    min-width: 0;
}
.leading-5 {
    line-height: 1.25rem;
}
.font-medium {
    font-weight: 500;
}
.text-sm {
    font-size: 1.875rem;
    line-height: 2.25rem;
}

.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}	
</style>
<ul class="listlang">
	<?php foreach($data as $key => $item){ //print_r($key); ?>
	<li class="">
		<a href="{{ route('langue.details',$key) }}" class="block hover:bg-gray-50 focus:outline-none focus:bg-blue-100 transition duration-150 ease-in-out">
			<div class="flex items-center px-4 py-4 sm:px-6">
				<div class="min-w-0 flex-1 flex items-center">
					<div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
						<div>
							<div class="text-sm leading-5 font-medium text-blue-600 truncate">
								<?php echo $item['native'] ?>
							</div>
						</div>
					</div>
				</div>
				<div>
					<svg aria-hidden="true" data-prefix="far" data-icon="angle-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="h-5 w-5 text-gray-400 svg-inline--fa fa-angle-right fa-w-6">
						<path fill="currentColor" d="M187.8 264.5 41 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 392.7c-4.7-4.7-4.7-12.3 0-17L122.7 256 4.2 136.3c-4.7-4.7-4.7-12.3 0-17L24 99.5c4.7-4.7 12.3-4.7 17 0l146.8 148c4.7 4.7 4.7 12.3 0 17z"></path>
					</svg>
				</div>
			</div>
		</a>
	</li>
	<?php } ?>
</ul>





@endsection