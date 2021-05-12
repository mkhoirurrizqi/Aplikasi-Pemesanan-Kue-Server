<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user = new User;
        $user->type = $request->input("type");
        $user->name = $request->input("name");
        $user->username = $request->input("username");
        $user->whatsapp = $request->input("whatsapp");
        $user->email = $request->input("email");
        $user->kecamatan = $request->input("kecamatan");
        $user->kelurahan = $request->input("kelurahan");
        $user->password = Hash::make($request->input("password"));
        $user->save();
        return response($user, 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["error" => "Username or password is not matched"];
            // throw ValidationException::withMessages([
            //     'username' => ['The provided credentials are incorrect.'],
            // ]);
        }
        if ($user->type == "toko") {
            $token = $user->createToken($request->device_name, ["Toko"])->plainTextToken;
            $type = $user->type;
        } else {
            $token = $user->createToken($request->device_name, ["Customer"])->plainTextToken;
            $type = $user->type;
        }
        $response = [
            'user' => $user,
            'token' => $token,
            'type' => $type
        ];

        return response($response, 201);

        // $user = User::where('username', $request->username)->first();
        // if (!$user || Hash::check($request->password, $user->password)) {
        //     return ["error" => "Email or password is not matched"];
        // }
        // return $user;
    }
    public function logout(Request $request)
    {
        // $request->user()->tokens()->delete();
        $request->user()->tokens()->where('token', $request->token)->delete();
        return response('Loggedout', 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showalluser(Request $request)
    {
        $type = $request->type;
        if (User::where('type', $type)->exists()) {
            $data = User::where('type', $type)->get();
            return response($data, 201);
        } else {
            return response(404);
        }
    }
    public function usertoko(Request $request)
    {
        $id = $request->user_id;
        if (User::where('id', $id)->exists()) {
            $data = User::where('id', $id)->get();
            return response($data, 201);
        } else {
            return response(404);
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Auth()->user()->id;
        User::where('id', $id)->update([
            'name' => $request->input("name"),
            "username" => $request->input("username"),
            "whatsapp" => $request->input("whatsapp"),
            "email" => $request->input("email"),
            "kecamatan" => $request->input("kecamatan"),
            "kelurahan" => $request->input("kelurahan"),
            "password" => Hash::make($request->input("password"))
        ]);
        return response(201);
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
