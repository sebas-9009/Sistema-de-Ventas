<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function showLoginFormRegister(){
        return view('auth.register');
    }

    public function login(Request $request){

        $this->validateLogin($request);      
 
         if (Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'condicion'=>1])){
             return redirect('/home');
         }

         return back()->withErrors(['usuario' => trans('auth.failed')])
         ->withInput(request(['usuario']));
     }

     public function store(Request $request)
     {
         //
        
         $user= new User();
         $user->nombre = $request->nombre;
         $user->tipo_documento = $request->tipo_documento;
         $user->num_documento = $request->num_documento;
         $user->telefono = $request->telefono;
         $user->email = $request->email;
         $user->direccion = $request->direccion;
         $user->usuario = $request->usuario;
         $user->password = bcrypt( $request->password);
         $user->condicion = '1';
         $user->idrol ='4';  
           
             //inicio registrar imagen
             //Handle File Upload
             if($request->hasFile('imagen')){
 
                 //Get filename with the extension
                 $filenamewithExt = $request->file('imagen')->getClientOriginalName();
                 
                 //Get just filename
                 $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
                 
                 //Get just ext
                 $extension = $request->file('imagen')->guessClientExtension();
                 
                 //FileName to store
                 $fileNameToStore = time().'.'.$extension;
                 
                 //Upload Image
                 $path = $request->file('imagen')->storeAs('public/img/usuario',$fileNameToStore);
 
             
             } else{
 
                 $fileNameToStore="noimagen.jpg";
             }
             
            $user->imagen=$fileNameToStore;
 
             //fin registrar imagen
             $user->save();
             return redirect('/');
     }

     protected function validateLogin(Request $request){
        $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

}
