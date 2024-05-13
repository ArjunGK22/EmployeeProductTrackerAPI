<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the Products.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        try{

            //validate the request
            $product_validator = Validator::make($request->all(), [
                'productname' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|integer'
            ]);

            //if validation fails
            if($product_validator->fails()){

                return response()->json([
                    'status' => 422,
                    'errors' => $product_validator->messages()
                ], 433);

            }
            else{

                Product::create($request->all());

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product Created Successfully' 
                ],201);


            }

        }
        catch (Exception $e){

            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
