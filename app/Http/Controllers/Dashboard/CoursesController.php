<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Course;
use App\EdClass;

class CoursesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:courses-read')->only('index' , 'show');
        $this->middleware('permission:courses-create')->only('create' , 'store');
        $this->middleware('permission:courses-update')->only('edit' , 'update');
        $this->middleware('permission:courses-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:courses-restore')->only('restore');
    }


    public function index()
    {
        $courses = Course::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.courses.index')->with('courses' , $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ed_classes = EdClass::all();
        return view('dashboard.courses.create')->with('ed_classes' , $ed_classes);
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

            'name_ar' => "required|string|max:255|unique:courses",
            'name_en' => "required|string|max:255|unique:courses",
            'ed_class_id' => "required",
            'image' => "required|image",
            'description_ar' => "required|string",
            'description_en' => "required|string",

            ]);


            $course = Course::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'ed_class_id' => $request['ed_class_id'],
                'image' => $request['image']->store('images/courses', 'public')

            ]);
       
            
            session()->flash('success' , 'Course created successfully');

            
            $ed_classes = EdClass::all();
            $courses = Course::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.courses.index')->with('courses' , $courses)->with('ed_classes' , $ed_classes);
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
    public function edit($lang , $course)
    {
        $ed_classes = EdClass::all();
        $course = Course::find($course);
        return view('dashboard.courses.edit ')->with('course', $course)->with('ed_classes' , $ed_classes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Course $course)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:courses,name_ar," .$course->id,
            'name_en' => "required|string|max:255|unique:courses,name_en," .$course->id,
            'ed_class_id' => "required",
            'image' => "image",
            'description_ar' => "required|string",
            'description_en' => "required|string",


            ]);

            if($request->hasFile('image')){
                
                \Storage::disk('public')->delete($course->image);
                $course->update([
                    'image' => $request['image']->store('images/courses', 'public'),
                ]);
            }



            $course->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'ed_class_id' => $request['ed_class_id'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],

            ]);






            
            session()->flash('success' , 'Course updated successfully');

            $courses = Course::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.courses.index')->with('courses' , $courses);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $course)
    {
        
        $course = Course::withTrashed()->where('id' , $course)->first();

        if($course->trashed()){

            if(auth()->user()->hasPermission('courses-delete')){
                $course->forceDelete();

                session()->flash('success' , 'Course Deleted successfully');
    
                $courses = Course::onlyTrashed()->paginate(5);
                return view('dashboard.courses.index' , ['courses' => $courses]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
    
                $courses = Course::onlyTrashed()->paginate(5);
                return view('dashboard.courses.index' , ['courses' => $courses]);
            }



        }else{

            if(auth()->user()->hasPermission('courses-trash')){
                $course->delete();

                session()->flash('success' , 'Course trashed successfully');
        
                $courses = Course::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.courses.index')->with('courses' , $courses);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
        
                $courses = Course::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.courses.index')->with('courses' , $courses);
            }
 
        }


    }


    public function trashed()
    {
       
        $courses = Course::onlyTrashed()->paginate(5);
        return view('dashboard.courses.index' , ['courses' => $courses]);
        
    }

    public function restore( $lang , $course)
    {

        $course = Course::withTrashed()->where('id' , $course)->first()->restore();

        session()->flash('success' , 'Course restored successfully');
    
        $courses = Course::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.courses.index')->with('courses' , $courses);
    }
}
