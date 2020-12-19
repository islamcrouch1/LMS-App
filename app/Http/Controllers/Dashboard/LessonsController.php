<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Lesson;
use App\Chapter;
use App\Country;
use App\UserLesson;

use App\CourseOrder;
use App\Exam;




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


    public function index($lang ,Request $request)
    {


        $country = Country::findOrFail($request->country);

        $chapter = Chapter::findOrFail($request->chapter);

        $lessons = Lesson::where('chapter_id' , $request->chapter)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
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
            'chapter_id' => $request['chapter'],
            'country_id' => $request['country'],
        ]);


        Exam::create([

            'lesson_id' => $lesson->id,

        ]);

        $orders = CourseOrder::where('status' , 'done')->get();

        foreach($orders as $order){
            $course = $order->course;

            foreach($course->chapters as $chapter){

                foreach($chapter->lessons as $lesson){

                    $user_lesson_check = UserLesson::where('lesson_id' , $lesson->id)
                    ->where('user_id' , $order->user_id)
                    ->first();


                    if($user_lesson_check == null){

                        $user_lesson = UserLesson::create([

                            'user_id' => $order->user_id,
                            'lesson_id' => $lesson->id,
                            'course_id' => $course->id,
                            'watched' => 0,

                        ]);

                    }
                }
            }
        }

        $country = Country::findOrFail($request->country);
        $chapter = Chapter::findOrFail($request->chapter);
        return view('dashboard.lessons.create')->with('chapter' , $chapter)->with('lesson' , $lesson)->with('country' , $country);
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

                'name_ar' => "required|string|max:255",
                'name_en' => "required|string|max:255",
                'description_ar' => "string",
                'description_en' => "string",
                'image' => "required|image",
                'type' => "required|integer",
                'lesson_file' => "nullable|file",



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

                if($request->hasFile('lesson_file')){


                    $fileName = time(). '-' . '.'.$request['lesson_file']->extension();

                    $request['lesson_file']->move(public_path('storage/lessons/files'), $fileName);
                }else{
                    $fileName = '#';
                }



                $lesson->update([
                    'name_ar' => $request['name_ar'],
                    'name_en' => $request['name_en'],
                    'description_ar' => $request['description_ar'],
                    'description_en' => $request['description_en'],
                    'type' => $request['type'],
                    'lesson_file' => $fileName,

                ]);

                session()->flash('success' , 'Lesson created successfully');

                $country = Country::findOrFail($request->country);

                $chapter = Chapter::findOrFail($request->chapter);

                $lessons = Lesson::where('chapter_id' , $request->chapter)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
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

    public function display($lang ,Lesson $lesson , Request $request){

        $country = Country::findOrFail($request->country);

        $chapter = Chapter::findOrFail($request->chapter);

        return view('dashboard.lessons.show')->with('lesson' , $lesson)->with('country' , $country)->with('chapter' , $chapter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , $lesson ,Request $request)
    {
        $country = Country::findOrFail($request->country);
        $chapter = Chapter::findOrFail($request->chapter);
        $lesson = Lesson::find($lesson);
        return view('dashboard.lessons.edit ')->with('lesson', $lesson)->with('chapter' , $chapter)->with('country' , $country);
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

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'description_ar' => "string",
            'description_en' => "string",
            'image' => "image",
            'type' => "required|integer",
            'lesson_file' => "nullable|file",


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


            if($request->hasFile('lesson_file')){

                if($lesson->lesson_file == '#'){

                    $fileName = time(). '-' . '.'.$request['lesson_file']->extension();

                    $request['lesson_file']->move(public_path('storage/lessons/files'), $fileName);

                }else{

                    Storage::disk('public')->delete('/lessons/files/' . $lesson->lesson_file);

                    $fileName = time(). '-' . '.'.$request['lesson_file']->extension();

                    $request['lesson_file']->move(public_path('storage/lessons/files'), $fileName);
                }

            }else{
                $fileName = $lesson->lesson_file;
            }



            $lesson->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'type' => $request['type'],
                'lesson_file' => $fileName,

            ]);







            session()->flash('success' , 'Lesson updated successfully');

            $country = Country::findOrFail($request->country);

            $chapter = Chapter::findOrFail($request->chapter);

            $lessons = Lesson::where('chapter_id' , $request->chapter)->whenSearch(request()->search)
            ->paginate(5);

            return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $lesson , Request $request)
    {

        $lesson = Lesson::withTrashed()->where('id' , $lesson)->first();

        if($lesson->trashed()){

            if(auth()->user()->hasPermission('lessons-delete')){


                Storage::disk('public')->delete('images/lessons/' . $lesson->image);
                Storage::disk('public')->delete($lesson->path);

                Storage::disk('public')->deleteDirectory('lessons/videos/' . $lesson->id);

                $lesson->exam->delete();

                $lesson->forceDelete();

                session()->flash('success' , 'Lesson Deleted successfully');

                $lessons = Lesson::where('chapter_id' , $request->chapter)->onlyTrashed()->paginate(5);

                $country = Country::findOrFail($request->country);

                $chapter = Chapter::findOrFail($request->chapter);

                return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $lessons = Lesson::where('chapter_id' , $request->chapter)->onlyTrashed()->paginate(5);

                $country = Country::findOrFail($request->country);

                $chapter = Chapter::findOrFail($request->chapter);

                return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
            }



        }else{

            if(auth()->user()->hasPermission('lessons-trash')){
                $lesson->delete();

                session()->flash('success' , 'Lesson trashed successfully');

                $country = Country::findOrFail($request->country);

                $chapter = Chapter::findOrFail($request->chapter);

                $lessons = Lesson::where('chapter_id' , $request->chapter)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $country = Country::findOrFail($request->country);

                $chapter = Chapter::findOrFail($request->chapter);

                $lessons = Lesson::where('chapter_id' , $request->chapter)->whenSearch(request()->search)
                ->paginate(5);

                return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
            }

        }


    }


    public function trashed(Request $request)
    {

        $lessons = Lesson::where('chapter_id' , $request->chapter)->onlyTrashed()->paginate(5);

        $country = Country::findOrFail($request->country);

        $chapter = Chapter::findOrFail($request->chapter);

        return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);

    }

    public function restore( $lang , $lesson , Request $request)
    {

        $lesson = Lesson::withTrashed()->where('id' , $lesson)->first()->restore();

        session()->flash('success' , 'Lesson restored successfully');

        $country = Country::findOrFail($request->country);

        $chapter = Chapter::findOrFail($request->chapter);

        $lessons = Lesson::where('chapter_id' , $request->chapter)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.lessons.index')->with('lessons' , $lessons)->with('country' , $country)->with('chapter' , $chapter);
    }




    public function changeStatus ($lang , $user , $country , Request $request)
    {


        $user_lesson = UserLesson::where('leeson_id' , $request->lesson)->where('user_id' , $user);


        if($user_lesson->watched == 0){

            $user_lesson->update([
                'watched' => 1 ,
            ]);

        }
    }


}
