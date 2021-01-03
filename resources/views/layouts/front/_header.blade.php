                <!-- Header -->

                <div id="header" class="mdk-header mdk-header--bg-dark bg-dark js-mdk-header mb-0" data-effects="parallax-background waterfall" data-fixed data-condenses>
                    <div class="mdk-header__bg">
                        <div class="mdk-header__bg-front" style="background-image: url({{ asset('newasset/images/photodune-4161018-group-of-students-m.jpg') }});"></div>
                    </div>
                    <div class="mdk-header__content justify-content-center">



                        <div class="navbar navbar-expand navbar-dark-dodger-blue bg-transparent will-fade-background" id="default-navbar" data-primary>

                            <!-- Navbar toggler -->
                            <button class="navbar-toggler w-auto mr-16pt d-block rounded-0" type="button" data-toggle="sidebar">
                                <span class="material-icons">short_text</span>
                            </button>

                            <!-- Navbar Brand -->
                            <a href="{{ route('home' , ['lang'=> app()->getLocale() , 'country'=> '1']) }}" class="navbar-brand mr-16pt">
                                <!-- <img class="navbar-brand-icon" src="assets/images/logo/white-100@2x.png" width="30" alt="Luma"> -->

                                <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                                    <span class="avatar-title rounded bg-primary"><img src="{{ asset('newasset/images/illustration/student/128/white.svg') }}" alt="logo" class="img-fluid" /></span>

                                </span>

                                <span class="d-none d-lg-block">iTeaching</span>
                            </a>

                            <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                                <li class="nav-item active">
                                    <a href="{{ route('home' , ['lang'=> app()->getLocale() , 'country'=> '1']) }}" class="nav-link">{{__('Home')}}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">{{__('Educational tracks')}}</a>
                                    <div class="dropdown-menu">
                                        @foreach ($scountry->learning_systems as $learning_system)
                                        <a href="{{route('learning_systems' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$scountry->id])}}" class="dropdown-item">{{ app()->getLocale() == 'ar' ? $learning_system->name_ar : $learning_system->name_en}}</a>
                                        @endforeach
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('home' , ['lang'=>'en' , 'country'=>$scountry->id]) }}">{{ __('English') }}</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="{{route('home' , ['lang'=>'ar' , 'country'=>$scountry->id]) }}">{{ __('Arabic') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false"><img style="width:20px" class="m-1" alt="country-flag" src="{{ asset('storage/' . $scountry->image) }}">{{ app()->getLocale() == 'ar' ? $scountry->name_ar : $scountry->name_en}}</a>
                                    <div class="dropdown-menu">
                                        @foreach ($countries as $country)
                                        @if ($scountry->id == $country->id)

                                        @else

                                        <a href="{{route('home' , ['lang'=>app()->getLocale() , 'country'=>$country->id])}}" class="dropdown-item"><img style="width:20px" class="m-1" alt="country-flag" src="{{ asset('storage/' . $country->image) }}">{{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}}</a>
                                        @endif
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        @guest

                            <ul class="nav navbar-nav ml-auto mr-0">
                                {{-- <li class="nav-item">
                                    <a href="{{ route('cart' , ['lang'=>app()->getLocale() , 'user'=>"islam" , 'country'=>$scountry->id ] ) }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class='badge badge-warning' id='lblCartCount'>0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cart' , ['lang'=>app()->getLocale() , 'user'=>"islam" , 'country'=>$scountry->id ] ) }}">
                                    <i class="fas fa-heart "></i>
                                    <span class='badge badge-warning' id='lblCartCount'>0</span>
                                    </a>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <a href="{{ route('login' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}" class="nav-link" data-toggle="tooltip" data-title="{{ __('Login') }}" data-placement="bottom" data-boundary="window"><i class="material-icons">lock_open</i></a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route('login' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}" class="btn btn-outline-white">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}" class="btn btn-outline-white">{{ __('Register Now') }}</a>
                                </li>
                                @endif
                                @else
                                @php
                                    $userid = Auth::id() ;
                                @endphp
                                <li style="list-style: none" class="nav-item">
                                    <a href="{{ route('cart',['lang'=>app()->getLocale() , 'user'=>$userid, 'country'=>$scountry->id ] ) }}">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span class='badge badge-warning' id='lblCartCount'>{{Auth::user()->cart->products->count()}}</span>
                                    </a>

                                </li>
                                @if (Auth::user()->type == 'student')
                                <li style="list-style: none" class="nav-item">
                                    <a href="{{ route('teacher.favShow',['lang'=>app()->getLocale() , 'user'=>$userid, 'country'=>$scountry->id ] ) }}">
                                        <i class="fas fa-heart"></i>
                                        <span class='badge badge-warning' id='fav_count'>{{Auth::user()->teachers_count}}</span>
                                    </a>

                                </li>
                                @endif

                                <li style="list-style: none" class="nav-item">

                                <!-- Notifications dropdown -->
                                <div class="nav-item ml-10pt dropdown dropdown-notifications dropdown-xs-down-full noty-nav"
                                    data-toggle="tooltip"
                                    data-title="{{__('Notifications')}}"
                                    data-placement="bottom"
                                    data-boundary="window"
                                    data-local="{{app()->getLocale()}}"
                                    style="margin-top: 25px;">
                                <button class="nav-link btn-flush dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown"
                                        data-caret="false">
                                    <i class="material-icons">notifications_none</i>
                                    <span class="badge badge-notifications badge-accent">{{Auth::user()->notifications->where('status' , 0)->count()}}</span>
                                </button>

                                @auth

                                <input class="noty_id" type="hidden"
                                data-id="{{Auth::id()}}"
                                >

                                @endauth

                                <div class="dropdown-menu dropdown-menu-right">
                                    <div data-perfect-scrollbar
                                        class="position-relative"
                                        style="  height:500px;
                                        overflow-y: scroll;">
                                        <div class="dropdown-header d-flex"><strong>{{__('Notifications')}}</strong></div>
                                        <div class="list-group list-group-flush mb-0 noty-list">


                                            @foreach (Auth::user()->notifications()->orderBy('id', 'desc')->limit(50)->get() as $notification)




                                            <a href="{{$notification->url}}"
                                            class="list-group-item list-group-item-action unread noty"
                                            data-url="{{ route('notification-change', ['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'country'=>$scountry->id , 'notification'=>$notification->id ] ) }}">
                                                <span class="d-flex align-items-center mb-1">

                                                    <small class="text-black-50">{{$notification->created_at}}</small>


                                                    @if ($notification->status == 0)
                                                    <span class=" {{app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'}} unread-indicator bg-accent"></span>
                                                    @endif


                                                </span>
                                                <span class="d-flex">
                                                    <span class="avatar avatar-xs mr-2">
                                                        <img src="{{$notification->user_image}}"
                                                            alt="people"
                                                            class="avatar-img rounded-circle">
                                                    </span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="text-black-100" style="{{app()->getLocale() == 'ar' ? 'text-align: right;' : ''}}">{{app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en}}</strong>
                                                        <span class="text-black-70" style="{{app()->getLocale() == 'ar' ? 'text-align: right;' : ''}}">{{app()->getLocale() == 'ar' ? $notification->body_ar : $notification->body_en}}</span>
                                                    </span>
                                                </span>
                                            </a>

                                            @endforeach


                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- // END Notifications dropdown -->

                                </li>





                                <li style="list-style: none; margin-top: 15px;" class="nav-item dropdown user-panel">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                       <span class="pt-2">{{ Auth::user()->name }} </span>
                                       <span class="caret"></span>
                                        <div class="image">
                                            <img src="{{ asset('storage/images/users/' . Auth::user()->profile) }}" class="img-circle elevation-2" alt="User Image">
                                        </div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{route('profile' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('My Profile')}}</a>

                                        @if (Auth::user()->type == 'teacher')

                                        <a class="dropdown-item" href="{{route('finances' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Finances')}}</a>

                                        @endif

                                        <a class="dropdown-item" href="{{route('my-orders' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Orders and downloads')}}</a>

                                        <a class="dropdown-item" href="{{route('wallet' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Wallet')}}</a>


                                        @if (Auth::user()->type == 'teacher')

                                        <a class="dropdown-item" href="{{route('teacher.homework' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('HomeWorks')}}</a>

                                        @endif

                                        @if (Auth::user()->type == 'student')

                                        <a class="dropdown-item" href="{{route('homework' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('My Homework Page')}}</a>

                                        <a class="dropdown-item" href="{{route('my-courses' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('My Courses Page')}}</a>


                                        @endif


                                        <a class="dropdown-item" href="{{route('addresses' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Addresses')}}</a>


                                        <a class="dropdown-item" href="{{route('report' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Complaints and suggestions')}}</a>


                                        <a class="dropdown-item" href="{{ route('logout'  , app()->getLocale()) }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout' , app()->getLocale()) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>






                                    </div>
                                </li>
                            </ul>
                        @endguest
                        </div>
                        <main class="">
                            @yield('welcomContent')
                        </main>
                    </div>
                </div>

                <!-- // END Header -->
