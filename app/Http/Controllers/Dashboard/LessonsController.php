<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Lesson;
use App\Chapter;

use App\Jobs\StreamLesson;

use Intervention\Image\ImageManagerStatic as Image;

class LessonsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:lessons-read')->only('index' , 'show');
        $this->middleware('permission:lessons-create')->only('create' , 'store');
        $this->middleware('permission:lessons-update')->only('edit' , 'update');
        $this->middleware('permission:lessons-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:lessons-restore')->only('restore');
    }


    public function index()
    {
        $lessons = Lesson::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.lessons.index')->with('lessons' , $lessons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $lesson = Lesson::create([]);
        $lesson->update([
            'chapter_id' => 1,
        ]);
        $chapters = Chapter::all();
        return view('dashboard.lessons.create')->with('chapters' , $chapters)->with('lesson' , $lesson);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


      

        $lesson = Lesson::findOrFail($request->lesson_id);


        if($lesson->path == NULL){
            
            $lesson->update([
                'name_ar' => $request->name,
                'name_en' => $request->name,
                'path'  => $request->file('lesson')->store('lessons/videos', 'public'),
            ]);
    
    
            $this->disPatch(new StreamLesson($lesson));
            return $lesson;
            
        }else{
            
            $request->validate([

                'name_ar' => "required|string|max:255|unique:lessons,name_ar," .$lesson->id,
                'name_en' => "required|string|max:255|unique:lessons,name_en," .$lesson->id,
                'description_ar' => "string",
                'description_en' => "string",
                'chapter_id' => "required",
                'image' => "required|image",
    
                ]);


    
                if($request->hasFile('image')){

                    \Storage::disk('public')->delete($lesson->image);

                    $img = Image::make($request->image)
                    ->resize(500, 500)
                    ->encode('jpg', 50);
    
                    Storage::disk('public')->put('images/lessons/' . $request->image->hashName(), (string)$img, 'public');
                    $image = $request->image->hashName();

                    $lesson->update([
                        'image' => $image,
                    ]);
                }
    
    
    
                $lesson->update([
                    'name_ar' => $request['name_ar'],
                    'name_en' => $request['name_en'],
                    'description_ar' => $request['description_ar'],
                    'description_en' => $request['description_en'],
                    'chapter_id' => $request['chapter_id'],
                ]);
    
    
    
    
    
                session()->flash('success' , 'Lesson created successfully');
                
                $chapters = Chapter::all();
                $lessons = Lesson::whenSearch(request()->search)
                ->paginate(5);
       
                return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('chapters' , $chapters);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang ,Lesson $lesson)
    {
        return $lesson;
    }

    public function display($lang ,Lesson $lesson){
        return view('dashboard.lessons.show')->with('lesson' , $lesson);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , $lesson)
    {
        $chapters = Chapter::all();
        $lesson = Lesson::find($lesson);
        return view('dashboard.lessons.edit ')->with('lesson', $lesson)->with('chapters' , $chapters);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Lesson $lesson)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:lessons,name_en," .$lesson->id,
            'name_en' => "required|string|max:255|unique:lessons,name_en," .$lesson->id,
            'description_ar' => "string",
            'description_en' => "string",
            'chapter_id' => "required",
            'image' => "image",

            ]);

            if($request->hasFile('image')){
                
                \Storage::disk('public')->delete($lesson->image);

                $img = Image::make($request->image)
                ->resize(500, 500)
                ->encode('jpg', 50);

                Storage::disk('public')->put('images/lessons/' . $request->image->hashName(), (string)$img, 'public');
                $image = $request->image->hashName();

                $lesson->update([
                    'image' => $image,
                ]);
            }



            $lesson->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'chapter_id' => $request['chapter_id'],
            ]);






            
            session()->flash('success' , 'Lesson updated successfully');

            $lessons = Lesson::whenSearch(request()->search)
            ->paginate(5);
    
            return view('dashboard.lessons.index')->with('lessons' , $lessons);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $lesson)
    {
        
        $lesson = Lesson::withTrashed()->where('id' , $lesson)->first();

        if($lesson->trashed()){

            if(auth()->user()->hasPermission('lessons-delete')){


                Storage::disk('public')->delete('images/lessons/' . $lesson->image);
                Storage::disk('public')->delete($lesson->path);
        
                Storage::disk('public')->deleteDirectory('lessons/videos/' . $lesson->id);


                $lesson->forceDelete();

                session()->flash('success' , 'Lesson Deleted successfully');
    
                $lessons = Lesson::onlyTrashed()->paginate(5);
                return view('dashboard.lessons.index' , ['lessons' => $lessons]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
    
                $lessons = Lesson::onlyTrashed()->paginate(5);
                return view('dashboard.lessons.index' , ['lessons' => $lessons]);
            }



        }else{

            if(auth()->user()->hasPermission('lessons-trash')){
                $lesson->delete();

                session()->flash('success' , 'Lesson trashed successfully');
        
                $lessons = Lesson::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.lessons.index')->with('lessons' , $lessons);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
        
                $lessons = Lesson::whenSearch(request()->search)
                ->paginate(5);
        
                return view('dashboard.lessons.index')->with('lessons' , $lessons);
            }
 
        }


    }


    public function trashed()
    {
       
        $lessons = Lesson::onlyTrashed()->paginate(5);
        return view('dashboard.lessons.index' , ['lessons' => $lessons]);
        
    }

    public function restore( $lang , $lesson)
    {

        $lesson = Lesson::withTrashed()->where('id' , $lesson)->first()->restore();

        session()->flash('success' , 'Lesson restored successfully');
    
        $lessons = Lesson::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.lessons.index')->with('lessons' , $lessons);
    }
}
