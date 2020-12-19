<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lesson;
use App\Country;
use App\Link;
use App\User;
use App\UserLesson;
use App\Course;





class LessonsController extends Controller
{
    public function index($lang , $lesson , $scountry , Request $request)
    {

        $links = Link::all();

        $scountry = Country::findOrFail($scountry);
        $course = Course::findOrFail($request->course);

        $slesson = Lesson::findOrFail($lesson);
        $countries = Country::all();
        return view('lessons' , compact('slesson' , 'countries' , 'scountry' , 'links' , 'course' ));
    }


    public function lessonWatched($lang , $user , $scountry , Request $request)
    {

        $user = User::find($user);

        if($user->course_orders->where('course_id' , $request->course)->where('status' , 'done')->count() == 0){

            $course = Course::find($request->course);

            $count = 0 ;

            foreach($course->chapters as $chapter){

                foreach($chapter->lessons as $lesson){
                    $count = $count + 1 ;
                }
            }

            $average = (1 / $count) * 100 ;
            $average = round($average);

        }else{

            $user_lesson = UserLesson::where('user_id' , $user->id)->where('lesson_id' , $request->lesson)->first();

            $user_lesson->update([
                'watched' => 1 ,
            ]);

            if ($user->course_orders->where('course_id' , $request->course)->where('status' , 'done')->count() > 0){

                $average = 0 ;
                $watched_count = 0 ;
                $sum = 0 ;

                foreach ($user->user_lessons->where('course_id' , $request->course) as $user_lesson) {
                    $sum = $sum + 1 ;
                    if($user_lesson->watched == 1){
                        $watched_count = $watched_count + 1 ;
                    }
                }

                if($watched_count == 0){
                    $average = 0 ;
                }else{

                    $average = ($watched_count/$sum) * 100 ;
                    $average = round($average);

                }

            }


        }






        return $average;


    }

}
