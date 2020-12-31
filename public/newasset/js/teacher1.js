$(document).ready(function(){

    $('#courses').on('change' ,function(){


    var url = $(this).find(':selected').data('url');

    $('#loader').css('display', 'flex');



    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {

            $('#loader').css('display', 'none');
            $('#course-teachers').empty();
            $('#course-teachers').append(data);

        }
    });

    });



    $('.add-homework').on('click' , function(e){


            e.preventDefault();

            var check = $(this).data('check');
            var loader = $(this).data('product');
            var selectid = $(this).data('select');
            var usertype = $(this).data('type');

            loader = '#' + loader;

            if (check == false) {

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
                    var course_id = $('#selectedCourse' + selectid ).find(':selected').data('course_id');


                    $('.homework_services_list').children('.form-group').hide();

                    $.each($('.homework_services_input:checked') , function(){
                        $(this).prop( "checked", false );
                    });

                    var homework_services = '.homework_services' + course_id ;
                    $(homework_services).css('display' , 'block');
                    var teacherid = $('#selectedCourse' + selectid).find(':selected').data('teacher');
                    var totalprice = '#total-price' + teacherid ;
                    var quantity = '#quantitys' + teacherid ;
                    var used_balance = '#used_balance' + teacherid ;

                    $(used_balance).val(0);
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
            var course_id = $('#selectedCourse' + selectid ).find(':selected').data('course_id');
            var homework_services = '.homework_services' + course_id ;

            $.each($('.homework_services_input:checked') , function(){

                $(this).prop( "checked", false );
            });

            $('.homework_services_list').children('.form-group').hide();

            $(homework_services).css('display' , 'block');

            var totalprice = '#total-price' + teacherid ;
            var quantity = '#quantitys' + teacherid ;
            var used_balance = '#used_balance' + teacherid ;

            $(used_balance).val(0);
            $(quantity).val(1);
            $(totalprice).html(price);

        });


        $('body').on('keyup change', '.product-quantity', function() {

            console.log(selectid);

            var quantity = Number($(this).val()); //2
            var price = $('#selectedCourse'  + selectid).find(':selected').data('price');
            var price1 = $('#selectedCourse'  + selectid).find(':selected').data('price');
            var course_id = $('#selectedCourse' + selectid ).find(':selected').data('course_id');
            var homework_services_price = 0 ;

            $.each($('.homework_services_input:checked') , function(){
                homework_services_price += $(this).data('price');
            });

            var teacherid = $('#selectedCourse'  + selectid).find(':selected').data('teacher');
            var totalprice = '#total-price' + teacherid ;
            var used_balance = '#used_balance' + teacherid ;
            var price = (quantity * price) - $(used_balance).val() + (homework_services_price * quantity) ;

            if(price < 0){

                price = price1;
                $(this).val(1);
                $(used_balance).val(0);
                $.each($('.homework_services_input:checked') , function(){

                    $(this).prop( "checked", false );
                });

            }

            $(totalprice).html(price);

        });//end of product quantity change


        $('body').on('keyup change', '.used_balance', function() {


            var used_balance = Number($(this).val());
            var wallet_balance = $(this).data('wallet_balance');

            if(used_balance > wallet_balance){

                $('#balance_alert').modal({
                    keyboard: false
                });

                $('.available-quantity').empty();
                $('.available-quantity').html(wallet_balance);

                $(this).val(wallet_balance);

                used_balance = wallet_balance ;

            }

            if(used_balance < 0 ){

                $(this).val(0);
            }


            var price = $('#selectedCourse'  + selectid).find(':selected').data('price');
            var price1 = $('#selectedCourse'  + selectid).find(':selected').data('price');
            var course_id = $('#selectedCourse' + selectid ).find(':selected').data('course_id');
            var homework_services_price = 0 ;

            $.each($('.homework_services_input:checked') , function(){
                homework_services_price += $(this).data('price');
            });


            var teacherid = $('#selectedCourse'  + selectid).find(':selected').data('teacher');
            var totalprice = '#total-price' + teacherid ;
            var quantitys = '#quantitys' + teacherid ;
            var quantity  = $(quantitys).val() ;
            var price = (quantity * price) - used_balance + (homework_services_price * quantity) ;

            if(price < 0){

                $(this).val(quantity * price1);

                price = 0 ;

            }


            $(totalprice).html(price);

        });//end of product quantity change


  });


  $('.homework_services_input').change(function() {



        var selectid = $(this).data('select');
        console.log(selectid);
        var price = $('#selectedCourse' + selectid).find(':selected').data('price');
        var teacherid = $('#selectedCourse' + selectid).find(':selected').data('teacher');
        var used_balance = '#used_balance' + teacherid ;
        var quantitys = '#quantitys' + teacherid ;
        var quantity = $(quantitys).val();
        var homework_service_price = $(this).data('price');
        var totalprice = '#total-price' + teacherid ;
        var price1 = parseFloat($(totalprice).html());

        if($(this).is(':checked')){

            $(totalprice).html(price1 + (homework_service_price * quantity));

        }else{

            if(price1 - (homework_service_price * quantity) < 0){

                price1 = price ;
                $(used_balance).val(0);
                $(quantitys).val(1);
                $(totalprice).html(price1);

                $.each($('.homework_services_input:checked') , function(){

                    $(this).prop( "checked", false );

                });

                }else{
                    $(totalprice).html(price1 - (homework_service_price * quantity));
                }

        }


});



  $('.orderbtn').on('click' , function(){


    $(this).closest('form').submit();

    $(".orderbtn").off('click');

    });


});
