<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Postcontroller extends Controller
{
    public function createPost(Request $request){
        // echo 'sdfdsf';
        // exit();
       $this->validate($request,[
            'new_post' => 'required']
        ); 
      
       $post = new Post();
       $post->body= $request['new_post'];
       $message = 'something went wrong';
       if($request->user()->posts()->save($post)){
           $message = 'post saved successfully';
       }
       return redirect('dashboard')->with(['message' => $message]);
    }

    public function deletepost($post_id){
        $post = Post::where('id',$post_id)->first();
        if(Auth::user() == $post->user)
            $post->delete();
        return redirect('dashboard')->with('message','post deleted successfully');

    }

    public function postEdit(Request $request){
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $request['body']],200);

    }

    public function likeAction(Request $request){
        $postId = $request['postId'];
        $isLike = $request['isliked'] === 'true';
        $post = Post::find($postId);
        if(!$post){
            return null;
        }
        else{
            $update = false;
            $undo   = false;
            $user = Auth::user();
            $like = $user->likes()->where('post_id',$postId)->first();
            if($like){
                if($like->like == $isLike){
                    $like->delete();
                    $undo = true;
                }
                else{
                    $update = true;
                    $like->user_id = $user->id;
                    $like->post_id = $postId;
                    $like->like    = $isLike;
                }
            }
            else{
                $like   = new Like();
                $like->user_id = $user->id;
                $like->post_id = $postId;
                $like->like    = $isLike;
                $like->save();

            }
            if($update){
                $like->update();
            }
            return response()->json(['status'=>true,'like'=> $isLike,'undo'=>$undo]);
        }
    }
}
