@extends('layouts.front.app')



@section('content')

<div class="container page__container">


<div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $learning_system->name_ar : $learning_system->name_en}}</div>
</div>



<div class="row card-group-row mb-lg-8pt">
    @foreach ($learning_system->stages as $stage)
    <div class="col-sm-4 card-group-row__col" style="cursor: pointer">
        <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center">
                    <div class="flex">
                        <div class="d-flex align-items-center">
                            {{-- <div class="rounded mr-12pt z-0 o-hidden">
                                <div class="overlay">
                                    <img src="assets/images/paths/react_40x40@2x.png" width="40" height="40" alt="Angular" class="rounded">
                                    <span class="overlay__content overlay__content-transparent">
                                        <span class="overlay__action d-flex flex-column text-center lh-1">
                                            <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                        </span>
                                    </span>
                                </div>
                            </div> --}}
                            <div class="flex">
                                <div class="card-title">{{ app()->getLocale() == 'ar' ? $stage->name_ar : $stage->name_en}}</div>
                            <p class="flex text-black-50 lh-1 mb-0"><small></small></p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="popoverContainer d-none">


            @foreach ($stage->ed_classes as $ed_class)
            <div class="col-sm-12 card-group-row__col ">
                <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">
        
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <div class="flex">
                                <div class="d-flex align-items-center">
                                    <div class="flex">
                                       <a href="{{route('ed_classes' , ['lang'=>app()->getLocale() , 'ed_class'=>$ed_class->id , 'country'=>$scountry->id])}}"> <div class="card-title">{{ app()->getLocale() == 'ar' ? $ed_class->name_ar : $ed_class->name_en}}</div></a>
                                    <p class="flex text-black-50 lh-1 mb-0"><small></small></p>
                                    </div>
                                </div>
                            </div>        
                        </div>
        
        
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    @endforeach
</div>



</div>

@endsection
