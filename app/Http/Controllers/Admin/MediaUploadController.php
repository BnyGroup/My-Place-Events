<?php

namespace App\Http\Controllers\Admin;

use App\MediaUpload;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class MediaUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin-check');
    }

    public function upload_media_file(Request $request)
    {
        $this->validate($request,[
            'file' => 'nullable|mimes:jpg,jpeg,png,gif|max:11000'
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file;
            $image_dimension = getimagesize($image);
            $image_width = $image_dimension[0];
            $image_height = $image_dimension[1];
            $image_dimension_for_db = $image_width . ' x ' . $image_height . ' pixels';
            $image_size_for_db = $image->getSize();

            $image_extenstion = $image->getClientOriginalExtension();
            $image_name_with_ext = $image->getClientOriginalName();

            $image_name = pathinfo($image_name_with_ext, PATHINFO_FILENAME);
            $image_name = strtolower(Str::slug($image_name));

            $image_db = $image_name . time() . '.' . $image_extenstion;
            $image_grid = 'grid-' . $image_db;
            $image_large = 'large-' . $image_db;
            $image_thumb = 'thumb-' . $image_db;
            $image_p_grid = 'product-' . $image_db;

            $folder_path = 'public/assets/uploads/media-uploader/';
            $resize_large_image = Image::make($image)->resize(740, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_grid_image = Image::make($image)->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_p_grid_image = Image::make($image)->resize(230, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_thumb_image = Image::make($image)->resize(250, 250);

            $request->file->move($folder_path, $image_db);

            MediaUpload::create([
                'title' => $image_name_with_ext,
                'size' => formatBytes($image_size_for_db),
                'path' => $image_db,
                'dimensions' => $image_dimension_for_db,
                'user_id' => $request->user_id
            ]);

            if ($image_width > 250) {
                $resize_thumb_image->save($folder_path . $image_thumb);
                $resize_grid_image->save($folder_path . $image_grid);
                $resize_large_image->save($folder_path . $image_large);
                $resize_p_grid_image->save($folder_path . $image_p_grid);
            }
        }
    }

    public function all_upload_media_file(Request $request)
    {
        $all_images = MediaUpload::orderBy('id', 'DESC')->take(20)->get();
        $selected_image = MediaUpload::find($request->selected);
		 

        $all_image_files = [];
        if (!empty($selected_image)){
            if (file_exists(public_path('/assets/uploads/media-uploader/'.$selected_image->path))) {

                $image_url = asset('/assets/uploads/media-uploader/' . $selected_image->path);
                if (file_exists(public_path('/assets/uploads/media-uploader/grid-' . $selected_image->path))) {
                    $image_url = asset('/assets/uploads/media-uploader/grid-' . $selected_image->path);
                }

                $all_image_files[] = [
                    'image_id' => $selected_image->id,
                    'title' => $selected_image->title,
                    'dimensions' => $selected_image->dimensions,
                    'alt' => $selected_image->alt,
                    'size' => $selected_image->size,
                    'path' => $selected_image->path,
                    'img_url' => $image_url,
                    'upload_at' => date_format($selected_image->created_at, 'd M y')
                ];
            }

        }
        foreach ($all_images as $image){
            if (file_exists(public_path('/assets/uploads/media-uploader/'.$image->path))){
                $image_url = asset('/assets/uploads/media-uploader/'.$image->path);
                if (file_exists(public_path('/assets/uploads/media-uploader/grid-' . $image->path))) {
                    $image_url = asset('/assets/uploads/media-uploader/grid-' . $image->path);
                }
                $all_image_files[] = [
                    'image_id' => $image->id,
                    'title' => $image->title,
                    'dimensions' => $image->dimensions,
                    'alt' => $image->alt,
                    'size' => $image->size,
                    'path' => $image->path,
                    'img_url' => $image_url,
                    'upload_at' => date_format($image->created_at, 'd M y')
                ];

            }
        }

        return response()->json($all_image_files);
    }

    public function delete_upload_media_file(Request $request)
    {
        $get_image_details = MediaUpload::find($request->img_id);
        if (file_exists(public_path('/assets/uploads/media-uploader/'.$get_image_details->path))){
            unlink(public_path('/assets/uploads/media-uploader/'.$get_image_details->path));
        }
        if (file_exists(public_path('/assets/uploads/media-uploader/grid-'.$get_image_details->path))){
            unlink(public_path('/assets/uploads/media-uploader/grid-'.$get_image_details->path));
        }
        if (file_exists(public_path('/assets/uploads/media-uploader/large-'.$get_image_details->path))){
            unlink(public_path('/assets/uploads/media-uploader/large-'.$get_image_details->path));
        }
        if (file_exists(public_path('/assets/uploads/media-uploader/thumb-'.$get_image_details->path))){
            unlink(public_path('/assets/uploads/media-uploader/thumb-'.$get_image_details->path));
        }
        if (file_exists(public_path('/assets/uploads/media-uploader/product-'.$get_image_details->path))){
            unlink(public_path('/assets/uploads/media-uploader/product-'.$get_image_details->path));
        }
        MediaUpload::find($request->img_id)->delete();

        return redirect()->back();
    }

    public function regenerate_media_images(){
        $all_media_file = MediaUpload::all();
        foreach ($all_media_file as $img){

            if (!file_exists(public_path('/assets/uploads/media-uploader/'.$img->path))){
                continue;
            }
            $image = '/assets/uploads/media-uploader/'. $img->path;
            $image_dimension = getimagesize($image);;
            $image_width = $image_dimension[0];
            $image_height = $image_dimension[1];

            $image_db = $img->path;
            $image_grid = 'grid-'.$image_db ;
            $image_large = 'large-'. $image_db;
            $image_thumb = 'thumb-'. $image_db;

            $folder_path = '/assets/uploads/media-uploader/';
            $resize_grid_image = Image::make($image)->resize(350, null,function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_large_image = Image::make($image)->resize(740, null,function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_thumb_image = Image::make($image)->resize(150, 150);

            if ($image_width > 150){
                $resize_thumb_image->save($folder_path . $image_thumb);
                $resize_grid_image->save($folder_path . $image_grid);
                $resize_large_image->save($folder_path . $image_large);
            }

        }
        return 'regenerate done';
    }

    public function alt_change_upload_media_file(Request $request){
        $this->validate($request,[
            'imgid' => 'required',
            'alt' => 'nullable',
        ]);
        MediaUpload::where('id',$request->imgid)->update(['alt' => $request->alt]);
        return 'alt update done';
    }

    public function all_upload_media_images_for_page(){
        $all_media_images = MediaUpload::orderBy('id','desc')->get();

        return view('backend.media-images.media-images')->with(['all_media_images' => $all_media_images]);
    }

    public function get_image_for_loadmore(Request $request){
        $all_images = MediaUpload::orderBy('id', 'DESC')->skip($request->skip)->take(20)->get();

        $all_image_files = [];
        foreach ($all_images as $image){
            if (file_exists(public_path('/assets/uploads/media-uploader/'.$image->path))){
                $image_url = asset('/assets/uploads/media-uploader/'.$image->path);
                if (file_exists(public_path('/assets/uploads/media-uploader/grid-' . $image->path))) {
                    $image_url = asset('/assets/uploads/media-uploader/grid-' . $image->path);
                }
                $all_image_files[] = [
                    'image_id' => $image->id,
                    'title' => $image->title,
                    'dimensions' => $image->dimensions,
                    'alt' => $image->alt,
                    'size' => $image->size,
                    'path' => $image->path,
                    'img_url' => $image_url,
                    'upload_at' => date_format($image->created_at, 'd M y')
                ];

            }
        }

        return response()->json($all_image_files);
    }
}
