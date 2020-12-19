<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;
use App\Country;

class PostsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:posts-read')->only('index' , 'show');
        $this->middleware('permission:posts-create')->only('create' , 'store');
        $this->middleware('permission:posts-update')->only('edit' , 'update');
        $this->middleware('permission:posts-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:posts-restore')->only('restore');
    }


    public function index()
    {

        $countries = Country::all();

        $posts = Post::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->paginate(5);

        return view('dashboard.posts.index')->with('posts' , $posts)->with('countries' , $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.posts.create')->with('countries' , $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([

            'name_ar' => "required|string|max:255|unique:posts",
            'name_en' => "required|string|max:255|unique:posts",
            'image' => "required|image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'country' => "required",


            ]);


            $post = post::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'image' => $request['image']->store('images/posts', 'public'),
                'country_id' => $request['country'],


            ]);


            session()->flash('success' , 'post created successfully');

            return redirect()->route('posts.index' , app()->getLocale());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , $post)
    {
        $countries = Country::all();
        $post = post::find($post);
        return view('dashboard.posts.edit ')->with('post', $post)->with('countries' , $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, post $post)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:posts,name_ar," .$post->id,
            'name_en' => "required|string|max:255|unique:posts,name_en," .$post->id,
            'image' => "image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'country' => "required",



            ]);

            if($request->hasFile('image')){

                \Storage::disk('public')->delete($post->image);
                $post->update([
                    'image' => $request['image']->store('images/posts', 'public'),
                ]);
            }



            $post->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'country_id' => $request['country'],


            ]);







            session()->flash('success' , 'post updated successfully');

            return redirect()->route('posts.index' , app()->getLocale());



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $post)
    {

        $post = post::withTrashed()->where('id' , $post)->first();

        if($post->trashed()){

            if(auth()->user()->hasPermission('posts-delete')){
                $post->forceDelete();

                session()->flash('success' , 'post Deleted successfully');

                $posts = post::onlyTrashed()
                ->whenSearch(request()->search)
                ->whenCountry(request()->country_id)
                ->paginate(5);

                return view('dashboard.posts.index' , ['posts' => $posts]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $posts = post::onlyTrashed()
                ->whenSearch(request()->search)
                ->whenCountry(request()->country_id)
                ->paginate(5);

                return view('dashboard.posts.index' , ['posts' => $posts]);
            }



        }else{

            if(auth()->user()->hasPermission('posts-trash')){
                $post->delete();

                session()->flash('success' , 'post trashed successfully');

                return redirect()->route('posts.index' , app()->getLocale());

            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                return redirect()->route('posts.index' , app()->getLocale());

            }

        }


    }


    public function trashed()
    {

        $posts = post::onlyTrashed()
        ->whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->paginate(5);
        return view('dashboard.posts.index' , ['posts' => $posts]);

    }

    public function restore( $lang , $post)
    {

        $post = post::withTrashed()->where('id' , $post)->first()->restore();

        session()->flash('success' , 'post restored successfully');

        return redirect()->route('posts.index' , app()->getLocale());

    }
}
