$(document).ready(function(){
    $('#video_input_file').on('change' ,function(){

        $('#lesson_form').css('display' , 'block');
        $('#video_input_wrapper').css('display' , 'none');

        var url = $(this).data('url');
        var local = $(this).data('local');
        var lessonId = $(this).data('lesson-id');


        console.log(lessonId);
        var lesson = this.files[0];
        var lessonName = lesson.name.split('.').slice(0, -1).join('.');

        $('#name_ar').val(lessonName);
        $('#name_en').val(lessonName);

        var formData = new FormData();
        formData.append('lesson_id' , lessonId);
        formData.append('name' , lessonName);
        formData.append('lesson' , lesson );


        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function (lessonBeforeProcessing) {

                var interval = setInterval(function () {

                    $.ajax({
                        url: `${lessonBeforeProcessing.id}`,
                        method: 'GET',
                        success: function (lessonWhileProcessing) {

                            $('#lesson-status').html('Processing...');
                            $('#video_progress').css('width', lessonWhileProcessing.percent + '%');
                            $('#video_progress').html(lessonWhileProcessing.percent + '%');

                            if (lessonWhileProcessing.percent == 100) {
                            
                                clearInterval(interval);
                                $('#lesson-status').html('Done Processing');
                                $('#video_progress').parent().css('display', 'none');
                                $('#lesson_submit').css('display', 'block');
                            }
                        },
                    });//end of ajax call

                }, 3000)

            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round(evt.loaded / evt.total * 100) + "%";
                        $('#video_progress').css('width', percentComplete).html(percentComplete)
                    }
                }, false);
                return xhr;
            },
        });//end of ajax call

       


    });
});