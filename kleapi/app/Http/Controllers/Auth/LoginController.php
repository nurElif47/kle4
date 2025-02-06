<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{



    // Giriş formunu göster

    // Kullanıcı giriş işlemi
    public function login(Request $request)
    {
        // Giriş doğrulama kuralları
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'E-posta alanını boş bırakmayınız.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre alanını boş bırakmayınız.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
        ]);

        // Eğer doğrulama hatası varsa JSON olarak geri dön
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Doğrulama hatası',
                'errors' => $validator->errors()
            ], 422);
        }

        // Kullanıcıyı e-posta üzerinden bul
        $user = User::where('email', $request->input('email'))->first();

        // Kullanıcı giriş yapamazsa
        if ($user && $user->is_logged_out) {
            return response()->json([
                'message' => 'Bu kullanıcı çıkış yaptıktan sonra tekrar giriş yapamaz.',
            ], 403);
        }

        // Kullanıcı varsa ve şifre doğrulanmışsa giriş yap
        if ($user && Hash::check($request->input('password'), $user->password)) {
            Auth::login($user); // Laravel Auth kullanarak kullanıcıyı oturumda tut
            $token =  $user->createToken('authToken');


            return response()->json([
                'message' => 'Başarıyla giriş yapıldı.',
                'access_token' => $token,
                'user' => $user
            ], 200);

        }

        // Başarısız girişte hata mesajı  //bura eklendi
        if (!$user) {
            return response()->json([
                'message' => 'Kullanıcı bulunamadı.',
            ], 404);
        }


    }

    // Kullanıcı çıkışı
    public function logout(Request $request) {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete(); // Mevcut erişim tokenini sil
        }

        return response()->json([
            'message' => 'Başarıyla çıkış yapıldı.'
        ], 200);

    }
}
