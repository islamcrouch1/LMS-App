        <!-- drawer -->
        <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
            <div class="mdk-drawer__content">
                <div class="sidebar sidebar-dark-dodger-blue sidebar-left" data-perfect-scrollbar>


                    <div class="d-flex align-items-center navbar-height">
                        <form action="fixed-index.html" class="search-form search-form--black mx-16pt pr-0 pl-16pt">
                            <input type="text" class="form-control pl-0" placeholder="{{__('search')}}">
                            <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        </form>
                    </div>



                    <a href="{{ route('home' , ['lang'=> app()->getLocale() , 'country'=> '1']) }}" class="sidebar-brand ">
                        <!-- <img class="sidebar-brand-icon" src="assets/images/illustration/student/128/white.svg" alt="Luma"> -->

                        <span class="avatar avatar-xl sidebar-brand-icon h-auto">

                            <span class="avatar-title rounded bg-primary"><img src="{{ asset('newasset/images/illustration/student/128/white.svg') }}" class="img-fluid" alt="logo" /></span>

                        </span>

                        <span>ALMS</span>
                    </a>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item active">
                            <a class="sidebar-menu-button" href="fixed-index.html">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
                                <span class="sidebar-menu-text">{{__('Home')}}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item active open">
                            <a class="sidebar-menu-button js-sidebar-collapse" data-toggle="collapse" href="#language_menu">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">language</span>
                                {{__('Select Language')}}
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse sm-indent" id="language_menu">
    
                                <li class="sidebar-menu-item {{ app()->getLocale() == 'en' ? 'active' : ''}}" >
                                    <a class="sidebar-menu-button dropdown-item" href="{{route('home' , ['lang'=>'en' , 'country'=>'1']) }}"><span class="sidebar-menu-text">{{ __('English') }}</span></a>
                                </li>
                                
                                <li class="sidebar-menu-item {{ app()->getLocale() == 'ar' ? 'active' : ''}}" >
                                    <a class="sidebar-menu-button dropdown-item" href="{{route('home' , ['lang'=>'ar' , 'country'=>'1']) }}"><span class="sidebar-menu-text">{{ __('Arabic') }}</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-menu-item active open mt-1">
                            <a class="sidebar-menu-button js-sidebar-collapse" data-toggle="collapse" href="#country_menu">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">flag</span>
                                {{__('Select Country')}}
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse sm-indent" id="country_menu">
    
                                @foreach ($countries as $country)
                                <li class="sidebar-menu-item {{$scountry->id == $country->id ? 'active' : ''}}">
                                <a class="sidebar-menu-button" href="{{route('home', ['lang'=>app()->getLocale() , 'country'=>$country->id])}}" class="dropdown-item"><span class="sidebar-menu-text">{{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}}</span></a>
                                </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="sidebar-menu-item mt-1">
                            <a class="sidebar-menu-button js-sidebar-collapse" data-toggle="collapse" href="#enterprise_menu">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">style</span>
                                {{__('Educational tracks')}}
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse sm-indent" id="enterprise_menu">
                                
                                    @foreach ($scountry->learning_systems as $learning_system)
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="{{route('learning_systems' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$scountry->id])}}" class="dropdown-item"><span class="sidebar-menu-text">{{ app()->getLocale() == 'ar' ? $learning_system->name_ar : $learning_system->name_en}}</span></a>
                                    </li>
                                    @endforeach

                            </ul>
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
        <!-- // END drawer -->