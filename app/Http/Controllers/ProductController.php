<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): JsonResponse
    {
        $products = Product::get();
        return response()->json($products);
    }



    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();


        $request->validate([
            'products' => 'required|array',
            'products.*.name' => 'required|string|max:255',
            'products.*.description' => 'required|string',
            'products.*.price' => 'required|numeric',
        ]);

        $user = $request->user();

        if (!$user->is_admin) {
            return response()->json(['error' => 'O usuário não é um admin.'], 403);
        }

        try {
            $productsData = $request->input('products');
            $products = [];

            foreach ($productsData as $productData) {
                $products[] = Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                ]);
            }
            DB::commit();

            return response()->json($products, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th, 400);
        }

    }


    public function show($id): JsonResponse
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }



    public function update(Request $request, $id): JsonResponse
    {
        DB::beginTransaction();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $user = $request->user();

        if (!$user->is_admin) {
            return response()->json(['error' => 'O usuário não é um admin.'], 403);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product Id not exist'], 404);
        }
        try {
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);
            DB::commit();
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th, 400);
        }


    }

    public function delete(Request $request, $id): JsonResponse
    {
        DB::beginTransaction();


        $product = Product::find($id);

        $user = $request->user();

        if (!$user->is_admin) {
            return response()->json(['error' => 'O usuário não é um admin.'], 403);
        }


        if ($product) {

            $product = Product::findOrFail($id);
            $product->delete();
            DB::commit();
            return response()->json('The Product was deleted, id: ' . $id, 200);
        } else {
            DB::rollBack();
            return response()->json('product id not exist', 400);
        }

    }
}
