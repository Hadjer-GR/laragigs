<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Console\View\Components\Confirm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Question\ConfirmationQuestion;

use function Laravel\Prompts\confirm;

class UserController extends Controller
{
    public function create(){
        return view("users.register");
    }
    public function store(Request $request){
        $formfields=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required ','email',Rule::unique('users','email')],
            'password'=>['required','confirmed','min:6']
        ]);
        //hash password
        $formfields['password']=bcrypt($formfields['password']);
        $user =User::create($formfields);
        auth()->login($user);
        return redirect("/")->with("message",'user created and login in');
        
    }
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/")->with('message',"you have been logout !");

    }
    public function login(){
      
        return view("users.login");

    }
    public function authenticate(Request $request){
        $formfields=$request->validate([
          'email'=>['required','email'],
          'password'=>['required']
        ]);
        if(auth()->attempt($formfields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','you are now login');
        }
        return  back()->withErrors(['email'=>'invalide credientials'])->onlyInput('email');

    }
    
}
