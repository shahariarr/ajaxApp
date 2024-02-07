<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{


            $row=User::get();
            return response()->json(['status' => 'success', 'message' => "Request Successful",'data'=>$row]);

        }
        catch(\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);

        }
     }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|min:2'
            ]);

            User::create([
                'name'=>$request->input('name'),

            ]);
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);


        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     try {
    //         $request->validate([
    //             'id' => 'required|string|min:1',
    //             'name' => 'required|string|min:2'
    //         ]);

    //         $id=$request->input('id');

    //         User::where('id',$id)->update([
    //             'name'=>$request->input('name'),
    //         ]);
    //         return response()->json(['status' => 'success', 'message' => "Request Successful"]);

    //     }catch (\Exception $e){
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , $id)
    {


    }

    function UserDelete(Request $request){
        try{
            $request->validate([
                'id' => 'required|string|min:1'
            ]);
            $user_id=$request->input('id');

            User::where('id',$user_id)->delete();
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function UserByID(Request $request){
        try{
            $request->validate([
                'id' => 'required|min:1'
            ]);
            $id=$request->input('id');
            $rows=User::where('id',$id)->first();

            return response()->json(['status' => 'success', 'rows' => $rows]);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }




    function userUpdate(Request $request){
        try {
            $request->validate([
                'id' => 'required|string|min:1',
                'name' => 'required|string|min:2'
            ]);

            $id=$request->input('id');

            User::where('id',$id)->update([
                'name'=>$request->input('name'),
            ]);
            return response()->json(['status' => 'success', 'message' => "Request Successful"]);

        }catch (\Exception $e){
            return response()->json(['status' => 'fail', 'message' =>"Request not Successful"]);
        }
    }
}
