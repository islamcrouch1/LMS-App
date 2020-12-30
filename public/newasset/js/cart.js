$(document).ready(function(){


    $('.viewbtn').on('click' , function(e){
        e.preventDefault();
    });

    $('body').on('click', '.disabled', function(e) {

        e.preventDefault();

    });//end of disabled



    $('.add-cart').on('click' , function(e){
      e.preventDefault();

      var url = $(this).data('url');

      var check = $(this).data('check');

      var product_country = $(this).data('product_country');
      var user_country = $(this).data('user_country');


      console.log(product_country);
      console.log(user_country);


      var method = $(this).data('method');

      var loader = $(this).data('product');
      var cartbtn = $(this).data('cart');

      var productid = $(this).data('productid');

      loader = '#' + loader;

      cartbtn = '#'  + cartbtn;

      productid = '#content-' + productid ;



      if (check == false) {

        $('#exampleModalCenter').modal({
            keyboard: false
          })

        }else{


            if (product_country != user_country) {

                $('#exampleModalCenter1').modal({
                    keyboard: false
                  })

                }else{


                    $(loader).css('display', 'flex');

                    $.ajax({
                        url: url,
                        method: method,
                        success: function(data) {

                            $(loader).css('display', 'none');
                            $(productid).empty();
                            $(productid).append(data);
                            $("#lblCartCount").text(parseInt($("#lblCartCount").text()) + 1);

                        }
                    })

                }

        }



  });


  $('body').on('keyup change', '.product-quantity', function() {

    var quantity = Number($(this).val()); //2

    var stock = $(this).data('stock');

    if ( quantity > stock){

        $('#exampleModalCenter1').modal({
            keyboard: false
          });

          $('.available-quantity').empty();
          $('.available-quantity').html(stock);

          $(this).val(stock);

    }else {

        var unitPrice = parseFloat($(this).data('price')); //150
        $(this).closest('tr').find('.product-price').html((quantity * unitPrice).toFixed(2));
        calculateTotal();
    }



});//end of product quantity change




$('.order-products').on('click', function(e) {

    e.preventDefault();



    var url = $(this).data('url');

    var method = $(this).data('method');

    var loader = $(this).data('loader');

    console.log(loader);

    loader = '#' + loader;

    console.log(loader);


    $(loader).css('display', 'flex');



    $.ajax({
        url: url,
        method: method,
        success: function(data) {


            $('#exampleModalCenter2').modal({
                keyboard: false
              });

            $(loader).css('display', 'none');
            $('#order-product-list').empty();
            $('#order-product-list').append(data);

        }
    })

});//end of order products click


$(".img").change(function() {

    if (this.files && this.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
    $('.img-prev').attr('src', e.target.result);
    }

    reader.readAsDataURL(this.files[0]); // convert to base64 string
    }

    });

    $('body').on('keyup change', '.used_balance1', function() {


        var used_balance = Number($(this).val());

        var wallet_balance = $(this).data('wallet_balance');

        if(used_balance > wallet_balance){

            $('#balance_alert').modal({
                keyboard: false
            });

            $('.available-quantity').empty();
            $('.available-quantity').html(wallet_balance);

            $(this).val(wallet_balance);


        }

        if(used_balance < 0 ){

            $(this).val(0);
        }


        calculateTotal();





    });//end of product quantity change



});



function calculateTotal() {

    var price = 0;
    var price1 = 0;

    var used_balance = parseFloat($('.used_balance1').val());

    var shipping = parseFloat($('.shipping_fee').html());


    $('.order-list .product-price').each(function(index) {

        price += parseFloat($(this).html().replace(/,/g, ''));

    });//end of product price

    price = price - used_balance + shipping ;

    if(price < '0'){

        $('.order-list .product-price').each(function(index) {

            price1 += parseFloat($(this).html().replace(/,/g, ''));

        });//end of product price

        $('.used_balance').val(price1 + shipping)

        price = 0 ;

    }

    $('.total-price').html(price.toFixed(2));

    //check if price > 0
    if (price > 0) {

        $('#add-order-form-btn').removeClass('disabled')

    } else {

        $('#add-order-form-btn').addClass('disabled')

    }//end of else

}//end of calculate total
