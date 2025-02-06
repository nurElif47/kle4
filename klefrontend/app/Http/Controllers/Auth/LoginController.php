<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Giriş formunu göster
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('products.index'); // Zaten giriş yapmışsa ürünlere yönlendir
        }
        return view('login'); // Giriş formunun view dosyasını göster
    }

    // Kullanıcı girişi
    public function login(Request $request)
    {

            // API'ye istek gönder
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post(env('API_URL') . '/api/login', [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);
            // Başarılı yanıtı kontrol et
            if ($response->successful()) {
                $data = $response->json();
                session(['api_token' => 'Bearer '. $data['access_token']['plainTextToken']]); // Token'ı oturumda sakla

                return redirect()->route('products.index'); 
            }
            // Başarısız yanıt durumunda hata mesajını yakala
            if ($response->status() == 422) {
                $errors = $response->json()['errors'];  // Hata mesajlarını al
                return redirect()->back()->withErrors($errors)->withInput();
            }



    }

    public function logout(Request $request)
    {

        // API'de oturumu kapatma isteği gönder
        Http::withToken(session('api_token'))->post(env('API_URL') . '/api/logout');

        // Oturumdan token sil
        session()->forget('api_token');

        // Kullanıcı oturumunu temizle
        Auth::logout();

        return redirect()->route('login')->with('message', 'Çıkış yapıldı.');
    }

}
