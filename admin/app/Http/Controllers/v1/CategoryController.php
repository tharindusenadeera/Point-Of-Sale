<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use Response;

class CategoryController extends Controller
{
    public function getCategories(){

        $categories = MenuCategory::all();

        if($categories->isEmpty()){
            return Response::json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
        }

        return Response::json(['data' => $categories, "status" => "success", "status_code" => "200", "message" => "Categories"], 200);

    }
}
