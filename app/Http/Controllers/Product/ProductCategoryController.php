<?php

namespace App\Http\Controllers\Product;

use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use App\Product\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin-check');
		view()->share('AdminTheme','AdminTheme.master');
       /* $this->middleware('permission:product-category-list|product-category-create|product-category-edit|product-category-delete', ['only', ['index']]);
        $this->middleware('permission:product-category-create', ['only', ['store']]);
        $this->middleware('permission:product-category-edit', ['only', ['update']]);
        $this->middleware('permission:product-category-delete', ['only', ['destroy', 'bulk_action']]);*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_category = ProductCategory::all();
        return view('Admin.products.category.all')->with(['all_category' => $all_category] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string|max:191|unique:product_categories',
            'status' => 'required|string|max:191',
            'image' => 'nullable|string|max:191',
        ]);

        $product_category = ProductCategory::create([
            'title' => $request->title,
            'status' => $request->status,
            'image' => $request->image,
        ]);

        return $product_category->id
            ? back()->with(FlashMsg::create_succeed(__('Catégorie de produit enregistrée avec succès!')))
            : back()->with(FlashMsg::create_failed(__('Echec lors de l\'enregistrement de la Catégorie de produit')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'image' => 'nullable|string|max:191',
        ]);

        $updated = ProductCategory::find($request->id)->update([
            'title' => $request->title,
            'status' => $request->status,
            'image' => $request->image,
        ]);

        return $updated
            ? back()->with(FlashMsg::update_succeed(__('Mise à jour de la Catégorie de produit avec succès!!')))
            : back()->with(FlashMsg::update_failed(__('Echec lors de la mise à jour de la Catégorie de produit')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $item)
    {
         $item->delete();
		 return back()->with(FlashMsg::update_succeed(__('Catégorie supprimée avec succès')));
    }

    public function bulk_action(Request $request){
        ProductCategory::WhereIn('id', $request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }
}
