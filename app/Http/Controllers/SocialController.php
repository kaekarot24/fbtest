<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    public function UserLogout()
    {
        # code...
        Auth::logout();
        return redirect()->route('home');
    }

    public function Dashboard()
    {
        # code...
        $user = Auth::user();
        return view('welcome', ['user' => $user]);
    }

    public function userlogin(Request $request)
    {
        # code...
        $request->validate([
            'username' => 'required|email',
            'password' => 'required'
        ]);

        $isUser = User::where('email', $request->username)->first();
        if(!is_null($isUser)){
            if (Hash::check($request->password, $isUser->password)) {
                Auth::login($isUser);
                return redirect()->route('dashboard');
            } else {
                return back()->with('failed', 'Wrong Password. Please try again');
            }
        }
        return back()->with('failed', 'Wrong Username. Please try again'); 
    }

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->fields(['first_name','last_name','name','email','gender','birthday'])->user();
            $isUser = User::where('fb_id', $user->id)->first();
     
            if($isUser){
                Auth::login($isUser);
                return redirect('/dashboard');
            }else{
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_photo_path' => $this->getimage($user->avatar),
                    'fb_id' => $user->id,
                    'password' => Hash::make('user@123')
                ]);
    
                Auth::login($createUser);
                return redirect('/dashboard');
            }
    
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function getimage(string $url = null)
    {
        # code...
        $json = file_get_contents($url."&redirect=false");
        $picture = json_decode($json, true);
        $img = $picture['data']['url'];

        //echo $img; die;

        return $img;
    }

}
