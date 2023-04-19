@if (session('success'))
    <div class="alert alert-success">
        {!! session('success') !!}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {!! session('error') !!}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissable margin5">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Errors:</strong> Please check below for errors
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- @include('sweetalert::alert') --}}
