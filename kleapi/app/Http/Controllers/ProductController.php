<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Products::paginate(10);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Kayıt mevcut değil'], 200);
        }

        return response()->json([
            'message' => 'Ürünler başarıyla getirildi',
            'data' => $products
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    // Yeni ürün ekle
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Ürün adını boş bırakmayınız.',
            'description.required' => 'Açıklama alanını boş bırakmayınız.',
            'price.required' => 'Fiyat alanını boş bırakmayınız.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Geçersiz giriş',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Ürün başarıyla oluşturuldu',
            'data' => $product
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    // Belirli bir ürünü göster
    public function show(Request $request,  $id)
    {
        $product = Products::find($id);

        return response()->json([
            'message' => 'Ürün başarıyla getirildi',
            'data' => $product
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
     // Ürünü güncelle
     public function update(Request $request, $id)
     {
         $product = Products::find($id);

         if (!$product) {
             return response()->json(['message' => 'Ürün bulunamadı.'], 404);
         }

         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'description' => 'required|string|max:255',
             'price' => 'required|numeric|min:1',
            ],[
                'name.required' => 'Ürün adını boş bırakmayınız.',
                'description.required' => 'Açıklama alanını boş bırakmayınız.',
                'price.required' => 'Fiyat alanını boş bırakmayınız.',
            ]);

         if ($validator->fails()) {
             return response()->json([
                 'message' => 'Geçersiz giriş',
                 'errors' => $validator->errors()
             ], 422);
         }

         $product->update([
             'name' => $request->name,
             'description' => $request->description,
             'price' => $request->price,
         ]);

         return response()->json([
             'message' => 'Ürün başarıyla güncellendi',
             'data' => $product
         ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Ürünü sil
    public function destroy(Request $request,$id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Ürün bulunamadı.'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Ürün başarıyla silindi.'], 200);
    }
}
