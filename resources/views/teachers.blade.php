@extends('layouts.front.app')



@section('content')

<style>

    .fa-star{
        color: #444 !important;
    }

    .checked{
      color: #fd4 !important;
    }

    </style>

<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Teachers') }}</div>
        </div>



        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <select id="stages" class="form-control custom-select">
                        <option selected>{{__('Select Stage')}}</option>

                        @foreach ($scountry->stages as $stage)
                            <option value="{{$stage->id}}">{{app()->getLocale() == 'ar' ? $stage->name_ar : $stage->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select id="classes" class="form-control custom-select">
                        <option selected>{{__('Select Class')}}</option>

                        @foreach ($scountry->ed_classes as $class)
                        <option data-foo="{{$class->id}}" value="{{$class->stage_id}}">{{app()->getLocale() == 'ar' ? $class->name_ar : $class->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select id="courses" class="form-control custom-select">
                        <option selected>{{__('Select Course')}}</option>

                        @foreach ($scountry->courses as $course)
                            <option data-url="{{route('teachers.course' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id , 'course'=> $course->id])}}" data-id="{{$course->id}}" value="{{$course->ed_class_id}}">{{app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="col-md-12 d-flex align-items-center">
            <div class="flex"
                 style="max-width: 100%">
                <div style="display:none; position: absolute; left: 50%; top: 35%;"
                 id="loader" class="loader loader-primary loader-lg">
                </div>
            </div>
        </div>

        <div id="course-teachers">

            <div class="row card-group-row pt-5">

                @foreach ($users as $user)

                @if ($user->status == 1 && $user->user->courses->count() > 0)

                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card"
                         data-toggle="popover"
                         data-trigger="click">

                        <a href="{{route('teachers.display' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id , 'user'=> $user->user->id])}}"
                           class="card-img-top"
                           style="height:140px;">
                            <img style="width:100%" src="{{ asset('storage/images/users/' . $user->user->profile) }}"
                                 alt="course">
                            <span class="overlay__content">
                                <span class="overlay__action d-flex flex-column text-center">
                                    <i class="material-icons icon-32pt">play_circle_outline</i>
                                    <span class="card-title text-white">Preview</span>
                                </span>
                            </span>
                        </a>

                        <div style="background: #fff; z-index: 1000000;" class="card-body flex">
                            <div class="d-flex">
                                <div class="flex">
                                    <a class="card-title" style="padding:6px;"
                                       href="{{route('teachers.display' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id , 'user'=> $user->user->id])}}">{{$user->user->name}}</a>
                                </div>

                                @auth
                                <i
                                id="teacher-{{$user->id}}"
                                style="color: #444; font-size: 25px; padding: 6px; cursor: pointer;"
                                class=" {{ $user->is_favored ? 'fas' : 'far' }} fa-heart add-fav"
                                data-url="{{route('teacher.fav' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id , 'user'=> $user->user->id])}}"
                                data-teacher-id="{{$user->id}}"
                                >
                                </i>
                                @else
                                <a href="{{ route('login' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}">
                                    <i style="color: #444; font-size: 25px; padding: 6px; cursor: pointer;" class="far fa-heart"></i>
                                </a>
                                @endauth


                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="rating flex justify-content-center">
                                    @php
                                    $requests = App\HomeWork::where('teacher_id' , $user->user->id)->get();

                                   $average = 0;
                                   $count = 0 ;
                                   $x = 0 ;
                                    @endphp
                                    @foreach ($requests as $request)
                                    @if ($request->averageRating(2)[0] != null)
                                    @php
                                        $count = $count + 1 ;
                                        $average = $average + $request->averageRating(2)[0];
                                    @endphp
                                    @endif
                                    @endforeach
                                    @php
                                        if($count == 0){
                                            $x = $average ;
                                        }else{
                                            $average = $average / $count ;
                                            $average = round($average ) ;
                                            $x = $average ;
                                        }

                                    @endphp
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($average > 0)
                                            <span class="fa fa-star checked"></span>
                                        @php
                                            $average = $average - 1
                                        @endphp
                                        @else
                                            <span class="fa fa-star"></span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                         <div style="z-index: 10000" class="card-footer">
                             <div class="row">
                                 <div class="col-md-12">
                                    <a style="width: 100%"
                                        id="cart-{{$user->user->id}}" class="btn btn-info add-homework" href="#"
                                        @if (Auth::check())
                                        data-url="{{ route('cart.add',['lang'=>app()->getLocale() , 'user'=>$user->user->id , 'product'=>$user->user->id , 'country'=>$scountry->id ] ) }}"
                                        @endif
                                        data-check="{{Auth::check() ? $check = 'true' : $check = 'false'}}"
                                        data-method="get"
                                        data-product="loader-{{$user->user->id}}"
                                        data-select="{{$user->user->id}}"
                                        data-type="{{Auth::check() ? Auth::user()->type : Null}}"
                                        >{{__('Request Homework service')}}
                                    <div id="loader-{{$user->user->id}}" style="display:none" class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    </a>
                                 </div>
                             </div>

                            {{-- <div class="row justify-content-between">
                                <div class="col-auto d-flex align-items-center">
                                    <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                    <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                                </div>
                                <div class="col-auto d-flex align-items-center">
                                    <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                    <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                </div>
                            </div> --}}
                        </div>
                    </div>



                </div>

                @endif

                @endforeach



            </div>

        </div>

        <div class="row mt-3"> {{ $users->appends(request()->query())->links() }}</div>



    </div>
</div>



  <!-- Modal -->
  <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("Please login to make this request, if you don't have account please register one now ....")}}
        </div>
        <div class="modal-footer">
        <a href="{{ route('login' , ['lang'=> app()->getLocale() , 'country'=> $scountry->id]) }}" class="btn btn-primary">{{__("Login")}}</a>
          <a href="{{ route('register', ['lang'=> app()->getLocale() , 'country'=> $scountry->id]) }}" class="btn btn-success">{{__("Register")}}</a>
        </div>
      </div>
    </div>
  </div>


    <!-- Modal -->
    <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{__("Sorry, you can only make this request if you register a student account on the platform .. Thank you for your cooperation")}}
            </div>
          </div>
        </div>
    </div>



    @foreach ($users as $user)

    @if ($user->status == 1 && $user->user->courses->count() > 0)

    @if (Auth::check())
    @php
            $userid = Auth::id();
    @endphp
    @else

    @php
    $userid = "null";
    @endphp

    @endif

    <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2{{$user->user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <form method="POST" action="{{route('homework-order', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$userid , 'teacher'=>$user->user->id]  )}}" enctype="multipart/form-data">
                @csrf

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{__('Specify the order details')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"  style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">

                <div class="form-group row">
                    <label for="course" class="col-md-4 col-form-label">{{ __('Select Course') }}</label>
                    <div class="col-md-8">
                        <select style="height: 50px;" class=" form-control @error('course') is-invalid @enderror"  id="selectedCourse{{$user->user->id}}" name="selectedCourse" value="{{ old('course') }}" required autocomplete="course">
                        {{-- <option value="0">{{ __('Select Course') }}</option> --}}
                        @foreach ($user->user->courses as $course)
                        <option data-teacher="{{$user->user->id}}" data-course_id="{{$course->id . $user->user->id}}" data-price="{{$course->homework_price}}" value="{{ $course->id }}">{{ app()->getLocale() =='ar' ? $course->name_ar : $course->name_en }} {{' - '}} {{ app()->getLocale() =='ar' ? $course->ed_class->name_ar : $course->ed_class->name_en }}</option>
                        @endforeach
                        </select>
                        @error('course')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>


                <div class="homework_services_list">


                    @foreach ($user->user->courses as $course)
                    <div style="display:none" class="form-group homework_services{{$course->id . $user->user->id}}">
                        @if ($course->homework_services->count() > 0)
                        <label class="form-label selsect2" for="select03">{{__('Choose Addon Homework Services')}}</label>
                        @else
                        <label class="form-label selsect2" for="select03">{{__('No Addon Homework Services Availabele')}}</label>
                        @endif
                        <div class="form-check form-check-inline">
                                @foreach ($course->homework_services as $homework_service)
                                <input data-select="{{$user->user->id}}" class="form-check-input homework_services_input" type="checkbox" name="homework_services[]" id="inlineCheckbox1{{$homework_service->id . $course->id . $user->user->id}}" value="{{$homework_service->id}}" data-price="{{$homework_service->price}}">
                                <label class="form-check-label" for="inlineCheckbox1{{$homework_service->id . $course->id . $user->user->id}}">{{ app()->getLocale() == 'ar' ? $homework_service->name_ar : $homework_service->name_en}} {{' - '}} {{   $homework_service->price . ' ' . $homework_service->country->currency }}</label>
                                @endforeach
                        </div>
                    </div>
                    @endforeach


                </div>







                <div class="form-group row">
                    <label for="course" class="col-md-6 col-form-label">{{ __('Select the number of times you want the service') }}</label>
                    <div class="col-md-4">
                        <input id="quantitys{{$user->user->id}}" type="number" name="quantity" class="form-control input-sm product-quantity" min="1" value="1" onkeydown="return false">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="course" class="col-md-6 col-form-label">{{ __('Use from your wallet balance') }}</label>
                    @if (Auth::check())
                        @php
                           $student = App\User::find(Auth::id());
                        @endphp
                    @endif
                    <div class="col-md-4">
                        <input id="used_balance{{$user->user->id}}" type="number" name="used_balance" class="form-control input-sm used_balance" min="0" value="0" data-wallet_balance="{{$student->wallet->balance}}">
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{__('Total : ')}}<span id="total-price{{$user->user->id}}" class="">0</span><span>{{' ' . $user->user->country->currency}}</span></h4>
                        </div>
                        <div class="col-md-4">
                            <a style="color:#fff" type="submit" class="btn btn-primary orderbtn">
                              {{__("Pay Now")}}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
          </div>
        </div>
    </div>


    @endif

    @endforeach


    <div style="z-index: 10000000000000000 !important" class="modal fade" id="balance_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{__("You have exceeded the maximum balance in your wallet, the available balance is now in the wallet: ")}} <span class="available-quantity"></span> {{$scountry->currency}}
            </div>
          </div>
        </div>
      </div>


@endsection



