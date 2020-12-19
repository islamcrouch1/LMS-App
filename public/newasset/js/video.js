$(document).ready(function(){
    $('#video_input_file').on('change' ,function(){

        $('#lesson_form').css('display' , 'block');
        $('#video_input_wrapper').css('display' , 'none');

        var url = $(this).data('url');
        var urlp = $(this).data('urlp');
        var locale = $(this).data('local');
        var lessonId = $(this).data('lesson-id');


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
                        url: urlp ,
                        method: 'GET',
                        success: function (lessonWhileProcessing) {


                            if(locale == 'ar'){
                                $('#lesson-status').html('جاري معالجة الفيديو الخاص بك , يرجى عدم اعادة تحميل الصفحة حتى انتهاء المعالجة');
                            }else{
                                $('#lesson-status').html('Processing...');
                            }

                            console.log(lessonWhileProcessing.percent);

                            $('#video_progress').css('width', lessonWhileProcessing.percent + '%');
                            $('#video_progress').html(lessonWhileProcessing.percent + '%');

                            if (lessonWhileProcessing.percent == 100) {

                                clearInterval(interval);
                                if(locale == 'ar'){
                                    $('#lesson-status').html('تم الانتهاء من معالجة الفيديو , الرجاء اعادة تحميل الصفحة لمشاهدة الفيديو الخاص بك');
                                }else{
                                    $('#lesson-status').html('Done Processing , Please Refresh the page');
                                }
                                $('#video_progress').parent().css('display', 'none');
                                $('#video_div').css('display', 'block');
                                $('#video_div').empty();

                            }
                        },
                    });//end of ajax call

                }, 3000)

            },error: function (jqXHR, status, err) {
                alert("هناك خطا");
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
