<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\LearningSystem;

use App\Stage;
use App\Country;

class StagesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:stages-read')->only('index' , 'show');
        $this->middleware('permission:stages-create')->only('create' , 'store');
        $this->middleware('permission:stages-update')->only('edit' , 'update');
        $this->middleware('permission:stages-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:stages-restore')->only('restore');
    }


    public function index($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);

        $stages = Stage::where('learning_system_id' , $request->learning_system)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);
        return view('dashboard.stages.create')->with('country' , $country)->with('learning_system' , $learning_system);
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


            $stage = Stage::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'learning_system_id' => $request['learning_system'],
                'country_id' => $request['country'],

            ]);


            session()->flash('success' , 'Stage created successfully');


            $country = Country::findOrFail($request->country);

            $learning_system = LearningSystem::findOrFail($request->learning_system);

            $stages = Stage::where('learning_system_id' , $request->learning_system)->whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
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
    public function edit($lang , $stage ,Request $request)
    {
        $stage = Stage::find($stage);
        $country = Country::findOrFail($request->country);
        $learning_system = LearningSystem::findOrFail($request->learning_system);
        return view('dashboard.stages.edit ')->with('stage', $stage)->with('learning_system' , $learning_system)->with('country' , $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Stage $stage)
    {

        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",



            ]);



            $stage->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],

            ]);







            session()->flash('success' , 'Stage updated successfully');

            $country = Country::findOrFail($request->country);

            $learning_system = LearningSystem::findOrFail($request->learning_system);

            $stages = Stage::where('learning_system_id' , $request->learning_system)->whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $stage ,Request $request)
    {

        $stage = Stage::withTrashed()->where('id' , $stage)->first();

        if($stage->trashed()){

            if(auth()->user()->hasPermission('stages-delete')){
                $stage->forceDelete();

                session()->flash('success' , 'Stage Deleted successfully');

                $stages = Stage::where('learning_system_id' , $request->learning_system)->onlyTrashed()->paginate(5);

                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $stages = Stage::where('learning_system_id' , $request->learning_system)->onlyTrashed()->paginate(5);
                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
            }



        }else{

            if(auth()->user()->hasPermission('stages-trash')){
                $stage->delete();

                session()->flash('success' , 'Stage trashed successfully');

                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                $stages = Stage::where('learning_system_id' , $request->learning_system)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                $stages = Stage::where('learning_system_id' , $request->learning_system)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
            }

        }


    }


    public function trashed(Request $request)
    {

        $stages = Stage::where('learning_system_id' , $request->learning_system)->onlyTrashed()->paginate(5);
        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);

        return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);

    }

    public function restore( $lang , $stage , Request $request)
    {

        $stage = Stage::withTrashed()->where('id' , $stage)->first()->restore();

        session()->flash('success' , 'Stage restored successfully');

        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);

        $stages = Stage::where('learning_system_id' , $request->learning_system)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.stages.index')->with('stages' , $stages)->with('country' , $country)->with('learning_system' , $learning_system);
    }
}
