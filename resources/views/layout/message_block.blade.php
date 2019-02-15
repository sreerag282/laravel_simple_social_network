@if (count($errors) > 0)
    <div class="row alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('message'))
    <div class="row alert alert-danger">
        {{Session::get('message')}}
    </div>
@endif