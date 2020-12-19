<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Course;
use App\EdClass;
use App\Country;
use App\Exam;


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


    public function index($lang ,Request $request)
    {


        $courses = Course::where('ed_class_id' , $request->ed_class)->whenSearch(request()->search)
        ->paginate(5);

        $country = Country::findOrFail($request->country);

        $ed_class = EdClass::findOrFail($request->ed_class);



        return view('dashboard.courses.index')->with('courses' , $courses)->with('country' , $country)->with('ed_class' , $ed_class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);

        $ed_class = EdClass::findOrFail($request->ed_class);

        return view('dashboard.courses.create')->with('ed_class' , $ed_class)->with('country' , $country);
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
            'image' => "required|image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'homework_price' => "required|string",
            'teacher_commission' => "required|string",
            'course_price' => "required|string",


            ]);




            $course = Course::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'ed_class_id' => $request['ed_class'],
                'country_id' => $request['country'],
                'homework_price' => $request['homework_price'],
                'course_price' => $request['course_price'],
                'teacher_commission' => $request['teacher_commission'],
                'image' => $request['image']->store('images/courses', 'public')

            ]);


            $exam = Exam::create([

                'course_id' => $course->id,

            ]);


            session()->flash('success' , 'Course created successfully');


            return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);

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
    public function edit($lang , $course ,Request $request)
    {
        $course = Course::find($course);
        $country = Country::findOrFail($request->country);
        $ed_class = EdClass::findOrFail($request->ed_class);
        return view('dashboard.courses.edit ')->with('course', $course)->with('ed_class' , $ed_class)->with('country' , $country);
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

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'image' => "image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'homework_price' => "required|string",
            'teacher_commission' => "required|string",
            'course_price' => "required|string",



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
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'homework_price' => $request['homework_price'],
                'teacher_commission' => $request['teacher_commission'],
                'course_price' => $request['course_price'],

            ]);







            session()->flash('success' , 'Course updated successfully');

            return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $course ,Request $request)
    {

        $course = Course::withTrashed()->where('id' , $course)->first();

        if($course->trashed()){

            if(auth()->user()->hasPermission('courses-delete')){

                $course->exam->delete();

                $course->forceDelete();

                session()->flash('success' , 'Course Deleted successfully');

                $courses = Course::where('ed_class_id' , $request->ed_class)->onlyTrashed()->paginate(5);
                $country = Country::findOrFail($request->country);
                $ed_class = EdClass::findOrFail($request->ed_class);

                return view('dashboard.courses.index')->with('courses' , $courses)->with('country' , $country)->with('ed_class' , $ed_class);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $courses = Course::where('ed_class_id' , $request->ed_class)->onlyTrashed()->paginate(5);
                $country = Country::findOrFail($request->country);
                $ed_class = EdClass::findOrFail($request->ed_class);

                return view('dashboard.courses.index')->with('courses' , $courses)->with('country' , $country)->with('ed_class' , $ed_class);
            }



        }else{

            if(auth()->user()->hasPermission('courses-trash')){
                $course->delete();

                session()->flash('success' , 'Course trashed successfully');

                return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);

            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);

            }

        }


    }


    public function trashed(Request $request)
    {

        $courses = Course::where('ed_class_id' , $request->ed_class)->onlyTrashed()->paginate(5);
        $country = Country::findOrFail($request->country);
        $ed_class = EdClass::findOrFail($request->ed_class);

        return view('dashboard.courses.index')->with('courses' , $courses)->with('country' , $country)->with('ed_class' , $ed_class);

    }

    public function restore( $lang , $course ,Request $request)
    {

        $course = Course::withTrashed()->where('id' , $course)->first()->restore();

        session()->flash('success' , 'Course restored successfully');

        return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);

    }


    public function activate( $lang , Course $course , Request $request)
    {


        $course->update([

            'status' => 1,

        ]);


        return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);


    }


    public function deactivate($lang , Course $course , Request $request)
    {

        $course->update([

            'status' => 1,

        ]);


       return redirect()->route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$request->ed_class , 'country'=>$request->country]);

    }

}
