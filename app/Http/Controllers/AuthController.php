<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required' => 'please fill in the valid field',
            'email.email' => 'please enter a valid email address',
            'password.required' => 'please fill in the valid field'
        ];
        $validation = Validator::make($data,$rules,$messages);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // sadece email ve sifreyi al
        $credentials = $request->only(['email','password']);
        // remember tokeni isaretlemeden girisini saglama
        $remember = $request->filled('remember');

        if(Auth::attempt($credentials,$remember)){
            //intended metodu, bir kullanıcı giriş yapmaya çalıştığında ancak öncesinde
            // bir URL'ye erişim izni olmadığında onları login sayfasına yönlendirir.
            // Kullanıcı başarılı bir şekilde giriş yaptıktan sonra, intended metodu
            // onları orijinal olarak gitmek istedikleri sayfaya yönlendirir.
            return redirect()->intended('/');
        }else{
            return redirect()->back()->with(['error'=>'Invalid credentials']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.create');
    }
}
