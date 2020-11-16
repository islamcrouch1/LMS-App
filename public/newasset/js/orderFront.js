$(document).ready(function () {




//     //list all order products
//     $('.category-products').on('click', function(e) {


//         e.preventDefault();

//         $('#loading').css('display', 'flex');

//         var url = $(this).data('url');

//         var method = $(this).data('method');


//         $.ajax({
//             url: url,
//             method: method,
//             success: function(data) {


//                 $('#loading').css('display', 'none');
//                 $('#category-product-list').empty();
//                 $('#category-product-list').append(data);

//                 $(function () {
//                     $('[data-toggle="popover"]').popover()
//                 })
//             }
//         })



//     });//end of order products click



});//end of document ready



