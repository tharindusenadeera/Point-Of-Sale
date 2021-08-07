<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderMenuItem;
use App\Models\MenuItem;
use App\Models\OrderMenuOptionCategoryMenuOption;
use Validator;
use Response;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |Public function / Create Order
    |--------------------------------------------------------------------------
    */
    public function createOrder(Request $request){

        $validator = $this->validateInputs($request->all());

        if($validator->fails()){
          return Response::json(['data' => null, "status" => "false", "status_code" => "200", "message" => $validator->getMessageBag()->toArray()], 200);
        }

        try {

          DB::beginTransaction();

          $order =Order::create([
            'order_type'              => $request->order_type,
            'customer_id'             => $request->customer_id,
            'status'                  => $request->status,
            'total'                   => 100,
            'delivery_first_name'     => $request->delivery_first_name,
            'delivery_last_name'      => $request->delivery_last_name,
            'delivery_city_id'        => $request->delivery_city_id, 
            'delivery_address_line_1' => $request->delivery_address_line_1, 
            'delivery_address_line_2' => $request->delivery_address_line_2,
            'delivery_phone_number'   => $request->delivery_phone_number,
            
          ]);

          foreach($request->order_menu_items as $key=> $order_menu_item){  

            $menuitem =MenuItem::find($order_menu_item['id']);

            $ordermenuitem = OrderMenuItem::create([
                'order_id'     => $order->id,
                'menu_item_id' => $order_menu_item['id'],
                'price'        => $menuitem->price,
                'qty'          => $order_menu_item['qty'],
            ]);

              foreach($order_menu_item['menu_option_category_menu_option_id'] as $key=> $menu_option_category_menu_option_id){ 
                OrderMenuOptionCategoryMenuOption::create([
                  'order_menu_item_id'                  => $ordermenuitem->id,
                  'menu_option_category_menu_option_id' => $menu_option_category_menu_option_id,
                ]);              
              }

          }

          DB::commit();

          if (!empty($order)) {
            $order =Order::with('customer','ordermenuitems','ordermenuitems.menuitem' )->where('id',$order->id)->first();
            return Response::json(['data' => $order, "status" => "success", "status_code" => "200", "message" => "Order created successfully"], 200);
          }
         
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();          
            return Response::json(['data' => null, "status" => "false", "status_code" => "500", "message" =>  $e], 500);
        }

    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Edit Order
    |--------------------------------------------------------------------------
    */
    public function editOrder(Request $request){


        $validator = $this->validateInputs($request->all());

        if($validator->fails()){
          return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

          try {

            DB::beginTransaction();

            $order = Order::find($request->id);

            if(empty($order)){
              return Response::json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No result found"], 200);
            }

            $order->customer_id = $request->customer_id;
            $order->save();

            OrderMenuItem::where('order_id',$request->id)->delete();

            foreach($request->order_menu_items as $key=> $order_menu_item){  
              $menuitem =MenuItem::find($order_menu_item);
              OrderMenuItem::create([
                  'order_id'     => $order->id,
                  'menu_item_id' => $order_menu_item,
                  'price'        => $menuitem->price,
                  'qty'          => $request->qty[$key],
              ]);
            }

            DB::commit();

        if ($order->id) {
          $order =Order::with('ordermenuitems','ordermenuitems.menuitem' )->where('id',$order->id)->first();
          return Response::json(['data' => $order, "status" => "success", "status_code" => "200", "message" => "Order updated successfully"], 200);
        }
            
        } catch (\Illuminate\Database\QueryException $e) {
          DB::rollback();
          return Response::json(['data' => null, "status" => "false", "status_code" => "500", "message" => 'Order not updated'], 500);
            
        }

    }


    /*
    |--------------------------------------------------------------------------
    |Public function / Get All orders
    |--------------------------------------------------------------------------
    */
    public function getAllOrders(Request $request){

      $orders =Order::with('customer','ordermenuitems','ordermenuitems.menuitem' )->get();

      if($orders->isEmpty()){
        return Response::json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
      }
      
      return Response::json(['data' => $orders, "status" => "success", "status_code" => "200", "message" => "order list"], 200);
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Get single order
    |--------------------------------------------------------------------------
    */
    public function getOrder(Request $request){

      $order =Order::with('customer','ordermenuitems','ordermenuitems.menuitem' )->where('id',$request->id)->first();

      if(empty($order)){
        return Response::json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
      }
      
      return Response::json(['data' => $order, "status" => "success", "status_code" => "200", "message" => "Order"], 200);
    }

    
    
    /*
    |--------------------------------------------------------------------------
    |Private function / Input validation
    |--------------------------------------------------------------------------
    */
    private function validateInputs($inputs)
    {
      $rules =[
        'customer_id'             => 'required_if:order_type,deliver',
        'order_type'              => "required",
        'order_menu_items.*.id'   => "required",
        'order_menu_items.*.qty'  => "required",
        'order_menu_items.*.menu_option_category_menu_option_id' => "required",
     

        'delivery_first_name'     => 'required_if:order_type,deliver',
        'delivery_last_name'      => 'required_if:order_type,deliver',
        'delivery_city_id'        => 'required_if:order_type,deliver', 
        'delivery_address_line_1' => 'required_if:order_type,deliver', 
        'delivery_address_line_2' => 'required_if:order_type,deliver',
        'delivery_phone_number'   => 'required_if:order_type,deliver',
      ];

      return Validator::make($inputs, $rules);
    }
}
