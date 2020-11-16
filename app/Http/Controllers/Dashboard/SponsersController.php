<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Sponser;

class SponsersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:sponsers-read')->only('index' , 'show');
        $this->middleware('permission:sponsers-create')->only('create' , 'store');
        $this->middleware('permission:sponsers-update')->only('edit' , 'update');
        $this->middleware('permission:sponsers-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:sponsers-restore')->only('restore');
    }


    public function index()
    {
        $sponsers = sponser::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.sponsers.index')->with('sponsers' , $sponsers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sponsers.create');
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

            'name_ar' => "required|string|max:255|unique:sponsers",
            'name_en' => "required|string|max:255|unique:sponsers",
            'image' => "required|image",
            'url' => "required|string",

            ]);


            $sponser = sponser::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'url' => $request['url'],
                'image' => $request['image']->store('images/sponsers', 'public')

            ]);


            session()->flash('success' , 'sponser created successfully');


            $sponsers = sponser::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.sponsers.index')->with('sponsers' , $sponsers);
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
    public function edit($lang , $sponser)
    {
        $sponser = sponser::find($sponser);
        return view('dashboard.sponsers.edit ')->with('sponser', $sponser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, sponser $sponser)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:sponsers,name_ar," .$sponser->id,
            'name_en' => "required|string|max:255|unique:sponsers,name_en," .$sponser->id,
            'image' => "image",
            'url' => "required|string",


            ]);

            if($request->hasFile('image')){

                \Storage::disk('public')->delete($sponser->image);
                $sponser->update([
                    'image' => $request['image']->store('images/sponsers', 'public'),
                ]);
            }



            $sponser->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'url' => $request['url'],

            ]);







            session()->flash('success' , 'sponser updated successfully');

            $sponsers = sponser::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.sponsers.index')->with('sponsers' , $sponsers);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $sponser)
    {

        $sponser = sponser::withTrashed()->where('id' , $sponser)->first();

        if($sponser->trashed()){

            if(auth()->user()->hasPermission('sponsers-delete')){
                $sponser->forceDelete();

                session()->flash('success' , 'sponser Deleted successfully');

                $sponsers = sponser::onlyTrashed()->paginate(5);
                return view('dashboard.sponsers.index' , ['sponsers' => $sponsers]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $sponsers = sponser::onlyTrashed()->paginate(5);
                return view('dashboard.sponsers.index' , ['sponsers' => $sponsers]);
            }



        }else{

            if(auth()->user()->hasPermission('sponsers-trash')){
                $sponser->delete();

                session()->flash('success' , 'sponser trashed successfully');

                $sponsers = sponser::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.sponsers.index')->with('sponsers' , $sponsers);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $sponsers = sponser::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.sponsers.index')->with('sponsers' , $sponsers);
            }

        }


    }


    public function trashed()
    {

        $sponsers = sponser::onlyTrashed()->paginate(5);
        return view('dashboard.sponsers.index' , ['sponsers' => $sponsers]);

    }

    public function restore( $lang , $sponser)
    {

        $sponser = sponser::withTrashed()->where('id' , $sponser)->first()->restore();

        session()->flash('success' , 'sponser restored successfully');

        $sponsers = sponser::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.sponsers.index')->with('sponsers' , $sponsers);
    }
}
