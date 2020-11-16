<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Link;

class LinksController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:links-read')->only('index' , 'show');
        $this->middleware('permission:links-create')->only('create' , 'store');
        $this->middleware('permission:links-update')->only('edit' , 'update');
        $this->middleware('permission:links-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:links-restore')->only('restore');
    }


    public function index()
    {
        $links = link::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.links.index')->with('links' , $links);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.links.create');
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

            'name_ar' => "required|string|max:255|unique:links",
            'name_en' => "required|string|max:255|unique:links",
            'image' => "required|image",
            'url' => "required|string",

            ]);


            $link = link::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'url' => $request['url'],
                'image' => $request['image']->store('images/links', 'public')

            ]);


            session()->flash('success' , 'link created successfully');


            $links = link::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.links.index')->with('links' , $links);
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
    public function edit($lang , $link)
    {
        $link = link::find($link);
        return view('dashboard.links.edit ')->with('link', $link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, link $link)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:links,name_ar," .$link->id,
            'name_en' => "required|string|max:255|unique:links,name_en," .$link->id,
            'image' => "image",
            'url' => "required|string",


            ]);

            if($request->hasFile('image')){

                \Storage::disk('public')->delete($link->image);
                $link->update([
                    'image' => $request['image']->store('images/links', 'public'),
                ]);
            }



            $link->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'url' => $request['url'],

            ]);







            session()->flash('success' , 'link updated successfully');

            $links = link::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.links.index')->with('links' , $links);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $link)
    {

        $link = link::withTrashed()->where('id' , $link)->first();

        if($link->trashed()){

            if(auth()->user()->hasPermission('links-delete')){
                $link->forceDelete();

                session()->flash('success' , 'link Deleted successfully');

                $links = link::onlyTrashed()->paginate(5);
                return view('dashboard.links.index' , ['links' => $links]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $links = link::onlyTrashed()->paginate(5);
                return view('dashboard.links.index' , ['links' => $links]);
            }



        }else{

            if(auth()->user()->hasPermission('links-trash')){
                $link->delete();

                session()->flash('success' , 'link trashed successfully');

                $links = link::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.links.index')->with('links' , $links);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $links = link::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.links.index')->with('links' , $links);
            }

        }


    }


    public function trashed()
    {

        $links = link::onlyTrashed()->paginate(5);
        return view('dashboard.links.index' , ['links' => $links]);

    }

    public function restore( $lang , $link)
    {

        $link = link::withTrashed()->where('id' , $link)->first()->restore();

        session()->flash('success' , 'link restored successfully');

        $links = link::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.links.index')->with('links' , $links);
    }
}
