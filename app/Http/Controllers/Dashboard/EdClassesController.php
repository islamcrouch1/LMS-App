<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\EdClass;
use App\Stage;

use App\Country;


class EdClassesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:ed_classes-read')->only('index' , 'show');
        $this->middleware('permission:ed_classes-create')->only('create' , 'store');
        $this->middleware('permission:ed_classes-update')->only('edit' , 'update');
        $this->middleware('permission:ed_classes-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:ed_classes-restore')->only('restore');
    }


    public function index($lang ,Request $request)
    {
        $ed_classes = EdClass::where('stage_id' , $request->stage)->whenSearch(request()->search)
        ->paginate(5);

        $country = Country::findOrFail($request->country);

        $stage = Stage::findOrFail($request->stage);



        return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {


        $country = Country::findOrFail($request->country);

        $stage = Stage::findOrFail($request->stage);

        return view('dashboard.ed_classes.create')->with('stage' , $stage)->with('country' , $country);
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


            ]);


            $ed_class = EdClass::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'stage_id' => $request['stage'],
                'country_id' => $request['country'],

            ]);


            session()->flash('success' , 'Ed_class created successfully');


            $ed_classes = EdClass::where('stage_id' , $request->stage)->whenSearch(request()->search)
            ->paginate(5);

            $country = Country::findOrFail($request->country);

            $stage = Stage::findOrFail($request->stage);



            return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
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
    public function edit($lang , $ed_class ,Request $request)
    {
        $ed_class = EdClass::find($ed_class);
        $country = Country::findOrFail($request->country);

        $stage = Stage::findOrFail($request->stage);
        return view('dashboard.ed_classes.edit ')->with('ed_class', $ed_class)->with('stage' , $stage)->with('country' , $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, EdClass $ed_class)
    {

        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",



            ]);



            $ed_class->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],

            ]);







            session()->flash('success' , 'Ed_class updated successfully');

            $ed_classes = EdClass::where('stage_id' , $request->stage)->whenSearch(request()->search)
            ->paginate(5);

            $country = Country::findOrFail($request->country);

            $stage = Stage::findOrFail($request->stage);



            return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $ed_class , Request $request)
    {

        $ed_class = EdClass::withTrashed()->where('id' , $ed_class)->first();

        if($ed_class->trashed()){

            if(auth()->user()->hasPermission('ed_classes-delete')){
                $ed_class->forceDelete();

                session()->flash('success' , 'Ed_class Deleted successfully');

                $ed_classes = EdClass::where('stage_id' , $request->stage)->onlyTrashed()->paginate(5);

                $country = Country::findOrFail($request->country);

                $stage = Stage::findOrFail($request->stage);

                return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $ed_classes = EdClass::where('stage_id' , $request->stage)->onlyTrashed()->paginate(5);

                $country = Country::findOrFail($request->country);

                $stage = Stage::findOrFail($request->stage);

                return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
            }



        }else{

            if(auth()->user()->hasPermission('ed_classes-trash')){
                $ed_class->delete();

                session()->flash('success' , 'Ed_class trashed successfully');

                $ed_classes = EdClass::where('stage_id' , $request->stage)->whenSearch(request()->search)
                ->paginate(5);

                $country = Country::findOrFail($request->country);

                $stage = Stage::findOrFail($request->stage);



                return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $ed_classes = EdClass::where('stage_id' , $request->stage)->whenSearch(request()->search)
                ->paginate(5);

                $country = Country::findOrFail($request->country);

                $stage = Stage::findOrFail($request->stage);



                return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
            }

        }


    }


    public function trashed( Request $request)
    {

            $ed_classes = EdClass::where('stage_id' , $request->stage)->onlyTrashed()->paginate(5);

            $country = Country::findOrFail($request->country);

            $stage = Stage::findOrFail($request->stage);

            return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);

    }

    public function restore( $lang , $ed_class , Request $request)
    {

        $ed_class = EdClass::withTrashed()->where('id' , $ed_class)->first()->restore();

        session()->flash('success' , 'Ed_class restored successfully');

        $ed_classes = EdClass::where('stage_id' , $request->stage)->whenSearch(request()->search)
        ->paginate(5);

        $country = Country::findOrFail($request->country);

        $stage = Stage::findOrFail($request->stage);



        return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('country' , $country)->with('stage' , $stage);
    }
}
