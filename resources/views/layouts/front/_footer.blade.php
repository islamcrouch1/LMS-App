<div class="js-fix-footer2 bg-white border-top-2 footer">
    <div class="container page__container page-section d-flex flex-column">
        <div class="row">


            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{__('Important Links')}}</li>
                    @foreach ($links as $link)
                    <li class="list-group-item"><a target="_blank" href="{{$link->url}}">{{ app()->getLocale() == 'ar' ? $link->name_ar : $link->name_en}}</a></li>
                    @endforeach

                </ul>
            </div>


            <div class="col-md-6">
                <p class="text-70 brand mb-24pt">
                    <img class="brand-icon" src="{{ asset('newasset/images/logo/black-70@2x.png') }}" width="30" alt="Luma"> ALMS
                </p>
                <p class="measure-lead-max text-50 small mr-8pt">{{__('ALMS is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.')}}</p>
                {{-- <p class="mb-8pt d-flex">
                    <a href="" class="text-70 text-underline mr-8pt small">Terms</a>
                    <a href="" class="text-70 text-underline small">Privacy policy</a>
                </p> --}}
                <p class="text-50 small mt-n1 mb-0">{{__('Copyright 2020')}} &copy; {{__('All rights reserved.')}}</p>
            </div>


            <div class="col-md-12 m-2">
                <a href="{{ setting('facebook_link') }}" >
                    <img style="width:40px; padding:5px;" src="{{asset('newasset/images/socila-media/facebook-black-18dp.svg')}}" alt="">
                </a>
                <a href="{{ setting('youtube_link') }}" >
                    <img style="width:40px; padding:5px" src="{{asset('newasset/images/socila-media/iconfinder_1_Youtube_colored_svg_5296521.svg')}}" alt="">
                </a>
                <a href="{{ setting('twitter_link') }}" >
                    <img style="width:40px; padding:5px" src="{{asset('newasset/images/socila-media/iconfinder_1_Twitter2_colored_svg_5296515.svg')}}" alt="">
                </a>
                <a href="{{ setting('instagram_link') }}" >
                    <img style="width:40px; padding:5px" src="{{asset('newasset/images/socila-media/iconfinder_1_Instagram_colored_svg_1_5296765.svg')}}" alt="">
                </a>
                <a href="{{ setting('snapchat_link') }}" >
                    <img style="width:40px; padding:5px" src="{{asset('newasset/images/socila-media/iconfinder_1_Snapchat_colored_svg_5296508.svg')}}" alt="">
                </a>
                <a href="{{ setting('whatsapp_link') }}" >
                    <img style="width:40px; padding:5px" src="{{asset('newasset/images/socila-media/iconfinder_1_Whatsapp2_colored_svg_5296520.svg')}}" alt="">
                </a>

            </div>

        </div>
    </div>
</div>


{{-- <div class="bg-white border-top-2 mt-auto">
    <div class="container page__container page-section d-flex flex-column">



        <div class="row">
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{__('Important Links')}}</li>
                    @foreach ($links as $link)
                    <li class="list-group-item"><a target="_blank" href="{{$link->url}}">{{ app()->getLocale() == 'ar' ? $link->name_ar : $link->name_en}}</a></li>
                    @endforeach

                </ul>
            </div>



            <div class="col-md-6">
                <p class="text-70 brand mb-24pt">
                    <img class="brand-icon" src="{{ asset('newasset/images/logo/black-70@2x.png') }}" width="30" alt="Luma"> ALMS
                </p>
                <p class="measure-lead-max text-50 small mr-8pt">{{__('ALMS is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.')}}</p>
                <p class="text-50 small mt-n1 mb-0">{{__('Copyright 2020')}} &copy; {{__('All rights reserved.')}}</p>
            </div>
        </div>



    </div>
</div> --}}
