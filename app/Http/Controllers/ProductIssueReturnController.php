<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Transaction_Product;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductIssueReturnController extends Controller
{
    public function index($id)
    {
        $transaction = Transaction::with(['user', 'products'])->findOrFail($id);

        // return $transaction;

        $products = $transaction->products->map(function($product) {
            return [
                'name' => $product->productname,
                'quantity' => $product->pivot->quantity,
                'total_price' => $product->pivot->total_price,
            ];
        });

        return response()->json([
            "transaction_id" => $transaction->id,
            "issued_at" =>  $transaction->created_at->format('d M Y'),
            "user_name" => $transaction->user->name,
            "email" => $transaction->user->email,
            "phone" => $transaction->user->phone,
            "products" => $products
        ]);
    }

    public function issueProducts(Request $request)
    {

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => $request->user_id,
                'type' => 'issue'
            ]);

            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);

                if ($product) {
                    //check if the quantity in inventory is available
                    if ($product->quantity < $productData['quantity']) {
                        DB::rollback();
                        return response()->json(['message' => "Product:" . $productData['product_id'] . " Quantity Requested is not available"], 200);
                    }
                    //proceed
                    else {
                        Transaction_Product::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $productData['product_id'],
                            'quantity' => $productData['quantity'],
                            'total_price' => $productData['quantity'] * $product->price
                        ]);
                    }

                    $product->decrement('quantity', $productData['quantity']);
                } else {
                    DB::rollback();
                    return response()->json(['message' => "Product Id: " .$productData['product_id']. " not Found! " ], 200);
                }
            }

            DB::commit();

            return response()->json(['message' => "Product Issued Successfully!"], 200);
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function returnProducts(Request $request)
    {
        DB::beginTransaction();

        try {

            $transaction = Transaction::create([
                'user_id' => $request->user_id,
                'type' => 'return',
            ]);

            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);

                if ($product) {
                    if($productData['quantity'] < $product['quantity'] ){
                        Transaction_Product::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $productData['product_id'],
                            'quantity' => $productData['quantity'],
                            'total_price' => $productData['quantity'] * $product->price
                        ]);
    
                        $product->increment('quantity', $productData['quantity']);

                    }
                    else{
                        return response()->json(['message' => "Products Return Quantity more than Inventory!"], 200);

                    }
                    
                } else {
                    // Rollback the transaction if a product is not found
                    DB::rollback();
                    return response()->json(['message' => "Product Id: " .$productData['product_id']. " not Found!"], 404);
                }
            }

            DB::commit();

            return response()->json(['message' => "Products Returned Successfully!"], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
