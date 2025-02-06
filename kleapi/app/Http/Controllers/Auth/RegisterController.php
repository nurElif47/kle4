<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{



    public function register(Request $request)
    {



        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'İsim alanı boş bırakılamaz.',
            'email.required' => 'Email alanı boş bırakılamaz.',
            'email.email' => 'Geçerli bir email adresi giriniz.',
            'email.unique' => 'Bu email zaten kullanılıyor.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.min' => 'Şifreniz en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ]);

        // Eğer doğrulama hatası varsa JSON olarak geri dön
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Doğrulama hatası',
                'errors' => $validator->errors()
            ], 422);
        }

        // Kullanıcı kaydetme işlemi
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla tamamlandı.',
            'user' => $user
        ], 201);
    }



}
