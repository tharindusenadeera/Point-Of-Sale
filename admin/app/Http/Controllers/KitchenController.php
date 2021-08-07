<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        return view("kitchen.kitchen");
    }

    public function getOrders()
    {
        // TODO::connect with DB orders
        $orders = '{
  "data": [
    [
      "1",
      "2",
      "<li>Chicken Burger : 1</li><li>Vegitable Shawarma : 2</li><li>Chicken Fried Rice : 1</li>.....",
      "Walk In @ 2021-07-17 14:20:00",
      "Sonia Roberts (Waiter)",
      "<button type=\"button\" onclick=\"$(\'#addModal\').modal(\'show\');\" class=\"btn  btn-danger btn-xs \">Placed</button>"
    ],
    [
      "2",
      "5",
      "<li>Chicken Burger : 1</li><li>Vegitable Shawarma : 2</li><li>Chicken Fried Rice : 1</li>.....",
      "Online @ 2021-07-17 14:20:00",
      "Christopher Caldwell (POS User)",
      "<button type=\"button\" onclick=\"$(\'#addModal\').modal(\'show\');\" class=\"btn  btn-warning btn-xs \">Kitchen</button>"
    ],
    [
      "3",
      "6",
      "<li>Chicken Burger : 1</li><li>Vegitable Shawarma : 2</li><li>Chicken Fried Rice : 1</li>.....",
      "Uber Eats @ 2021-07-17 14:20:00",
      "Peggy Soto (Customer)",
      "<button type=\"button\" onclick=\"$(\'#addModal\').modal(\'show\');\" class=\"btn  btn-warning btn-xs \">Kitchen</button>"
    ]
  ]
}';

        return $orders;
    }
}
