<?php

namespace App\Http\Controllers;

use App\Wrongphrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;



class WrongphraseController extends Controller
{
    //
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, JsonResponse $response)
    {
        // Create validator
        $validator = Validator::make($request->json()->all(), [
            'title' => 'required|min:2'
        ]);

        // If validation fails
        if ($validator->fails()) {
            // Set response code to 400
            $response->setStatusCode(400);

            // Return validator errors array
            return $response->setData($validator->errors()->getMessages());
        } else {
            // Create user
            Wrongphrase::create($request->all());

            // Set response code to 200
            $response->setStatusCode(200);

            // Return 200 status with ok
            return $response->setData(['status' => 'ok']);
        }
    }

    // View wrong phrase 
    public function view(Request $request, JsonResponse $response) {

    	// Get all wrong phrases 
    	$wrongphrases = Wrongphrase::all();

    	// Return data 
    	return $response->setData($wrongphrases);

    }

    // retrun the array of the validation functions
    public static function getValidationArray()
    {
    	$wps= \App\Wrongphrase::all(['title']);
    	$ret=[];
    	foreach($wps as $wp){
    		$ret[]=$wp->title;
    	}

    	return $ret;
    }

    // $wpsArr=WrongphraseController::getValidationArray();
}
