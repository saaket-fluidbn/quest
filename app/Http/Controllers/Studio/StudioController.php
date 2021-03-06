<?php

namespace App\Http\Controllers\Studio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Genre;
use App\Studio\StudioStories;
use Image;
class StudioController extends Controller
{
    
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('studio')->except('show');
    }


    
    
    public function dashboard(){
        $genres = Genre::all();
        $selectGenre=[];
        foreach($genres as $g){
            $selectGenre[$g->id] = $g->name;
        }
        $data = [
           'selectGenre'=>$selectGenre,
        ];
        return view('studio.dashboard')->with($data);
    }
    public function store(Request $request){

       

         $title_image = $request->file('title_image');
         $title_img = Image::make($title_image);
         $content = $request->file('content');
         $content_file =  Image::make($content);
         $path= public_path('storage').'/studio_images/';
         $title_img->save($path.time().$title_image->getClientOriginalName());
         $content_file->save($path.time().$content->getClientOriginalName());
         $title_image_name = time().$title_image->getClientOriginalName();
         $content_name = time().$content->getClientOriginalName();
         $story = New StudioStories;
         $story->title = $request->input('title');
         $story->title_image = $title_image_name;
         $story->content = $content_name;
         $story->genre_id = $request->input('genre');
         $story->save();
         return redirect()->back()->with('success','Posted successfully');

    }
    public function show(StudioStories $StudioStories,$slug){
     $data = [
         'StudioStories'=>$StudioStories,
     ];
        return view('studio.show-story')->with($data);
    }
}
