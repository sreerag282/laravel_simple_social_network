@if(isset(Auth::user()->email))
    <script>window.location = "{{ url('/dashboard') }}"</script>

@endif

    @extends('layout.master')

    @section('title')
        Login
    @endsection

    {{-- @include('layout.header') --}}

    @section('content')

    <div class="row" id="home_page">
        <div class="col-md-4">
        </div>
        <div class="col-md-4 box">
            <form method="post" class="form-container" action="{{ action('UserController@login_user') }}">
                @include('layout.message_block')
                <h3>Login</h3>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">password:</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <a class="btn btn-success btn-block" href="{{ route('register') }}">Register</a>
            </form>
        </div>
        <div class="col-md-4">
        </div>
    </div>
    
    @endsection