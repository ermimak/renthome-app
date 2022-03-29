<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        //return profile
        return response()->json([
            'status' => '200',
            'message' => 'profile',
            'data' => auth()->user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        //validation
        $request->validated();
        //check
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email','=',$email)->first();
        if(isset($user))
        {
            if(Hash::check($password,$user->password))
            {
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    'status' => '200',
                    'message' => 'Logged in successfully',
                    'token' => $token
                ]);
            }
            else
            {
                return response()->json([
                    'status' => '201',
                    'message' => 'Wrong password',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => '201',
                'message' => 'wrong user name',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //validation
        //store
        if($request->validated())
        {
            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->save();
        }
        //json response
        return response()->json([
            'status' => '200',
            'message' => 'User stored succesfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        return response()->json([
            'status' => '200',
            'data' => $data
        ]);
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
        //validate
        $request->validate([
            'name' => 'unique:users,name|min:4',
            'email' => 'email|unique:users,email',
            'password' => 'min:8|confirmed'
        ]);
        //update
        $user = auth()->user();
        User::where('id','=',$user->id)->update([
            isset($request->name) ? : $request->name ,
            isset($request->email) ? : $request->email,
            Hash::check($request->password,$user->password) ? : Hash::make($request->password)
        ]);

        //response
        return response()->json([
            'status' => '200',
            'message' => 'User information updated succesfully',
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

    }

    //Log Out
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => '200',
            'message' => 'Logged out'
        ]);
    }
}
