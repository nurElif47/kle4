<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;



class RegisterController extends Controller
{

    protected function registered(Request $request, $user)
    {
        return redirect()->route('login')->with('success', 'Kayıt işlemi başarılı! Lütfen giriş yapınız.');
    }
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('products.index'); // Zaten giriş yapmışsa ürünlere yönlendir.
        }
        return view('register');
    }

    public function register(Request $request)
    {
        // // Validate the request data
        $response = Http::post(env('API_URL') . '/api/register', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation')
        ]);

        // API başarılı yanıt dönerse (201 - Created)
        if ($response->successful()) {
            session()->flash('success', 'Kayıt başarılı! Giriş yapabilirsiniz.');
            return redirect()->route('login');
        }

        // API doğrulama hatası dönerse (422)
        if ($response->status() == 422) {
            $errors = $response->json()['errors'];  // Hata mesajlarını al
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Diğer hata durumları için genel hata mesajı
        return redirect()->back()->with('error', 'Kayıt işlemi başarısız oldu. Lütfen tekrar deneyin.');


    }
}
