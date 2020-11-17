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

                                <span class="d-none d-lg-block">ALMS</span>
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
                                    <a class="nav-link" href="{{route('home' , ['lang'=>'en' , 'country'=>'1']) }}">{{ __('English') }}</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="{{route('home' , ['lang'=>'ar' , 'country'=>'1']) }}">{{ __('Arabic') }}</a>
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
                                <li class="nav-item">
                                    <a href="{{ route('cart',['lang'=>app()->getLocale() , 'user'=>"islam" , 'country'=>$scountry->id ] ) }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class='badge badge-warning' id='lblCartCount'>0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('login' , app()->getLocale()) }}" class="nav-link" data-toggle="tooltip" data-title="{{ __('Login') }}" data-placement="bottom" data-boundary="window"><i class="material-icons">lock_open</i></a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register' , app()->getLocale()) }}" class="btn btn-outline-white">{{ __('Register Now') }}</a>
                                </li>
                                @endif
                                @else
                                @php
                                    $userid = Auth::id() ;
                                @endphp
                                <li style="list-style: none" class="nav-item">
                                    <a href="{{ route('cart',['lang'=>app()->getLocale() , 'user'=>$userid, 'country'=>$scountry->id ] ) }}">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span class='badge badge-warning' id='lblCartCount'>{{Auth::check() ? Auth::user()->cart->products->count() : '0'}}</span>
                                    </a>

                                </li>
                                <li style="list-style: none; margin-top: 15px;" class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{route('my-orders' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Orders and downloads')}}</a>


                                        <a class="dropdown-item" href="{{route('addresses' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Addresses')}}</a>


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
