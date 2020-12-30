{{-- @if (session()->has('success'))
<div class="col-md-3">
    <div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Success</h3>

        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
        </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {{session()->get('success')}}
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endif --}}


@if (session()->has('success'))
    <script>
        new Noty({
            type: 'alert alert-danger p-3 mt-5',
            layout: 'topRight',
            text: "{{session()->get('success')}}",
            timeout: 2000,
            killer: true
        }).show();
    </script>

    @php
        session()->forget('success');
    @endphp

@endif


