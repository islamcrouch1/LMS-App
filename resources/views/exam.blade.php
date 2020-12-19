@extends('layouts.front.app')



@section('content')

@if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() > 0 || $slesson->type == 0)


            <input class="questions_data" type="hidden"
            data-questions_no="{{$questions->count()}}"
            data-questions="{{$questions}}"
            data-locale="{{app()->getLocale()}}"
            >

            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content page-content ">

                <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm"
                     style="white-space: nowrap;">
                    <div class="container page__container">
                        <nav class="nav navbar-nav">
                            <div class="nav-item navbar-list__item">
                                @if ($slesson != null)
                                <a href="{{route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$slesson->id  , 'country'=>$scountry->id , 'course'=>$course->id])}}"
                                    class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> {{__('Back to Lesson')}}</a>
                                @else
                                <a href="{{route('courses' , ['lang'=>app()->getLocale() , 'course'=>$course->id , 'country'=>$scountry->id])}}"
                                    class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> {{__('Back to Course')}}</a>
                                @endif

                            </div>
                        </nav>
                    </div>
                </div>

                <div class="bg-primary pb-2">
                    <div class="container page__container">

                        <div class="d-flex flex-wrap align-items-end justify-content-end">
                            <h3 class="text-white flex m-0">{{__('No Of Questions : ') . $questions->count() }}</h3>
                            <h2 class="text-white-50 font-weight-light m-0 counter_down"></h2>
                        </div>

                    </div>
                </div>

                <div class="navbar navbar-expand-md navbar-list navbar-light bg-white border-bottom-2 "
                     style="white-space: nowrap;">
                    <div class="container page__container">
                        <ul class="nav navbar-nav flex navbar-list__item">
                            <li class="nav-item">
                                <i class="material-icons text-50 mr-8pt ml-8pt">tune</i>
                                {{__('Choose the correct answer below:')}}
                            </li>
                        </ul>
                        <div class="nav navbar-nav ml-sm-auto navbar-list__item">
                            <div class="nav-item d-flex flex-column flex-sm-row ml-sm-16pt">
                                <a href="#"
                                   class="btn justify-content-center btn-accent w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt next">{{__('Next Question')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container page__container">
                    <div class="page-section">

                        <p style="color:#444" class="hero__lead measure-hero-lead  question"></p>

                        <div class="page-separator">
                            <div class="page-separator__text">{{__('Your Answer')}}</div>
                        </div>
                        <div class="form-check form-group row">
                            <input class="form-check-input" type="radio" name="answer" id="answer1" value="answer1">
                            <label style="margin-right:10px" class="form-check-label answer1" for="answer1">

                            </label>
                        </div>
                        <div class="form-check form-group row">
                            <input class="form-check-input" type="radio" name="answer" id="answer2" value="answer2">
                            <label style="margin-right:10px" class="form-check-label answer2" for="answer2">

                            </label>
                        </div>
                        <div class="form-check form-group row">
                            <input class="form-check-input" type="radio" name="answer" id="answer3" value="answer3">
                            <label style="margin-right:10px" class="form-check-label answer3" for="answer3">

                            </label>
                        </div>
                        <div class="form-check form-group row">
                            <input class="form-check-input" type="radio" name="answer" id="answer4" value="answer4">
                            <label style="margin-right:10px" class="form-check-label answer4" for="answer4">

                            </label>
                        </div>

                    </div>
                </div>

                @if ($slesson != null)
                <form action="{{ route('exam.save' , ['lang'=>app()->getLocale() , 'exam'=>$slesson->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id ])}}" method="post" id="examform">
                    @csrf
                    <input class="exam_result" type="hidden" name="result" value="">
                </form>
                @else
                <form action="{{ route('exam.save' , ['lang'=>app()->getLocale() , 'exam'=>$course->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id ])}}" method="post" id="examform">
                    @csrf
                    <input class="exam_result" type="hidden" name="result" value="">
                </form>
                @endif



            </div>
            <!-- // END Header Layout Content -->

            @else

            <div class="page-section border-bottom-2">
                <div class="container page__container">
                    <div class="page-separator pt-1 pb-1">
                        <div class="page-separator__text">{{ __('You are not authorized to access this page') }}</div>
                    </div>


                    <div class="card text-center">
                        <div class="card-header">
                          {{__('You are not authorized to access this page')}}
                        </div>
                        <div class="card-body">
                          <a href="{{ route('login' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}" class="btn btn-primary">{{__('Go To Home Page')}}</a>
                        </div>
                      </div>

                </div>
            </div>




            @endif

@endsection




@push('scripts-front')

    <script>



        let questions_no = $('.questions_data').data('questions_no');
        let questions = $('.questions_data').data('questions');
        let locale = $('.questions_data').data('locale');


        var count_right_answers = 0 ;

        var result = 0;

        var counter = 1 ;
        var index = 0 ;

        var startMinute = parseInt(questions[index].answer_time);
        var time = startMinute * 60;


        setInterval(updateCountdown , 1000);


        $('.question').append(counter + ' - ' + questions[index].question);
        $('.answer1').html(questions[index].answer1);
        $('.answer2').html(questions[index].answer2);
        $('.answer3').html(questions[index].answer3);
        $('.answer4').html(questions[index].answer4);


        index = index + 1;


        $('.next').on('click' , function(e){

            e.preventDefault();

            var answer = $('input[name="answer"]:checked').val();


            if(answer == questions[index - 1].true_answer){
                count_right_answers = count_right_answers + 1;
            }

            console.log('answer = ' + answer);
            console.log('true_answer = ' + questions[index - 1].true_answer);
            console.log('count_right_answers = ' + count_right_answers);

            $('input[name="answer"]:checked').prop("checked", false);


            if(index < questions_no){
                startMinute = parseInt(questions[index].answer_time);
                time = startMinute * 60;



                $('.question').empty();
                $('.question').append((index + 1) + ' - ' + questions[index].question);

                $('.answer1').empty();
                $('.answer2').empty();
                $('.answer3').empty();
                $('.answer4').empty();

                $('.answer1').html(questions[index].answer1);
                $('.answer2').html(questions[index].answer2);
                $('.answer3').html(questions[index].answer3);
                $('.answer4').html(questions[index].answer4);

                index = index + 1;
                if(index == questions_no){

                    if(locale == 'ar'){
                    $('.next').html('انهاء الإختبار');
                    }else if(locale == 'en'){
                        $('.next').html('End the exam');
                    }

                }
            }else{

                result = (count_right_answers / questions_no) * 100 ;
                result = Math.round(result);
                $('.exam_result').val(result);
                $('#examform').submit();

                console.log('a7aaaaaaa')
                // $('.next').click();
            }

        });


        function updateCountdown(){

        var minutes = Math.floor(time / 60);
        var seconds = time % 60 ;

        seconds < startMinute ? '0' + seconds : seconds;

        $('.counter_down').html(minutes + ':' + seconds)


        if(minutes == 0 && seconds == 0){

            var answer = $('input[name="answer"]:checked').val();


            if(answer == questions[index - 1].true_answer){
                count_right_answers = count_right_answers + 1;
            }

            console.log('answer = ' + answer);
            console.log('true_answer = ' + questions[index - 1].true_answer);
            console.log('count_right_answers = ' + count_right_answers);

            $('input[name="answer"]:checked').prop("checked", false);


            if(index < questions_no){

            startMinute = parseInt(questions[index].answer_time);
            time = startMinute * 60;

            $('.question').empty();
            $('.question').append((index + 1 ) + ' - ' + questions[index].question);

            $('.answer1').empty();
            $('.answer2').empty();
            $('.answer3').empty();
            $('.answer4').empty();

            $('.answer1').html(questions[index].answer1);
            $('.answer2').html(questions[index].answer2);
            $('.answer3').html(questions[index].answer3);
            $('.answer4').html(questions[index].answer4);

            index = index + 1;
            if(index == questions_no){

                if(locale == 'ar'){
                $('.next').html('انهاء الإختبار');
                }else if(locale == 'en'){
                    $('.next').html('End the exam');
                }

            }
            }else{

                result = (count_right_answers / questions_no) * 100 ;
                result = Math.round(result);
                $('.exam_result').val(result);
                $('#examform').submit();

                console.log('done')


            }

        }else{
            time--;
        }


        }
                // $.ajax({
                //     url: "ssssss",
                //     method: 'GET',
                //     success: function (data) {


                //     },
                // });



    </script>

@endpush
