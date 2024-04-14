<?php

namespace App\Services\Admin;

use App\Models\Film;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public static function delete( $id)
    {
        try {
            DB::beginTransaction();
            $productUser = ProductUser::where('product_id',$id)->get();
            if (isset($productUser))
            {

                ProductUser::destroy($productUser);
                Product::destroy($id);
            }

            DB::commit();
            return response()->json([
                'msg' => 'product deleted',

            ]);

        }catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json([
                'msg' => 'product deleted error',
                'exception'=>$exception->getMessage()

            ]);
        }
    }

}
