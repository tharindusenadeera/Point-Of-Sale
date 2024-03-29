<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Response;

class MenuItemController extends Controller
{    
    /*
    |--------------------------------------------------------------------------
    |Public function / Get Menu items
    |--------------------------------------------------------------------------
    */
    public function getMenuItems(Request $request){

        $id      = (isset($request->id)) ?  $request->id : null;
        $item    = (isset($request->item)) ?  $request->item : null;

        $menuitems = MenuItem::with(["menuItemCategoryOptions.menuOptionCategory", "menuItemCategoryOptions.menuOption"]);

        if($id) {
            $menuitems = $menuitems->where('id', $id);
        }

        if($item) {
            $menuitems = $menuitems->where('name','LIKE','%'.$item.'%');
        }

        $menuitems = $menuitems->get()->makeHidden('menuItemCategoryOptions')->append("menu_option_categories");

        if($menuitems->isEmpty()){
            return Response::json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
        }


        return Response::json(['data' => $menuitems, "status" => "success", "status_code" => "200", "message" => "done"], 200);

    }
}
