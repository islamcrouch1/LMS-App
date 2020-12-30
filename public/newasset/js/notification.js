$(document).ready(function(){



    var locale = $('.noty-nav').data('local');

    let id = $('.noty_id').data('id');



    console.log(id);


    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('new-notification');
    // Bind a function to a Event (the full Laravel class)
    channel.bind('notification-event', function (data) {

        console.log(data.user_id);

        if(id == data.user_id){
            var count = $('.badge-accent').html();
            $('.badge-accent').html(parseInt(count) + 1);

            var data = `<a href="`+data.url+`"
            class="list-group-item list-group-item-action unread noty"
            data-url="`+data.change_status+`">
                <span class="d-flex align-items-center mb-1">

                    <small class="text-black-50">`+data.date+`</small>


                    <span class="`+((locale == 'ar') ? 'mr-auto' : 'ml-auto') +` unread-indicator bg-accent"></span>


                </span>
                <span class="d-flex">
                    <span class="avatar avatar-xs mr-2">
                        <img src="`+data.user_image+`"
                            alt="people"
                            class="avatar-img rounded-circle">
                    </span>
                    <span class="flex d-flex flex-column">
                        <strong class="text-black-100" style="`+((locale == 'ar') ? 'text-align: right;' : '')+`">`+((locale == 'ar') ? data.title_ar : data.title_en)+`</strong>
                        <span class="text-black-70" style="`+((locale == 'ar') ? 'text-align: right;' : '')+`">`+((locale == 'ar') ? data.body_ar : data.body_en)+`</span>
                    </span>
                </span>
            </a>`;

            $('.noty-list').prepend(data);
        }






    });



        $(document).on('click', '.noty', function (e) {



            e.preventDefault();

            let url = $(this).data('url');

            let link_target = $(this).attr('href');


            console.log(url)

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {


                    window.location.href = link_target;

                }
            });//end of ajax call


        });//end of on click fav icon





});
