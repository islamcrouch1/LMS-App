<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\LearningSystem;
use App\Country;

class LearningSystemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:learning_systems-read')->only('index' , 'show');
        $this->middleware('permission:learning_systems-create')->only('create' , 'store');
        $this->middleware('permission:learning_systems-update')->only('edit' , 'update');
        $this->middleware('permission:learning_systems-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:learning_systems-restore')->only('restore');
    }


    public function index($lang ,Request $request)
    {

        $country = Country::findOrFail($request->country);

        $learning_systems = LearningSystem::where('country_id' , $request->country)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.learning_systems.index')->with('learning_systems' , $learning_systems)->with('country' , $country);
    }


    public function countries()
    {
        $countries = Country::all();

        return view('dashboard.learning_systems.show_all')->with('countries' , $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);
        return view('dashboard.learning_systems.create')->with('country' , $country);
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

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'description_ar' => "string",
            'description_en' => "string",
            'image' => "required|image",
            'country' => "string",

            ]);



            $learning_system = LearningSystem::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'country_id' => $request['country'],
                'image' => $request['image']->store('images/learningSystems', 'public')
            ]);




            session()->flash('success' , 'Learning System created successfully');
            $country = Country::findOrFail($request->country);
            return redirect()->route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id]);


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
    public function edit($lang , $learning_system ,Request $request)
    {
        $learning_system = LearningSystem::find($learning_system);
        $country = Country::findOrFail($request->country);

        return view('dashboard.learning_systems.edit ')->with('learning_system', $learning_system)->with('country' , $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, LearningSystem $learning_system)
    {

        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'description_ar' => "string",
            'description_en' => "string",
            'image' => "image",


            ]);

            if($request->hasFile('image')){

                \Storage::disk('public')->delete($learning_system->image);
                $learning_system->update([
                    'image' => $request['image']->store('images/learningSystems', 'public'),
                ]);
            }

            $learning_system->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],

            ]);




            session()->flash('success' , 'Learning System updated successfully');
            $country = Country::findOrFail($request->country);
            return redirect()->route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $learning_system ,Request $request)
    {

        $learning_system = LearningSystem::withTrashed()->where('id' , $learning_system)->first();

        if($learning_system->trashed()){

            if(auth()->user()->hasPermission('learning_systems-delete')){
                $learning_system->forceDelete();

                session()->flash('success' , 'Learning System Deleted successfully');
                $country = Country::findOrFail($request->country);
                $learning_systems = LearningSystem::where('country_id' , $request->country)->onlyTrashed()->paginate(5);
                return view('dashboard.learning_systems.index')->with('learning_systems' , $learning_systems)->with('country' , $country);

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $country = Country::findOrFail($request->country);
                $learning_systems = LearningSystem::where('country_id' , $request->country)->onlyTrashed()->paginate(5);
                return view('dashboard.learning_systems.index')->with('learning_systems' , $learning_systems)->with('country' , $country);

            }



        }else{

            if(auth()->user()->hasPermission('learning_systems-trash')){

                $learning_system->delete();
                session()->flash('success' , 'Learning System trashed successfully');
                $country = Country::findOrFail($request->country);
                return redirect()->route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id]);

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                $country = Country::findOrFail($request->country);
                return redirect()->route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id]);

            }

        }


    }


    public function trashed(Request $request)
    {


        $country = Country::findOrFail($request->country);
        $learning_systems = LearningSystem::where('country_id' ,$request->country )->onlyTrashed()->paginate(5);
        return view('dashboard.learning_systems.index')->with('learning_systems' , $learning_systems)->with('country' , $country);

    }

    public function restore( $lang , $learning_system , Request $request)
    {

        $learning_system = LearningSystem::withTrashed()->where('id' , $learning_system)->first()->restore();
        session()->flash('success' , 'Learning System restored successfully');
        $country = Country::findOrFail($request->country);
        return redirect()->route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id]);

    }
}
