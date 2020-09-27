<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Model\Category;

class CategoryController extends Controller
{
    /**
     * create a category
     *
     * @param CreateCategoryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateCategoryRequest $request)
    {
        /**@var Category $category*/
        $category = Category::find($request->parent_id);

        if ($category and $category->products()->exists()){
            return response()->json(["success" => false , "message" => "This category id = ".$request->parent_id." can not have child."] , 500);
        }
        $created = Category::create($request->validated());

        if (!$created) {
            return response()->json(["success" => false, "message" => "Sorry, category could not be added."], 500);
        }

        return response()->json(["success" => true, 'message' => "The category registered."], 201);
    }


    /**
     * show all categories with products
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $categories = Category::with(['children' , 'products' , 'children.products'])->whereNull('parent_id')->get();
        return response()->json([new CategoryCollection($categories)]);
    }
}
