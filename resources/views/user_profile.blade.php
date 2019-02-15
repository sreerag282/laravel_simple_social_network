@extends('layout.master')

@section('title')
    user profile
@endsection

@section('content')
    <section class="row new-post">
        <div class="col-md-4"></div>
        <div class="col-md-4">
                @if(count($errors) > 0)
                    <div class="row">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <header><h3>Your Account</h3></header>
            <form action="{{ route('user_profile_save')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="name" class="form-control" value="{{$user->name}}" id="name">
                </div>
                <div class="form-group">
                    <label for="image">User Profile</label>
                    <input type="file" name="image" class="form-control-file" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Save Profile</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </section>
@endsection