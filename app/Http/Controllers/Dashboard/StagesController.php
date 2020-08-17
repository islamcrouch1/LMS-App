<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\LearningSystem;

use App\Stage;

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


    public function index()
    {
        $stages = Stage::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.stages.index')->with('stages' , $stages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $learning_systems = LearningSystem::all();
        return view('dashboard.stages.create')->with('learning_systems' , $learning_systems);
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

            'name_ar' => "required|string|max:255|unique:stages",
            'name_en' => "required|string|max:255|unique:stages",
            'learning_system_id' => "required",


            ]);


            $stage = Stage::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'learning_system_id' => $request['learning_system_id'],
            ]);
       
            
            session()->flash('success' , 'Stage created successfully');

            
            $learning_systems = LearningSystem::all();
            $stages = Stage::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.stages.index')->with('stages' , $stages)->with('learning_systems' , $learning_systems);
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
    public function edit($lang , $stage)
    {
        $learning_systems = LearningSystem::all();
        $stage = Stage::find($stage);
        return view('dashboard.stages.edit ')->with('stage', $stage)->with('learning_systems' , $learning_systems);
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

            'name_ar' => "required|string|max:255|unique:stages,name_ar," .$stage->id,
            'name_en' => "required|string|max:255|unique:stages,name_en," .$stage->id,
            'learning_system_id' => "required",



            ]);



            $stage->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'learning_system_id' => $request['learning_system_id'],

            ]);






            
            session()->flash('success' , 'Stage updated successfully');

            $stages = Stage::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.stages.index')->with('stages' , $stages);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $stage)
    {
        
        $stage = Stage::withTrashed()->where('id' , $stage)->first();

        if($stage->trashed()){

            if(auth()->user()->hasPermission('stages-delete')){
                $stage->forceDelete();

                session()->flash('success' , 'Stage Deleted successfully');
    
                $stages = Stage::onlyTrashed()->paginate(5);
                return view('dashboard.stages.index' , ['stages' => $stages]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
    
                $stages = Stage::onlyTrashed()->paginate(5);
                return view('dashboard.stages.index' , ['stages' => $stages]);
            }



        }else{

            if(auth()->user()->hasPermission('stages-trash')){
                $stage->delete();

                session()->flash('success' , 'Stage trashed successfully');
        
                $stages = Stage::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.stages.index')->with('stages' , $stages);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
        
                $stages = Stage::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.stages.index')->with('stages' , $stages);
            }
 
        }


    }


    public function trashed()
    {
       
        $stages = Stage::onlyTrashed()->paginate(5);
        return view('dashboard.stages.index' , ['stages' => $stages]);
        
    }

    public function restore( $lang , $stage)
    {

        $stage = Stage::withTrashed()->where('id' , $stage)->first()->restore();

        session()->flash('success' , 'Stage restored successfully');
    
        $stages = Stage::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.stages.index')->with('stages' , $stages);
    }
}
