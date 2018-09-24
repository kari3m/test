<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required|string|min:6', //5lait el bass min b 6 7rof 2w arkam
            // 'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            // 'confirm_password' => 'min:6|required_with:password|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // $credentials = $request->only('email', 'password', 'name');
        // try {
        //     if (! $token = JWTAuth::attempt($credentials)) {
        //         return response()->json(['error' => 'This Email alredy in use']);
        //     }
        // } catch (JWTException $e) {
        //     return response()->json(['error' => 'could_not_create_token'], 500);
        // }
        // $credentials = $request->only('email','name','password');  //5alit 2n lw el crid
        // if (! $token = JWTAuth::attempt($credentials)) {
        //     return response()->json(['error' => 'Email is alredy in use'], 401);
        // }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            // 'confirm_password' => bcrypt($request->get('confirm_password'))
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));
    }
}
