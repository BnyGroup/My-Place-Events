<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'name', 'slug', 'value','note',
    ];

      /*============================ API DATA ==========================*/
    public function getSettings()
    {
        $data = static::get()->toArray();
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value['slug']] = $value;
        }
        return $result;
    }

    public function updateSettings($input)
    {
        foreach ($input as $key=>$value){
           static::where('slug',$key)->update(array('value'=>$value));  
        }
        return;
    }
    
    // public function faqtitle()
    // {
    //     $title = static::select('value')
    //     ->where('slug','faqs-page-title')
    //     ->first();
    //     return $title['value'];
    // }    
    // public function faqContent()
    // {
    //    $content =  static::select('value')
    //     ->where('slug','faqs-page-content')
    //     ->first();

    //     return $content['value'];
    // }

    // public function privacytitle()
    // {
    //     $title = static::select('value')
    //     ->where('slug','privacy-page-title')
    //     ->first();
    //     return $title['value'];
    // }    
    // public function privacyContent()
    // {
    //    $content =  static::select('value')
    //     ->where('slug','privacy-page-content')
    //     ->first();
        
    //     return $content['value'];
    // }

    // public function termstitle()
    // {
    //     $title = static::select('value')
    //     ->where('slug','terms-page-title')
    //     ->first();
    //     return $title['value'];
    // }    
    // public function termsContent()
    // {
    //    $content =  static::select('value')
    //     ->where('slug','terms-page-content')
    //     ->first();
        
    //     return $content['value'];
    // }
      /*============================ API DATA ==========================*/
    
}
