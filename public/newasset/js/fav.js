$(document).ready(function () {

    let favCount = $('#fav_count').html();

    $(document).on('click', '.add-fav', function () {

        let url = $(this).data('url');
        let teacherId = $(this).data('teacher-id');
        let isFavored = $(this).hasClass('fas');




        toggleFavorite(url, teacherId, isFavored);

    });//end of on click fav icon


    function toggleFavorite(url, teacherId, isFavored) {

        console.log(url);

        if(!isFavored){
            favCount++;
            $('#teacher-' + teacherId).addClass('fas');
            $('#teacher-' + teacherId).removeClass('far');
        }else{
            favCount--;
            $('#teacher-' + teacherId).addClass('far');
            $('#teacher-' + teacherId).removeClass('fas');
        }

        $('#fav_count').html(favCount);



        // if ($('.movie-' + movieId).closest('.favorite').length) {

        //     $('.movie-' + movieId).closest('.movie').remove();

        // }//end of if

        $.ajax({
            url: url,
            method: 'POST',
        });//end of ajax call

    }

});//end of document ready
