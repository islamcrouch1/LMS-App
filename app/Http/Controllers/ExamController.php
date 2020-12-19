<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\ExamUser;
use App\Exam;
use App\Question;
use App\Country;
use App\User;
use App\Link;
use App\Course;
use App\Lesson;


class ExamController extends Controller
{
    public function index($lang , $user , $country , Request $request)
    {
        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        $links = Link::all();
        $course = Course::findOrFail($request->course);

        $slesson = Lesson::find($request->lesson);



        $exam = Exam::findOrFail($request->exam);

        $questions = Question::where('exam_id' , $exam->id)->get();

        $user = User::findOrFail($user);

        return view('exam' ,  compact('countries' , 'scountry' , 'user'  , 'links' , 'questions' , 'exam' ,'course' , 'slesson'));
    }


    public function saveResult($lang , $user , $country , Request $request)
    {

        $user = User::findOrFail($user);


        if(ExamUser::where('exam_id' , $request->exam)->where('user_id' , $user->id)->first() == null){

            $exam_result = ExamUser::create([
                'user_id' => $user->id,
                'exam_id' => $request->exam,
                'result' => $request->result,
             ]);

        }else{
            $exam_result = ExamUser::where('exam_id' , $request->exam)->where('user_id' , $user->id)->first();
            $exam_result->update([
                'result' => $request->result,
            ]);
        }




         return redirect()->route('exam.show' , ['lang'=>app()->getLocale() ,'user'=>$user->id , 'exam_result'=>$exam_result , 'country'=>$country , 'course'=>$request->course]);


    }

    public function showResult($lang , $user , $country , Request $request)
    {

        $user = User::findOrFail($user);

        $scountry = Country::findOrFail($country);

        $countries = Country::all();
        $links = Link::all();

        $course = Course::findOrFail($request->course);




        $exam_result = ExamUser::findOrFail($request->exam_result);



        return view('exam-result' ,  compact('countries' , 'scountry' , 'user'  , 'links' , 'exam_result' , 'course'));


    }


}
