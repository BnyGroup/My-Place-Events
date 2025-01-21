<?php

namespace App\Http\Controllers\Product;

use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use App\Product\Product;
use Illuminate\Http\Request;

class DeletedProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin-check');
		view()->share('AdminTheme','AdminTheme.master');
       /*$this->middleware('permission:deleted-product-list|deleted-product-restore|deleted-product-delete', ['only', ['index']]);
        $this->middleware('permission:deleted-product-restore', ['only', ['restore']]);
        $this->middleware('permission:deleted-product-delete', ['only', ['destroy', 'bulk_action']]);*/
    }

    public function index()
    {
        $all_deleted_products = Product::onlyTrashed()->with('category')->get();
        return view('Admin.products.deleted.all', compact('all_deleted_products'));
    }

    public function restore($item)
    {
        $product = Product::withTrashed()->where('id', $item)->first();
        if ($product) {
            return $product->restore();
        }
        return json_encode('ok');
		//return back()->with(FlashMsg::create_succeed('Produit restauré avec succès!'));
    }

    public function destroy($item)
    {
        $product = Product::withTrashed()->where('id', $item)->first();
        if ($product) {
            return $product->forceDelete();
        }
        return back()->with(FlashMsg::create_succeed('Produit supprimé avec succès!'));
    }

    public function bulk_action(Request $request)
    {
        $all_products = Product::whereIn('id', $request->ids)->delete();
        return 'ok';
    }
}
