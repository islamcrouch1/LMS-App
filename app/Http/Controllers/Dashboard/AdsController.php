<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Ad;

class AdsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:ads-read')->only('index' , 'show');
        $this->middleware('permission:ads-create')->only('create' , 'store');
        $this->middleware('permission:ads-update')->only('edit' , 'update');
        $this->middleware('permission:ads-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:ads-restore')->only('restore');
    }


    public function index()
    {
        $ads = Ad::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.ads.index')->with('ads' , $ads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.ads.create');
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

            'name_ar' => "required|string|max:255|unique:ads",
            'name_en' => "required|string|max:255|unique:ads",
            'image' => "required|image",
            'url' => "required|string",


            ]);


            $ad = ad::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'url' => $request['url'],
                'image' => $request['image']->store('images/adver', 'public')

            ]);


            session()->flash('success' , 'ad created successfully');


            $ads = ad::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.ads.index')->with('ads' , $ads);
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
    public function edit($lang , $ad)
    {
        $ad = ad::find($ad);
        return view('dashboard.ads.edit ')->with('ad', $ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, ad $ad)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:ads,name_ar," .$ad->id,
            'name_en' => "required|string|max:255|unique:ads,name_en," .$ad->id,
            'image' => "image",
            'url' => "required|string",


            ]);

            if($request->hasFile('image')){

                \Storage::disk('public')->delete($ad->image);
                $ad->update([
                    'image' => $request['image']->store('images/adver', 'public'),
                ]);
            }



            $ad->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'url' => $request['url'],

            ]);







            session()->flash('success' , 'ad updated successfully');

            $ads = ad::whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.ads.index')->with('ads' , $ads);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $ad)
    {

        $ad = ad::withTrashed()->where('id' , $ad)->first();

        if($ad->trashed()){

            if(auth()->user()->hasPermission('ads-delete')){
                $ad->forceDelete();

                session()->flash('success' , 'ad Deleted successfully');

                $ads = ad::onlyTrashed()->paginate(5);
                return view('dashboard.ads.index' , ['ads' => $ads]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $ads = ad::onlyTrashed()->paginate(5);
                return view('dashboard.ads.index' , ['ads' => $ads]);
            }



        }else{

            if(auth()->user()->hasPermission('ads-trash')){
                $ad->delete();

                session()->flash('success' , 'ad trashed successfully');

                $ads = ad::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.ads.index')->with('ads' , $ads);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $ads = ad::whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.ads.index')->with('ads' , $ads);
            }

        }


    }


    public function trashed()
    {

        $ads = ad::onlyTrashed()->paginate(5);
        return view('dashboard.ads.index' , ['ads' => $ads]);

    }

    public function restore( $lang , $ad)
    {

        $ad = ad::withTrashed()->where('id' , $ad)->first()->restore();

        session()->flash('success' , 'ad restored successfully');

        $ads = ad::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.ads.index')->with('ads' , $ads);
    }
}
