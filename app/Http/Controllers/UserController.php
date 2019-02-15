<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Responce;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// use Illuminate\Http\File;
class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
   
    public function registerview(){
        return view('register');
    }

    public function loginview(){
        return view('login');
    }

    public function register_user(Request $request){
        $this->validate($request,[
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ],
        ['user_name.required' => 'User name is required',
        'email.required' => 'Email is required',
        'email.email' => 'Not a valid email',
        'password.required' => 'Password is required',
       ]
    );
        $user            = new User();
        $user->name      = $request['user_name'];
        $user->email     = $request['email'];
        $user->password  = bcrypt($request['password']);
        $user->user_profile = 'noiamge.png'; 
        $user->save();
        return redirect('login');
    }
 
    public function login_user(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'],
            ['email.required' => 'Email is required',
             'email.email' => 'Not a valid email',
             'password.required' => 'Password is required',
            ]
        );

        // authentication

            $email    = $request->get('email');
            $password = $request->get('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('dashboard');
        }
        else{
           return back()->with(['message' => 'Email or Password incorrect !']);
        }
    }

    public function sucessLogin(){
        $allPosts = Post::orderBy('created_at','desc')->get();
        $allLikes = Auth::user()->likes()->get()->toArray();
        foreach ($allLikes as $key => $value) {
           $postAllLikes[$value['post_id']] = $value; 
        }
        // var_dump($postAllLikes);
        // exit('df');
        return view('dashboard')->with(['posts' => $allPosts,'postLikes' => $postAllLikes]);
    }

    public function save_user_profile(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'image' => 'image|nullable|max:1999' ]
        );
        $user = Auth::user();
        $user->name = $request['name'];
        if($request->hasFile('image')){
            $fileNameWithExtension = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameStore = $fileName.'.'. time().'-'. $user->id.'.'.$extension; 
            $path = $request->file('image')->storeAs('public/profileImages',$fileNameStore);
        }
        else{
            $fileNameStore = 'noimage.png';
        }
        $user->user_profile = $fileNameStore;
        $user->update();
        return redirect()->route('dashboard');



        // $fileName = $user->name. '-' .$user->id. '.jpg';
        // if($file){
        //     Storage::disk('local')->put($fileName,File::get($file));
        // }
        // return redirect()->route('user_profile');
    }

    public function showprofilepage(){
        return view('user_profile')->with('user',Auth::user());
    }

    public function get_user_image($file_name){
        $file = Storage::disk('locale')->get($file_name);
        return new Responce($file,200);
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }

  


}
