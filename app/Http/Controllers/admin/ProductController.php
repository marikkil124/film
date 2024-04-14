<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\IndexRequest;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductUser;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $products = Product::filter($data)->paginate(10);
        $images =
            // $products = Product::all();
        $products = ProductResource::make($products);

        if ($request->wantsJson()) {
            return $products;
        }

        return inertia('Admin/Product/index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Product/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data['product']);
        if (isset($data['images'])) {

            foreach ($data['images'] as $image) {
                $path = Storage::disk('public')->put('/images', $image);
//                $product->images()->create([
//                    'path'=>$path,
//                ]);
                Image::create([
                    'path' => $path,
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class
                ]);
            }
        }

        return ProductResource::make($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $product = Product::where('id', $id)->update($data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProductService::delete($id);

        //  return ProductResource::make($product)->resolve();
    }
}
