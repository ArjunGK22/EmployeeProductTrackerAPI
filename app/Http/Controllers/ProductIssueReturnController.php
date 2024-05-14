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
    public function index()
    {
        $transactions = Transaction::with('products')->get();

        return $transactions;
    }

    public function issue(Request $request)
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
                        return response()->json(['message' => "Product Quantity Requested is not available"], 200);
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
                    return response()->json(['message' => "Product Id not Found!"], 200);
                }
            }

            DB::commit();

            return response()->json(['message' => "Product Issued Successfully!"], 200);
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
