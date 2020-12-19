<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exam;
use App\Question;
use App\Country;
use App\Lesson;


class QuestionsController extends Controller
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

        $exam = Exam::findOrFail($request->exam);

        $questions = Question::where('exam_id' , $exam->id)->whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.questions.index')->with('questions' , $questions)->with('country' , $country)->with('exam' , $exam);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {
        $country = Country::findOrFail($request->country);

        $exam = Exam::findOrFail($request->exam);
        return view('dashboard.questions.create')->with('country' , $country)->with('exam' , $exam);
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

            'question' => "required|string|max:255",
            'answer1' => "required|string|max:255",
            'answer2' => "required|string|max:255",
            'answer3' => "required|string|max:255",
            'answer4' => "required|string|max:255",
            'true_answer' => "required|string|max:255",
            'answer_time' => "required|integer|max:255",


            ]);


            $question = Question::create([
                'question' => $request['question'],
                'answer1' => $request['answer1'],
                'answer2' => $request['answer2'],
                'answer3' => $request['answer3'],
                'answer4' => $request['answer4'],
                'true_answer' => $request['true_answer'],
                'answer_time' => $request['answer_time'],
                'exam_id' => $request->exam,
            ]);


            session()->flash('success' , 'question created successfully');
            return redirect()->route('questions.index' , ['lang'=>app()->getLocale() , 'exam'=>$request->exam , 'country'=>$request->country]);
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
    public function edit($lang , $question ,Request $request)
    {

        $country = Country::findOrFail($request->country);
        $exam = Exam::findOrFail($request->exam);
        $question = Question::find($question);
        $country = Country::findOrFail($request->country);
        return view('dashboard.questions.edit ')->with('question', $question)->with('exam' , $exam)->with('country' , $country);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Question $question)
    {

        $request->validate([

            'question' => "required|string|max:255",
            'answer1' => "required|string|max:255",
            'answer2' => "required|string|max:255",
            'answer3' => "required|string|max:255",
            'answer4' => "required|string|max:255",
            'true_answer' => "required|string|max:255",
            'answer_time' => "required|integer|max:255",

            ]);



            $question->update([
                'question' => $request['question'],
                'answer1' => $request['answer1'],
                'answer2' => $request['answer2'],
                'answer3' => $request['answer3'],
                'answer4' => $request['answer4'],
                'true_answer' => $request['true_answer'],
                'answer_time' => $request['answer_time'],
            ]);







            session()->flash('success' , 'question updated successfully');
            return redirect()->route('questions.index' , ['lang'=>app()->getLocale() , 'exam'=>$request->exam , 'country'=>$request->country]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $question ,Request $request)
    {

        $question = Question::withTrashed()->where('id' , $question)->first();

        if($question->trashed()){

            if(auth()->user()->hasPermission('questions-delete')){
                $question->forceDelete();

                session()->flash('success' , 'question Deleted successfully');

                $questions = Question::where('exam_id' , $request->exam)
                ->onlyTrashed()
                ->whenSearch(request()->search)
                ->paginate(5);
                $country = Country::findOrFail($request->country);
                $exam = Exam::findOrFail($request->exam);
                return view('dashboard.questions.index')->with('questions' , $questions)->with('country' , $country)->with('exam' , $exam);

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $questions = Question::where('exam_id' , $request->exam)
                ->onlyTrashed()
                ->whenSearch(request()->search)
                ->paginate(5);
                $country = Country::findOrFail($request->country);
                $exam = Exam::findOrFail($request->exam);
                return view('dashboard.questions.index')->with('questions' , $questions)->with('country' , $country)->with('exam' , $exam);

            }



        }else{

            if(auth()->user()->hasPermission('questions-trash')){
                $question->delete();

                session()->flash('success' , 'question trashed successfully');
                return redirect()->route('questions.index' , ['lang'=>app()->getLocale() , 'exam'=>$request->exam , 'country'=>$request->country]);

            }else{

                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('questions.index' , ['lang'=>app()->getLocale() , 'exam'=>$request->exam , 'country'=>$request->country]);

            }

        }


    }


    public function trashed(Request $request)
    {

        $questions = Question::where('exam_id' , $request->exam)
        ->onlyTrashed()
        ->whenSearch(request()->search)
        ->paginate(5);
        $country = Country::findOrFail($request->country);
        $exam = Exam::findOrFail($request->exam);
        return view('dashboard.questions.index')->with('questions' , $questions)->with('country' , $country)->with('exam' , $exam);

    }

    public function restore( $lang , $question , Request $request)
    {

        $question = question::withTrashed()->where('id' , $question)->first()->restore();

        session()->flash('success' , 'question restored successfully');
        return redirect()->route('questions.index' , ['lang'=>app()->getLocale() , 'exam'=>$request->exam , 'country'=>$request->country]);

    }
}
