<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Course;
use App\Chapter;

use App\Country;


class ChaptersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:chapters-read')->only('index' , 'show');
        $this->middleware('permission:chapters-create')->only('create' , 'store');
        $this->middleware('permission:chapters-update')->only('edit' , 'update');
        $this->middleware('permission:chapters-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:chapters-restore')->only('restore');
    }


    public function index($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);

        $course = Course::findOrFail($request->course);

        $chapters = Chapter::where('course_id' , $request->course)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);

        $course = Course::findOrFail($request->course);
        return view('dashboard.chapters.create')->with('country' , $country)->with('course' , $course);
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


            $chapter = Chapter::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'course_id' => $request['course'],
                'country_id' => $request['country'],

            ]);


            session()->flash('success' , 'chapter created successfully');


            $country = Country::findOrFail($request->country);

            $course = Course::findOrFail($request->course);

            $chapters = Chapter::where('course_id' , $request->course)->whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
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
    public function edit($lang , $chapter ,Request $request)
    {
        $chapter = Chapter::find($chapter);
        $country = Country::findOrFail($request->country);
        $course = Course::findOrFail($request->course);
        return view('dashboard.chapters.edit ')->with('chapter', $chapter)->with('course' , $course)->with('country' , $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Chapter $chapter)
    {

        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",



            ]);



            $chapter->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],

            ]);







            session()->flash('success' , 'chapter updated successfully');

            $country = Country::findOrFail($request->country);

            $course = Course::findOrFail($request->course);

            $chapters = Chapter::where('course_id' , $request->course)->whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $chapter ,Request $request)
    {

        $chapter = Chapter::withTrashed()->where('id' , $chapter)->first();

        if($chapter->trashed()){

            if(auth()->user()->hasPermission('chapters-delete')){
                $chapter->forceDelete();

                session()->flash('success' , 'chapter Deleted successfully');

                $chapters = Chapter::where('course_id' , $request->course)->onlyTrashed()->paginate(5);

                $country = Country::findOrFail($request->country);

                $course = Course::findOrFail($request->course);

                return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $chapters = Chapter::where('course_id' , $request->course)->onlyTrashed()->paginate(5);
                $country = Country::findOrFail($request->country);

                $course = Course::findOrFail($request->course);

                return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
            }



        }else{

            if(auth()->user()->hasPermission('chapters-trash')){
                $chapter->delete();

                session()->flash('success' , 'chapter trashed successfully');

                $country = Country::findOrFail($request->country);

                $course = Course::findOrFail($request->course);

                $chapters = Chapter::where('course_id' , $request->course)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $country = Chapter::findOrFail($request->country);

                $course = Course::findOrFail($request->course);

                $chapters = Chapter::where('course_id' , $request->course)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
            }

        }


    }


    public function trashed(Request $request)
    {

        $chapters = Chapter::where('course_id' , $request->course)->onlyTrashed()->paginate(5);
        $country = Country::findOrFail($request->country);

        $course = Course::findOrFail($request->course);

        return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);

    }

    public function restore( $lang , $chapter , Request $request)
    {

        $chapter = Chapter::withTrashed()->where('id' , $chapter)->first()->restore();

        session()->flash('success' , 'chapter restored successfully');

        $country = Country::findOrFail($request->country);

        $course = Course::findOrFail($request->course);

        $chapters = Chapter::where('course_id' , $request->course)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('country' , $country)->with('course' , $course);
    }
}
