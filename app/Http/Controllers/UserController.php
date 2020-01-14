<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

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
            'email' => 'required|email',
            'password' => 'required|min:2',
            'confirm_password' => 'required|same:password',
            'role' => 'required'
        ]);

        // If validation fails
        if ($validator->fails()) {
            // Set response code to 400
            $response->setStatusCode(400);

            // Return validator errors array
            return $response->setData($validator->errors()->getMessages());
        } else {
            // Check if email already exists
            $user = User::where('email', '=', $request['email'])->get();

            // If user find
            if (count($user) !== 0) {
                $response->setStatusCode(400);
                return $response->setData([
                    'email' =>
                        'User already exists with email ' .
                        $request["email"] .
                        '.'
                ]);
            }
            // Unset confirm password
            unset($request['confirm_password']);

            // Has password
            $request['password'] = Hash::make($request['password']);

            // Create user
            User::create($request->all());

            // Set response code to 200
            $response->setStatusCode(200);

            // Return 200 status with ok
            return $response->setData(['status' => 'ok']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(User $user, Request $request, JsonResponse $response)
    {
        // Create validator
        $validator = Validator::make($request->json()->all(), [
            'email' => 'required|email',
            'password' => 'required|min:2',
            
        ]);

        // If validation fails
        if ($validator->fails()) {
            // Set response code to 400
            $response->setStatusCode(400);

            // Return validator errors array
            return $response->setData($validator->errors()->getMessages());
        } else {
            // Check rol string to integer
            //$request['role'] = intval($request['role']);

            // Check if email already exists
            $user = User::where('email', '=', $request['email'])->get();

            // If user find
            if (count($user) === 0) {
                $response->setStatusCode(401);
                return $response->setData([
                    'email' =>
                        'User does not exists with email ' .
                        $request["email"] .
                        '.'
                ]);
            }

            if (!Hash::check($request['password'], $user[0]['password'])) {
                $response->setStatusCode(400);
                return $response->setData(['password' => 'Invalid password.']);
            }

            // Define payload
            $payload = array(
                "iss" => "http://localhost",
                "aud" => "http://localhost",
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "exp" => time() + 3600,
                "_id" => $user[0]["_id"],
                "email" => $user[0]["email"],
                "role" => $user[0]["role"]
            );

            // Secrate key
            $key = 'secrate';

            // JWT encode with user data
            $jwt = JWT::encode($payload, $key);

            // Set array for returning response
            $token['token'] = $jwt;

            // Set response code to 200
            $response->setStatusCode(200);

            // Return 200 status with ok
            return $response->setData($token);
        }
    }
}
