@extends( $AdminTheme )
@section( 'title', 'Détails Langue' )
@section( 'content-header' )
	<h1>Langues & Traductions</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Accueil</a>
		</li>
		<li class="active">Langues & Traductions</li>
	</ol>
@endsection

@section( 'content' )
<style>
.content-title-icon {
    flex-shrink: 0;
    height: 2.75rem;
    padding-top: 0.25rem;
    width: 2.75rem;
	margin-top: 24px;
}
	
@media (min-width: 768px){
	.md\:justify-between {
		justify-content: space-between;
	}
}
@media (min-width: 768px){
	.md\:items-center {
		align-items: center;
	}
}
@media (min-width: 768px){
	.md\:flex {
		display: flex;
	}	
}
.btn.btn-app, .btn.btn-app:not(:disabled):hover {
    background-color: rgb(21 94 117/1);
}
.btn.btn-app {
    --tw-bg-opacity: 1;
    --tw-text-opacity: 1;
    color: rgb(255 255 255/1);
}	
.btn {
    --tw-shadow: 0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px -1px rgba(0,0,0,.1);
    --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color),0 1px 2px -1px var(--tw-shadow-color);
	--tw-ring-offset-shadow: 0 0 #0000;
    --tw-ring-shadow: 0 0 #0000;	
    border-color: transparent;
    border-radius: 0.375rem;
    border-width: 1px;
    box-shadow: var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);
    font-weight: 600;
    line-height: 1.25rem;
    padding: 0.75rem 1rem;
	height: auto !important
}	
</style>
<div class="my-6 max-w-1/6 mx-auto px-4 sm:px-6 lg:px-8">
	<div class="md:flex md:items-center md:justify-between">
		<div class="flex min-w-0">
			<svg aria-hidden="true" data-prefix="far" data-icon="edit" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="content-title-icon svg-inline--fa fa-edit fa-w-18">
				<path fill="currentColor" d="m402.3 344.9 32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174 402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path>
			</svg>
			<h1 class="content-title" style="margin-left: 10px;">
            Editer langue <b><?php echo "(".$lang.")"; ?></b>
            <small>(<?php echo $nb; ?>)</small></h1>
		</div>
		<div class="mt-4 flex md:mt-0 md:ml-4"><a href="{{ route('langues.list') }}" class="btn btn-app router-link-active">
              Retour
            </a>
		</div>
	</div>
</div>
 
<style>
	.listlang {
		border-radius: 0.5rem;
		border: 1px solid #e5e7eb;
		box-sizing: border-box;
		list-style: none;
		padding-left: 0px;
		background-color: #FFFFFF
	}
	
	.listlang li {
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

<form action="{{ route('langue.store') }}" method="post" style="border-radius: 8px; border:2px solid #155e75; padding: 15px; background-color: #FFFFFF">
<input type="hidden" name="lang" value="<?php echo $lang; ?>">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<?php
// echo"<pre>"; print_r($translations);echo"</pre>"; 
foreach($translations as $key => $item){
	//echo"<pre>".$key;print_r($item);echo"</pre>"; die("--");
	
	if(is_array($item)){
	$key=substr($key, 1, -1); 
?>	<h4 style="text-transform: uppercase; margin: 15px 0 30px 0; padding: 10px 0; border-bottom: 1px solid #000"><?php echo "<b>".$key."</b>"; ?></h4>
	
	<?php
		$b="";
		foreach($item as $k => $subitem){
		$k=substr($k, 1, -1); 
		$subitem=substr(trim($subitem), 1, -2); 
			
			//$st = array_search($k, $translations_main);	
			foreach($translations_main as $ekey => $value) {
				$ekey=substr($ekey, 1, -1); 


				if($ekey==$key){
 
						foreach($value as $ekeys => $vals) {  
														
							if($ekeys=="'$k'"){							
								$ekeys=substr($ekeys, 1, -1); 
								$vals=substr(trim($vals), 1, -2); 
								$b=$vals;
								if(empty($b)){
									$b=$ekeys;
								}
							}	
						
						}

				}
			}	
	?>
	<h4><?php echo $b.' '; ?></h4>
	<input type="text" name="<?php echo $key.'['.$k.']'; ?>" style="border:1px solid #155e75; width: 100%; padding: 10px; border-radius: 10px; font-size: 13px" value="<?php echo stripslashes($subitem); ?>">
	<?php } ?>
	
<?php	
	}else{
	$key=substr($key, 1, -1); 
	$item=substr(trim($item), 1, -2); 
	?>
	<h4><?php echo $key.' '; ?></h4>
	<input type="text" name="<?php echo $key; ?>" style="border:1px solid #155e75; width: 100%; padding: 10px; border-radius: 10px; font-size: 13px" value="<?php echo stripslashes(trim($item)); ?>">
	<?php	
	}
	
}
?>
	<div style="padding: 15px 0 15px 0; text-align: right"><input style="padding: 15px;" type="submit" value="Mettre &agrave; jour" class="btn btn-app"></div>
</form>






@endsection