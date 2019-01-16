<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function charge(Request $request){

        try {
            // Use Stripe's library to make requests...
            \Stripe\Token::create([
                "card" => [
                    "number" => $request->cc_number,
                    "exp_month" => $request->expry_month,
                    "exp_year" => $request->expry_year,
                    "cvc" => $request->cvv
                ]
            ]);

            \Stripe\Charge::create([
                "amount" => $request->amount,
                "currency" => "lkr",
                "source" => $token, // obtained with Stripe.js
                "description" => $request->description,
                "receipt_email" => $request->email
            ]);

            return response()->json([
                'success' => true
            ]);

        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return response()->json($e->getJsonBody());

        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return response()->json($e->getJsonBody());

        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return response()->json($e->getJsonBody());

        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return response()->json($e->getJsonBody());

        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            return response()->json($e->getJsonBody());

            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return response()->json($e->getJsonBody());

        }
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
