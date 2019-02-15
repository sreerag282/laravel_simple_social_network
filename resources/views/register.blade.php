@extends('layout.master')

@section('title')
    Registration
@endsection

{{-- @include('layout.header') --}}

@section('content') 
        
    <div class="row" id="home_page">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <form action = '{{ route('postregister') }}' method="POST" class="form-container">
                @include('layout.message_block')
                <h3>Register</h3>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">name:</label>
                    <input class="form-control" type="text" name="user_name" id="user_name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">password:</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
        <div class="col-md-4">
        </div>
    </div>
   
@endsection