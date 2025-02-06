<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = session('api_token');

        // API'den ürünleri almak için isteği yapıyoruz
        $response = Http::withHeaders(['Authorization' => $token])
            ->get(env('API_URL') . '/api/products', []);

        // API yanıtının başarılı olup olmadığını kontrol ediyoruz
        if ($response->successful()) {
            $data = $response->json();

            // dd($data['data']['data']);
            return view('products.index', ['products' => $data['data']['data']]); // Ürünleri view'ye gönderiyoruz
        } else {
            Log::error('API Hatası: ' . $response->body());

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = session('api_token');

        // Eğer token yoksa, kullanıcıyı login sayfasına yönlendir
        if (!$token) {
            return redirect()->route('login')->with('error', 'Lütfen giriş yapınız.');
        }

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = session('api_token');

        // API'ye ürün verilerini gönderiyoruz
        $response = Http::withHeaders(['Authorization' => $token])
        ->post(env('API_URL') . '/api/products', [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // API yanıtını kontrol ediyoruz
        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Ürün başarılı bir şekilde oluşturuldu');
        }

        // API doğrulama hatası dönerse (422)
        if ($response->status() == 422) {
            $errors = $response->json()['errors'];  // Hata mesajlarını al
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $token = session('api_token');

        // API'ye ürün bilgilerini almak için istek yapıyoruz
        $response = Http::withHeaders(['Authorization' => $token])
            ->get(env('API_URL') . '/api/products/' . $id);

        // API yanıtının başarılı olup olmadığını kontrol ediyoruz
        if ($response->successful()) {
            $product = $response->json();
            return view('products.show', ['product' => $product['data']]);
        }

        return redirect()->route('products.index')->withErrors('Ürün bilgisi alınamadı.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
     $token = session('api_token'); // Kullanıcının oturumdan token alınıyor
     $response = Http::withHeaders(['Authorization' => $token])
     ->get(env('API_URL') . '/api/products/' . $id);
     if ($response->successful()) {
        $product = $response->json();
        return view('products.edit', ['product' => $product['data']]);


    }
    

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $token = session('api_token');



        // API'ye ürün güncelleme verilerini gönderiyoruz
        $response = Http::withHeaders(['Authorization' => $token])
        ->put(env('API_URL') . '/api/products/' . $id, [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // API yanıtını kontrol ediyoruz
        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Ürün başarılı bir şekilde değiştirildi');
        }

        // API doğrulama hatası dönerse (422)
        if ($response->status() == 422) {
            $errors = $response->json()['errors'];  // Hata mesajlarını al
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function destroy($id)
    {
        $token = session('api_token');

        // API'ye silme isteği gönderiyoruz
        $response = Http::withHeaders(['Authorization' => $token])
            ->delete(env('API_URL') . '/api/products/' . $id);

        // API yanıtını kontrol ediyoruz
        if ($response->successful()) {
            return redirect()->route('products.index')->with('status', 'Ürün başarılı bir şekilde silindi.');
        } else {
            // API'den dönen hatayı kaydediyoruz
            Log::error('Ürün silinirken API hatası oluştu: ' . $response->body());
            return redirect()->back()->withErrors('Ürün silinirken bir hata oluştu: ' . $response->body());
        }
    }

}
