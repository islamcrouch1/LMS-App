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
