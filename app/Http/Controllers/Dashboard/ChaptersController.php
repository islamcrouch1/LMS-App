<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Course;
use App\Chapter;

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


    public function index()
    {
        $chapters = Chapter::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.chapters.index')->with('chapters' , $chapters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('dashboard.chapters.create')->with('courses' , $courses);
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

            'name_ar' => "required|string|max:255|unique:chapters",
            'name_en' => "required|string|max:255|unique:chapters",
            'course_id' => "required",


            ]);


            $chapter = Chapter::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'course_id' => $request['course_id'],
            ]);
       
            
            session()->flash('success' , 'Chapter created successfully');

            
            $courses = Course::all();
            $chapters = Chapter::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.chapters.index')->with('chapters' , $chapters)->with('courses' , $courses);
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
    public function edit($lang , $chapter)
    {
        $courses = Course::all();
        $chapter = Chapter::find($chapter);
        return view('dashboard.chapters.edit ')->with('chapter', $chapter)->with('courses' , $courses);
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

            'name_ar' => "required|string|max:255|unique:chapters,name_ar," .$chapter->id,
            'name_en' => "required|string|max:255|unique:chapters,name_en," .$chapter->id,
            'course_id' => "required",



            ]);



            $chapter->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'course_id' => $request['course_id'],

            ]);






            
            session()->flash('success' , 'Chapter updated successfully');

            $chapters = Chapter::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.chapters.index')->with('chapters' , $chapters);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $chapter)
    {
        
        $chapter = Chapter::withTrashed()->where('id' , $chapter)->first();

        if($chapter->trashed()){

            if(auth()->user()->hasPermission('chapters-delete')){
                $chapter->forceDelete();

                session()->flash('success' , 'Chapter Deleted successfully');
    
                $chapters = Chapter::onlyTrashed()->paginate(5);
                return view('dashboard.chapters.index' , ['chapters' => $chapters]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
    
                $chapters = Chapter::onlyTrashed()->paginate(5);
                return view('dashboard.chapters.index' , ['chapters' => $chapters]);
            }



        }else{

            if(auth()->user()->hasPermission('chapters-trash')){
                $chapter->delete();

                session()->flash('success' , 'Chapter trashed successfully');
        
                $chapters = Chapter::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.chapters.index')->with('chapters' , $chapters);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
        
                $chapters = Chapter::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.chapters.index')->with('chapters' , $chapters);
            }
 
        }


    }


    public function trashed()
    {
       
        $chapters = Chapter::onlyTrashed()->paginate(5);
        return view('dashboard.chapters.index' , ['chapters' => $chapters]);
        
    }

    public function restore( $lang , $chapter)
    {

        $chapter = Chapter::withTrashed()->where('id' , $chapter)->first()->restore();

        session()->flash('success' , 'Chapter restored successfully');
    
        $chapters = Chapter::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.chapters.index')->with('chapters' , $chapters);
    }
}
