<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the Products.
     */
    public function index()
    {
        $products = Product::all();

        // return dd($products);

        return response()->json($products, 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a new product.
     */

     public function storeBulk(StoreProductRequest $request)
    {
        $productsData = $request->all();
        $products = [];

        foreach ($productsData as $productData) {
            $products[] = [
                'productname' => $productData['productname'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Product::insert($products);

        return response()->json(['message' => 'Products inserted successfully'], 201);
    }

    /*
    public function store(Request $request)
    {
        try {

            //validate the request
            $product_validator = Validator::make($request->all(), [
                'productname' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|integer'
            ]);

            //if validation fails
            if ($product_validator->fails()) {

                return response()->json([
                    'status' => 422,
                    'errors' => $product_validator->messages()
                ], 433);
            } else {

                Product::create($request->all());

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product Created Successfully'
                ], 201);
            }
        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
*/

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            if ($product)
                return response()->json($product, 200);
            else
                return response()->json(['message' => 'No Product Found'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        try {
            //validate the request
            $product_validator = Validator::make($request->all(), [
                'productname' => 'string',
                'price' => 'numeric',
                'quantity' => 'integer'
            ]);

            if ($product_validator->fails()) {

                return response()->json([
                    'status' => 422,
                    'errors' => $product_validator->messages()
                ], 433);
            } else {
                $product->update($request->all()); //update the product
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product Updated Successfully'
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product Deleted Successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => "Error Deleting Product! Please try later"], 500);
        }
    }
}
