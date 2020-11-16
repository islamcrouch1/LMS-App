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

      var method = $(this).data('method');
      productid
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



  });


  $('body').on('keyup change', '.product-quantity', function() {

    var quantity = Number($(this).val()); //2

    console.log(quantity);

    var unitPrice = parseFloat($(this).data('price')); //150
    console.log(unitPrice);
    $(this).closest('tr').find('.product-price').html((quantity * unitPrice).toFixed(2));
    calculateTotal();


});//end of product quantity change


});



function calculateTotal() {

    var price = 0;

    $('.order-list .product-price').each(function(index) {

        price += parseFloat($(this).html().replace(/,/g, ''));

    });//end of product price

    $('.total-price').html(price.toFixed(2));

    //check if price > 0
    if (price > 0) {

        $('#add-order-form-btn').removeClass('disabled')

    } else {

        $('#add-order-form-btn').addClass('disabled')

    }//end of else

}//end of calculate total
