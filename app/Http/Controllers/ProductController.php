<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    function getAllProducts(Request $request){

        //validasi
        $request->validate([
            'paginate' => 'integer|max:10', // Wajib bertipe data String dan Maksimum 50 karakter
        ]);

        // $paginate = $request->paginate;
        $paginate = 12;
        // query semua data produk, dan melakukan paginasi
        $result = Product::paginate($paginate);

        return response()->json($result, 200);
    }

    function searchProducts(Request $request){

        //validasi
        $request->validate([
            'brand' => 'nullable|string|max:100', // Wajib bertipe data String dan Maksimum 50 karakter
            'model' => 'nullable|string|max:100', // Wajib bertipe data String dan Maksimum 50 karakter
        ]);

        $brandKeyword = $request->brand;
        $modelKeyword = $request->model;

        // $paginate = $request->paginate;
        $paginate = 12;
        // query semua data produk, dan melakukan paginasi
        $result = Product::where(function($query) use($brandKeyword, $modelKeyword){
            if($brandKeyword){
                $query->where('brand', 'like', "%$brandKeyword%");
            }

            if($modelKeyword){
                $query->where('model', 'like', "%$modelKeyword%");
            }
        });

        $result = $result->paginate(12);

        return response()->json($result, 200);
    }
}
