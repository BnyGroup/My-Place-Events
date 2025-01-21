<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Page;
use App\Menu;
class MenuController extends AdminController
{
     public function __construct()
    {
        parent::__construct();
        $this->menu = new Menu;
    }
    
    public function index()
    {       
        $data           = Page::get();
        $menu_fotaer    = Menu::where('menu_type','footer')->pluck('menu_link','menu_link')->all();
        $menu_fooder    = Menu::where('menu_type','footer')->get()->toArray();
        $mford = array();
        foreach ($menu_fooder as $key => $value) {
            $mford[$value['menu_link']] = $value['menu_order'];
        }
        return view('Admin.menus.index ',compact('data','menu_fotaer','mford'));
    }

    public function store($slug, Request $request)
    {
        $input = $request->all();        
        $input['order'] = isset($input['order'])? $input['order'] : '' ;
        if(!empty($input)){
            if ($slug == 'footer') {
                    $data = Menu::where('menu_type','footer')->delete();
                    $msg = 'Footer';
                    if (empty($input['page'])) {
                        return redirect()->back()->with(['success' => 'Header Menu Settings Updated.']);
                    }
            }
        }

        foreach ($input['page'] as $key => $value) {
            $parentPage = isset($input['parent_page'][$key])?$input['parent_page'][$key]:0;
            $data = [];
            $data['menu_type'] = $slug;
            $data['menu_link'] = $value;
            $data['menu_order'] = $input['order'][$key];
            $this->menu->createData($data);
        }
        return redirect()->back()->with(['success' => 'Footer Menu Settings Updated.']);
    }
}
