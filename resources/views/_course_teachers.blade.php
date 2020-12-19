<style>

    .fa-star{
        color: #444 !important;
    }

    .checked{
      color: #fd4 !important;
    }

    </style>







            <div class="row card-group-row pt-5">

                @foreach ($users->reverse() as $user)

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
            <div class="modal-body">

                <div class="form-group row">
                    <label for="course" class="col-md-4 col-form-label">{{ __('Select Course') }}</label>
                    <div class="col-md-8">
                        <select style="height: 50px;" class=" form-control @error('course') is-invalid @enderror" id="selectedCourse{{$user->user->id}}" name="selectedCourse" value="{{ old('course') }}" required autocomplete="course">
                        {{-- <option value="0">{{ __('Select Course') }}</option> --}}
                        @foreach ($user->user->courses as $course)
                        <option data-teacher="{{$user->user->id}}" data-price="{{$course->homework_price}}" value="{{ $course->id }}">{{ app()->getLocale() =='ar' ? $course->name_ar : $course->name_en }} {{' - '}} {{ app()->getLocale() =='ar' ? $course->ed_class->name_ar : $course->ed_class->name_en }}</option>
                        @endforeach
                        </select>
                        @error('course')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="course" class="col-md-8 col-form-label">{{ __('Select the number of times you want the service') }}</label>
                    <div class="col-md-4">
                        <input id="quantitys{{$user->user->id}}" type="number" name="quantity" class="form-control input-sm product-quantity" min="1" value="1">
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





    <script>




        $(document).ready(function(){

            $('.add-homework').on('click' , function(e){


                    e.preventDefault();

                    var url = $(this).data('url');

                    var check = $(this).data('check');

                    var method = $(this).data('method');

                    var loader = $(this).data('product');
                    var selectid = $(this).data('select');

                    var usertype = $(this).data('type');

                    loader = '#' + loader;




                    if (check == false) {

                    console.log(usertype);

                    $('#exampleModalCenter').modal({
                        keyboard: false
                        });

                    }else{

                        if(usertype == 'teacher'){

                            $('#exampleModalCenter1').modal({
                                keyboard: false
                            });

                        }else{


                            $('#selectedCourse' + selectid + ' option').first().prop('selected', true);

                            var price = $('#selectedCourse' + selectid ).find(':selected').data('price');

                            var teacherid = $('#selectedCourse' + selectid).find(':selected').data('teacher');


                            var totalprice = '#total-price' + teacherid ;


                            var quantity = '#quantitys' + teacherid ;


                            $(quantity).val(1);


                            $(totalprice).html(price);

                            var modal = '#exampleModalCenter2' + teacherid ;


                            $(modal).modal({
                                keyboard: false
                            })

                        }


                    }


                $('#selectedCourse' + selectid).change(function() {

                    var price = $('#selectedCourse' + selectid).find(':selected').data('price');

                    var teacherid = $('#selectedCourse' + selectid).find(':selected').data('teacher');


                    var totalprice = '#total-price' + teacherid ;

                    var quantity = '#quantitys' + teacherid ;


                    $(quantity).val(1);


                    $(totalprice).html(price);

                });


                $('body').on('keyup change', '.product-quantity', function() {

                    var quantity = Number($(this).val()); //2

                    var price = $('#selectedCourse'  + selectid).find(':selected').data('price');


                    var teacherid = $('#selectedCourse'  + selectid).find(':selected').data('teacher');


                    var totalprice = '#total-price' + teacherid ;


                    $(totalprice).html((quantity * price));




                });//end of product quantity change




          });



          $('.orderbtn').on('click' , function(){


            $(this).closest('form').submit();

            $(".orderbtn").off('click');

            });


        });



        </script>




