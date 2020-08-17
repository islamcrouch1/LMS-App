<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\EdClass;
use App\Stage;

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


    public function index()
    {
        $ed_classes = EdClass::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stages = Stage::all();
        return view('dashboard.ed_classes.create')->with('stages' , $stages);
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

            'name_ar' => "required|string|max:255|unique:ed_classes",
            'name_en' => "required|string|max:255|unique:ed_classes",
            'stage_id' => "required",


            ]);


            $ed_class = EdClass::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'stage_id' => $request['stage_id'],
            ]);
       
            
            session()->flash('success' , 'Ed_class created successfully');

            
            $stages = Stage::all();
            $ed_classes = EdClass::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes)->with('stages' , $stages);
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
    public function edit($lang , $ed_class)
    {
        $stages = Stage::all();
        $ed_class = EdClass::find($ed_class);
        return view('dashboard.ed_classes.edit ')->with('ed_class', $ed_class)->with('stages' , $stages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Ed_class $ed_class)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:ed_classes,name_ar," .$ed_class->id,
            'name_en' => "required|string|max:255|unique:ed_classes,name_en," .$ed_class->id,
            'stage_id' => "required",



            ]);



            $ed_class->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'stage_id' => $request['stage_id'],

            ]);






            
            session()->flash('success' , 'Ed_class updated successfully');

            $ed_classes = EdClass::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $ed_class)
    {
        
        $ed_class = EdClass::withTrashed()->where('id' , $ed_class)->first();

        if($ed_class->trashed()){

            if(auth()->user()->hasPermission('ed_classes-delete')){
                $ed_class->forceDelete();

                session()->flash('success' , 'Ed_class Deleted successfully');
    
                $ed_classes = EdClass::onlyTrashed()->paginate(5);
                return view('dashboard.ed_classes.index' , ['ed_classes' => $ed_classes]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
    
                $ed_classes = EdClass::onlyTrashed()->paginate(5);
                return view('dashboard.ed_classes.index' , ['ed_classes' => $ed_classes]);
            }



        }else{

            if(auth()->user()->hasPermission('ed_classes-trash')){
                $ed_class->delete();

                session()->flash('success' , 'Ed_class trashed successfully');
        
                $ed_classes = EdClass::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
        
                $ed_classes = EdClass::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes);
            }
 
        }


    }


    public function trashed()
    {
       
        $ed_classes = EdClass::onlyTrashed()->paginate(5);
        return view('dashboard.ed_classes.index' , ['ed_classes' => $ed_classes]);
        
    }

    public function restore( $lang , $ed_class)
    {

        $ed_class = EdClass::withTrashed()->where('id' , $ed_class)->first()->restore();

        session()->flash('success' , 'Ed_class restored successfully');
    
        $ed_classes = EdClass::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.ed_classes.index')->with('ed_classes' , $ed_classes);
    }
}
