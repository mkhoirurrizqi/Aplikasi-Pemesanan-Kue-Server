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
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
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
        $request->user()->tokens()->delete();
        return response('Loggedout', 200);
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
    public function edit(Request $request)
    {
        $user = User::findorfail($request->id);
        return response()->json($user->makeHidden('token'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        User::where('id', $id)->update([
            'name' => $request->input("name"),
            "username" => $request->input("username"),
            "whatsapp" => $request->input("whatsapp"),
            "email" => $request->input("email"),
            "kecamatan" => $request->input("kecamatan"),
            "kelurahan" => $request->input("kelurahan"),
            "password" => Hash::make($request->input("password"))
        ]);
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
