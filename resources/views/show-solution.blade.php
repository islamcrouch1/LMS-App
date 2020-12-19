@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Interact with the homework request') }}</div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Data sent by the teacher') }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $homeworkRequest->homework_title}}</h5>
                        <p class="card-text">{!! $homeworkRequest->teacher_note !!}</p>
                        <div class="form-group row">
                            <div class="col-md-10">
                                @if ($homeworkRequest->teacher_image != '#')
                                <img src="{{ asset('storage/images/homework/' . $homeworkRequest->teacher_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                                @endif
                            </div>
                        </div>
                      <a href="{{ $homeworkRequest->teacher_file == '#' ? '#' : asset('storage/homework/files/' . $homeworkRequest->teacher_file) }}" class="btn btn-primary">{{ $homeworkRequest->teacher_file == '#' ? __('No file attached') : __('Download File') }}</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Comments') }}</div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div id="comments">

                    @foreach ($homeworkRequest->home_work_comments->reverse() as $homeworkComment)
                    <div class="pt-3 mb-24pt">
                        <div class="d-flex mb-3">
                            <a href=""
                                style=" {{app()->getLocale() == 'ar' ? 'margin-left: 10px;' : ''}} "
                               class="avatar avatar-sm mr-12pt">
                                <img src="{{ asset('storage/images/users/' . $homeworkComment->user->profile) }}" alt="people" class="avatar-img rounded-circle">
                            </a>
                            <div class="flex">
                                <a href=""
                                   class="text-body"><strong> {{$homeworkComment->user->name}} </strong> <small class="text-50 mr-2"> {{' ( ' . $homeworkComment->created_at . ' ) '}} </small></a> <br>
                                <p class="mt-1 text-70"> {{$homeworkComment->message}} </p>

                                @if($homeworkComment->comment_file != '#' )


                                <div class="form-group row down_link pt-1">
                                    <div class="col-md-12">
                                        <a class="btn-info" style="padding: 10px; border-radius: 5px;" href="{{ asset('storage/comments/files/' . $homeworkComment->comment_file) }}">{{__('Download File')}}</a>
                                    </div>
                                </div>

                                @endif

                                @if ($homeworkComment->comment_image != '#')
                                <img src="{{ asset('storage/images/comments/' . $homeworkComment->comment_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                                @endif

                                <div class="d-flex align-items-center">

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-12 d-flex align-items-center" style="margin-bottom: 50px;">
            <div class="flex"
                 style="max-width: 100%">
                <div style="display:none; position: absolute; left: 50%; top: 35%;"
                 id="loader" class="loader loader-primary loader-lg">
                </div>
            </div>
        </div>


        <div class="card-footer" style="direction: ltr">
            <div class="input-group">
                <div class="input-group-append">
                    <span style="cursor:pointer" onclick="document.getElementById('comment_file').click()" class="input-group-text attach_btn"><i style="color:#000;" class="fas fa-paperclip"></i></span>
                    <span style="cursor:pointer" onclick="document.getElementById('comment_image').click()" class="input-group-text attach_btn"><i style="color:#000" class="fas fa-image"></i></span>

                    <input type="file"  id="comment_file" name="comment_file" style="display:none;"/>
                    <input type="file" id="comment_image" name="comment_image" style="display:none;"/>

                </div>
                <textarea id="message" style="padding-top: 20px; {{app()->getLocale() == 'ar' ? 'direction: rtl' : '' }} " name="" class="form-control type_msg" placeholder="{{__('Type your message...')}}"></textarea>
                <div class="input-group-append">

                    <a
                    data-url="{{route('homework-comment-send' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}"
                    data-local="{{app()->getLocale()}}"
                    data-status="{{$homeworkRequest->status}}"
                    data-check="{{Auth::check()}}"
                    style="color:#fff; {{($homeworkRequest->status == 'waiting' || $homeworkRequest->status == 'recieved') ? 'pointer-events: none; border: 1px solid #999999; background-color: #cccccc;' : ''}}"
                    class="btn btn-primary"
                    id="comment_submit">

                        <span class="">{{__('Send')}}</span>
                    </a>
                </div>
            </div>
        </div>




    </div>
</div>


<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("Please login to add products to cart, if you don't have account please register one now ....")}}
        </div>
        <div class="modal-footer">
        <a href="{{ route('login' , ['lang'=> app()->getLocale() , 'country'=> $scountry->id]) }}" class="btn btn-primary">{{__("Login")}}</a>
          <a href="{{ route('register' , ['lang'=> app()->getLocale() , 'country'=> $scountry->id]) }}" class="btn btn-success">{{__("Register")}}</a>
        </div>
      </div>
    </div>
  </div>


  <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("An empty comment cannot be sent. Please write the message text first")}}
        </div>
      </div>
    </div>
  </div>


  <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("The status of the request is complete. You cannot send comments now")}}
        </div>
      </div>
    </div>
  </div>


@endsection




@push('scripts-front')

<script>


$('#comment_file').on('change' ,function(){

    $('.fa-paperclip').css('color' , 'red');

});


$('#comment_image').on('change' ,function(){

    $('.fa-image').css('color' , 'red');

});



$('#comment_submit').on('click' , function(e){

    e.preventDefault();

    $("#comment_submit").css("pointer-events", "none");


    var url = $(this).data('url');

    var check = $(this).data('check');

    var status = $(this).data('status');

    console.log(status);


    if($('#comment_file').get(0).files.length == 0) {
    var comment_file = "#" ;
    }else{
    var comment_file = $('#comment_file')[0].files[0] ;
    }


    if($('#comment_image').get(0).files.length == 0) {
    var comment_image = "#" ;
    }else{
    var comment_image = $('#comment_image')[0].files[0] ;
    }



    var message = $('#message').val();



    if(message == ''){


        $("#comment_submit").css("pointer-events", "auto");

        $('#exampleModalCenter2').modal({
            keyboard: false
          });



    }else{

        var formData = new FormData();
        formData.append('message' , message);
        formData.append('comment_file' , comment_file);
        formData.append('comment_image' , comment_image );

      if (check == false) {

        $('#exampleModalCenter').modal({
            keyboard: false
          })

        }else{

            if(status == 'done'){

                $('#exampleModalCenter1').modal({
                    keyboard: false
                });

            }else{

                $('#loader').css('display', 'flex');

                $.ajax({
                    url: url,
                    data: formData,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {

                        $("#comment_submit").css("pointer-events", "auto");
                        $('#loader').css('display', 'none');
                        $('#message').val('')
                        $('.fa-paperclip').css('color' , '#000');
                        $('.fa-image').css('color' , '#000');
                        $('#comment_image').val(null);
                        $('#comment_file').val(null);
                        $('#comments').append(data);

                    }
                })

            }



        }

    }


  });

</script>

@endpush
