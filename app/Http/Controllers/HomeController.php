<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function create(HomeRequest $request)
    {
        //validation
        $request->validated();
        //create
        $data = new Home();
        $data->name = $request->name;
        $data->user_id = auth()->user()->id;
        $data->location = $request->location;
        $data->image_path = $request->image_path;
        $data->size = $request->size;
        $data->description = $request->description;
        $data->cost = $request->cost;
        $data->for = $request->for;
        $data->save();
        //json response
        return response()->json([
            'status' => '200',
            'message' => 'new home added successfully'
        ]);

    }

    //show specific home detail
    public function show($id)
    {
        $data = Home::find($id);
        return response()->json([
            'status' => '200',
            'message' => 'info of this home',
            'data' => $data
        ]);
    }

    //list user's homes
    public function list()
    {
        $id = auth()->user()->id;
        $data = Home::where('user_id','=',$id)->get();

        return response()->json([
            'status' => '200',
            'message' => 'homes created by you',
            'data' => $data
        ]);
    }

    //update
    public function update(Request $request)
    {
        //validate
        $request->validate([
            'name' => 'string|min:5',
            'location' => 'string',
            'image_path' => 'string',
            'for' => 'string',
            'size' => 'numeric',
            'description' => 'string',
            'cost' => 'numeric',
        ]);
        //update
        $id = auth()->user()->id;
        $home = Home::where('user_id','=',$id)->first();
        $home->name = isset($request->name) ? $request->name : $home->name;
        $home->location = isset($request->location) ? $request->location : $home->location;
        $home->image_path = isset($request->image_path) ? $request->image_path : $home->image_path;
        $home->size =isset($request->size) ? $request->size : $home->size;
        $home->description =isset($request->description) ? $request->description : $home->description;
        $home->cost = isset($request->cost) ? $request->cost : $home->cost;
        $home->for = isset($request->for) ? $request->for : $home->for;
        $home->update();
        /*
        Home::where('user_id','=',$id)->update([
            isset($request->name) ? $request->name : $home->name ,
            isset($request->location) ? $request->location : $home->location,

        ]);*/

        //response
        return response()->json([
            'status' => '200',
            'message' => 'Home information updated succesfully',
        ]);
    }
}
