<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class PosController extends Controller
{
    public function search(Request $request)
    {

        $searchTerm = $request->search;

        $products = Product::whereHas('productCodes')->where(function ($query) use ($searchTerm) {
            $query->where('name', 'LIKE', '%'.$searchTerm.'%')
                  ->orWhereHas('productCodes', function ($query) use ($searchTerm) {
                      $query->where('product_code', 'LIKE', '%'.$searchTerm.'%');
                  });
        })->get();

        foreach($products as $product) {

            //get product codes

            $codes = [];
            foreach ($product->productCodes as $productCode) {
                    $codes[] = $productCode->product_code;

            }
            $product->codes = $codes;
            unset($product->productCodes);

            //set product code
            if(in_array($searchTerm, $codes)){
                $product->code = $searchTerm;
            }else{
                $product->code = $codes[0];
            }
            //set product image
            $product->image = \Storage::url($product->image);

            //set product category
            $product->category = $product->productCategory->name;
        }



        return response()->json($products);
    }

    //checkout
    public function checkout(Request $request){

        // customer_id: customer_id,
        // paid: paid,
        // due: due,
        // product_codes: product_codes

        //return $request->all();


        //return response
        return response()->json(['success' => true, 'message' => 'Checkout Successfully', 'data' => $request->all()]);


    }

    public function customer(Request $request){

            $customer = \App\Models\Customer::find($request->customer_id);

            return response()->json($customer);
    }
}
