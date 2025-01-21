<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Http\Controllers\Admin\AdminController;
use App\Setting;


class LanguesController extends AdminController
{
	public function __construct() {
    	parent::__construct();
    	$this->settings = new Setting;
    }
    
    public function index()
	{
		$data = \LaravelLocalization::getSupportedLocales();              
		return view('Admin.langues.index',compact('data'));
	}
	public function details($lang)
	{
		 if (!file_exists(base_path() . '/resources/lang/' . $lang . '/words.php')) {
            return response()->json(
                ['message' => __('No translations found for the selected language')],
                500
            );
        }
        $translations = [];		
        $translations_main = [];		
		$x=0; 
		
		$file_handle = fopen(base_path() . '/resources/lang/' . $lang. '/words.php', "rb");		
		$file_handle_main = fopen(base_path() . '/resources/lang/en/words.php', "rb");

		while (!feof($file_handle) ) {

		$line_of_text = fgets($file_handle); 
		$parts = explode('=>', $line_of_text); 

 			if(count($parts)>1){
				$p1=trim($parts[0]);
				$p2=trim($parts[1]);
				$head="";
				
				if($p2=='['){
					$head=$p1; //echo "HEAD: ".$head."---<br>";
					$_SESSION['head']=$head;
				}else{
					
					if(!isset($_SESSION['head'])){
						$translations[$p1]=$p2;	 $x++;
					}else{
						$head=$_SESSION['head']; 
						///echo $p1.'---'.$p2.'<br>';
						$translations[$head][$p1]=$p2;	$x++;
					}
				}
				
			}else if(trim($line_of_text)=="],"){
				unset($_SESSION['head']);
			}	

		}
		
		unset($_SESSION['head']);
		fclose($file_handle);
		 
		
		while (!feof($file_handle_main) ) {

		$line_of_text2 = fgets($file_handle_main);
		$parts = explode('=>', $line_of_text2); 


			if(count($parts)>1){
				$p1=trim(substr($parts[0], 1, -1));
				$p2=trim(substr($parts[1], 1, -1));
				$heads="";
				
				if($p2=='['){
					$heads=$p1; //echo "HEAD: ".$head."---<br>";
					$_SESSION['heads']=$heads;
				}else{
					$heads=$_SESSION['heads'];
					///echo $p1.'---'.$p2.'<br>';
					$translations_main[$heads][$p1]=$p2;						
				}
				
			}

		}
		
		unset($_SESSION['heads']);
		fclose($file_handle_main);
 
		/*
        foreach ($files as $key => $value) {
            $translations[] = ['key' => $key, 'value' => $value];
        }*/  
		$nb=$x;
		return view('Admin.langues.details',compact('lang','translations','translations_main','nb'));
	}
	 
	public function store(Request $request)
	{	
		$input = $request->all();
		$lang=$request->lang;
		
		$file_handle = base_path().'/resources/lang/'.$lang.'/words.php';
		$fileName = base_path().'/resources/lang/'.$lang.'/'.$lang.'_backup_'.gmdate("Y_m_d_his").'.php'; 
		copy($file_handle, $fileName);
		
		
$files="<?php

return [

";
		//print_r($_POST); die('--');
		foreach($_POST as $key=>$value)
		{	
			
			if($key!='lang' && $key!='_token'){
				
				if(is_array($value)){
					$files.="	\n'".addslashes($key)."' => [\n";

					if(count($value)>=1){
						foreach($value as $ekey => $val) {

								$files.="		'$ekey' => '".addslashes($val)."',\n";					 

						}	
					}	

					$files.="	],\n\n";
				}else{
					$files.=" '$key' => '".addslashes($value)."',\n";	
				}
			}
		}	
		
$files.="\n
];";
		 
		$myfile = fopen($file_handle, "w") or die("Impossible d'ouvrir le fichier!");
		fwrite($myfile, $files);
		fclose($myfile);
 
		return redirect()->back()->with('success','Langues mises à jour avec succès.');
	}
}
