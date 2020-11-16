<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;

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
        $posts = Post::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.posts.index')->with('posts' , $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create');
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

            ]);


            $post = post::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'image' => $request['image']->store('images/posts', 'public')

            ]);


            session()->flash('success' , 'post created successfully');


            $posts = post::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.posts.index')->with('posts' , $posts);
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
        $post = post::find($post);
        return view('dashboard.posts.edit ')->with('post', $post);
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

            ]);







            session()->flash('success' , 'post updated successfully');

            $posts = post::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.posts.index')->with('posts' , $posts);


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

                $posts = post::onlyTrashed()->paginate(5);
                return view('dashboard.posts.index' , ['posts' => $posts]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $posts = post::onlyTrashed()->paginate(5);
                return view('dashboard.posts.index' , ['posts' => $posts]);
            }



        }else{

            if(auth()->user()->hasPermission('posts-trash')){
                $post->delete();

                session()->flash('success' , 'post trashed successfully');

                $posts = post::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.posts.index')->with('posts' , $posts);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $posts = post::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.posts.index')->with('posts' , $posts);
            }

        }


    }


    public function trashed()
    {

        $posts = post::onlyTrashed()->paginate(5);
        return view('dashboard.posts.index' , ['posts' => $posts]);

    }

    public function restore( $lang , $post)
    {

        $post = post::withTrashed()->where('id' , $post)->first()->restore();

        session()->flash('success' , 'post restored successfully');

        $posts = post::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.posts.index')->with('posts' , $posts);
    }
}
