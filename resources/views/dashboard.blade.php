@if(isset(Auth::user()->email))
    @extends('layout.master')

    @section('title')
        dashboard
    @endsection

    @section('content')

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img style="height:30px;width:30px;" src="/storage/profileImages/{{ Auth::user()->user_profile }}" title="{{ Auth::user()->name }}">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user_profile')}}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
                </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid" id="dashboard-full">
            <div class="row new-post">
                <div class="col-md-3"></div>
                <div class="col-md-6 box-user">
                    <header>
                        <h3>Something To Say {{ Auth::user()->name }} ...</h3>
                        @include('layout.message_block')
                        <form  action="{{ action('Postcontroller@createPost') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea class="form-control" name="new_post" id="new_post" rows="4" placeholder="New Post"></textarea>
                                <button type="submit" class="btn btn-sm btn-primary mt-2 btn-block"> Create Post</button>
                            </div>
                        </form>    
                    </header>
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row posts">
                <div class="col-md-3"></div>
                <div class="col-md-6 box-user">
                    <header>
                        <h3>What Other People Say</h3>
                    </header>
                    @if(count($posts) > 0)
                        @foreach ($posts as $post)
                            <article class="post" data-post_id = {{ $post->id}}>
                                <p>
                                {{ $post->body }}
                                </p>
                                <div class="info">
                                    published by {{ $post->user->name }} at {{ $post->created_at }}
                                </div>
                                <div class="interaction">
                                    <a href="#" id="is_like" class="like isliked @if(array_key_exists($post->id,$postLikes)) @if($postLikes[$post->id]['like'] == 1) is-like @endif @endif ">Like</a> |
                                    <a href="#" id="is_dislike" class="like @if(array_key_exists($post->id,$postLikes)) @if($postLikes[$post->id]['like'] == 0) is-dislike @endif @endif">Dislike</a> 
                                    <input type="hidden" id="tokenlike" name="tokenlike" value="{{ csrf_token() }}">
                                    <input type="hidden" id="urllike" name="urllike" value="{{ route('like') }}">

                                    @if(Auth::user() == $post->user)
                                        |<a href="#" class="edit_post">Edit</a> |
                                        <a href="{{ route('deletepost',['post_id' => $post->id]) }}">Delete</a> |
                                    @endif
                                    
                                </div>   
                            </article>
                        @endforeach
                    @endif
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <br>
        
        <div class="modal" id="edit_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                        <div class="form-froup">
                            <label for="edit-post">Edit The Post</label>
                            <textarea class="form-control" name="edit-post" id="edit-post"  rows="5"></textarea>
                        </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf_token" >
                  <input type="hidden" name="url_edit" value="{{ route('edit') }}" id="url_edit" >
                  <button type="button" id="save_edit_post" class="btn btn-primary">Save changes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div
    @endsection

@else
    <script>window.location = "{{ url('/login') }}"</script>
@endif
    
    