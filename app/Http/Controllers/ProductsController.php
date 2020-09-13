<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\ProductReadRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsResource;
use App\Model\Product;

class ProductsController extends Controller
{
    /**
     * get product
     *
     * @param ProductReadRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProductReadRequest $request)
    {
        return ProductsResource::collection(Product::all());
    }


    /**
     * find product by id
     *
     * @param ProductReadRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductById(ProductReadRequest $request)
    {
        $model = new Product();
        $product = $model->findProductById($request->id);
        return response()->json(["title" => $product->title, "price" => $product->price, "description" => $product->description, "discount" => $product->discount], 200);
    }


    /**
     * create product
     *
     * @param CreateProductRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateProductRequest $request)
    {
        $product = Product::create($request->validated());
//        $product = new Product($request->all())
        if (!$product->save()) {
            return response()->json(["success" => false, "message" => "Sorry, product could not be added."], 500);
        }
        return response()->json(["success" => true, 'message' => "The product registered."], 201);
    }


    /**
     * update existing product
     *
     * @param UpdateProductRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = new Product();
        $product = $product->findProductById($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sorry, product with id ' . $id . ' cannot be found'], 400);
        }

        $updated = $product->update($request->all());

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be updated'
            ], 500);
        }

    }
}
