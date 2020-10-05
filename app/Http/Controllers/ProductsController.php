<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignProductToCategory;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\ProductReadRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductsResource;
use App\Model\Category;
use App\Model\Language;
use App\Model\Product;
use App\Model\ProductTrans;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class ProductsController extends Controller
{
    /**
     * get product
     *
     * @param ProductReadRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProductReadRequest $request)
    {
        return response()->json([new ProductCollection(Product::with('trans')->get())]);
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
        $product = Product::find($request->id)->with('trans')->first();

        return response()->json([
            "title"       => $product->trans->title,
            "price"       => $product->price,
            "description" => $product->trans->description,
            "discount"    => $product->discount,
            "category_id" => $product->category_id
        ], 200);
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
        /**@var Category $category*/
        $category = Category::find($request->category_id);

        if ($category and $category->child()->exists()){
            return response()->json(["success" => false , "message" => "This category id = ".$request->category_id." can not have child."] , 500);
        }

        $product = Product::create([
            'price'       => $request->price,
            'quantity'    => $request->quantity,
            'category_id' => $request->category_id,
            'discount'    => $request->discount
        ]);
        if (!$product) {
            return response()->json(["success" => false, "message" => "Sorry, product could not be added."], 500);
        }

        $trans = new ProductTrans([
            'title'       => $request->title,
            'description' => $request->description,
            'language_id' => Config::get('language_id')
        ]);

        $product->trans()->save($trans);

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

        /**@var Category $category*/
        $category = Category::find($request->category_id);

        if ($category and $category->child()->exists()){
            return response()->json(["success" => false , "message" => "This category id = ".$request->category_id." can not have child."] , 500);
        }

        $updated = $product->update([
            'price'       => $request->price ?: $product->price,
            'quantity'    => $request->quantity ?: $product->quantity,
            'category_id' => $request->category_id ?: $product->category_id,
            'discount'    => $request->discount ?: $product->discount
        ]);

        $product->trans()->update([
            'title'       => $request->title ?: $product->trans->title,
            'description' => $request->description ?: $product->trans->description,
        ]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'The product updated successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be updated'
            ], 500);
        }

    }


    /**
     * assign product to category
     *
     * @param AssignProductToCategory $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignProductToCategory(AssignProductToCategory $request)
    {
        $product = new Product();
        $product = $product->findProductById($request->product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sorry, product with id ' . $request->product_id . ' cannot be found'], 400);
        }
        /**@var Category $category*/
        $category = Category::find($request->category_id);

        if ($category and $category->child()->exists()){
            return response()->json(["success" => false , "message" => "This category id = ".$request->category_id." can not have child."] , 500);
        }

        $updated = $product->update(['category_id' => $request->category_id]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Product assign to category.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be assign'
            ], 500);
        }
    }
}
