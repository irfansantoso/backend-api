<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function index()
    {
        $post = Post::latest()->get();        
        
        //response JSON
        return response()->json([
            'status' => [
                'code' => 200,
                'response' => "success",                
                'message' => 'success show data'
                
            ],
            'result' => $post
        ],200);

    }

    public function show($id)
    {
        $post = Post::findOrfail($id);
        
        //response JSON
        return response()->json([
            'status' => [
                'code' => 200,
                'response' => "success",                
                'message' => 'Detail Data'
                
            ],
            'result' => $post
        ],200);
        
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $post = Post::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'password' => $request->password,
            'gender' => $request->gender,
            'is_married' => $request->is_married,
            'address' => $request->address
        ]);

        //success save to database
        if($post) {
            
            //response JSON
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => "success",                
                    'message' => 'Successfully Created'
                    
                ],
                'result' => $post
            ],200);

        } 

               
        
        //response failed JSON
        return response()->json([
            'status' => [
                'code' => 409,
                'response' => "Failed",                
                'message' => 'Failed to Save'
                
            ]
        ],409);

    }

    public function update(Request $request, Post $post)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $post = Post::findOrFail($post->id);

        if($post) {

            //update
            $post->update([
                'name'     => $request->name,
                'email'   => $request->email,
                'password'     => $request->password,
                'gender'   => $request->gender,
                'is_married'   => $request->is_married,
                'address'   => $request->address
            ]);
                        
            //response JSON
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => "success",                
                    'message' => 'Successfully Updated'
                    
                ],
                'result' => $post
            ],200);

        }        
        
        //response JSON
        return response()->json([
            'status' => [
                'code' => 409,
                'response' => "Failed",                
                'message' => 'Data Not Found'
                
            ]
        ],404);

    }

    public function detail(Request $request, Post $post)
    {

        //find post by ID
        $post = Post::findOrFail($post->id);

        if($post) {

            $post->detail([
                'name'     => $request->name,
                'email'   => $request->email,
                'password'     => $request->password,
                'gender'   => $request->gender,
                'is_married'   => $request->is_married,
                'address'   => $request->address
            ]);            

        }        
        
        //response JSON
        return response()->json([
            'status' => [
                'code' => 409,
                'response' => "Failed",                
                'message' => 'Data Not Found'
                
            ]
        ],404);

    }

    public function destroy($id)
    {
        $post = Post::findOrfail($id);

        if($post) {

            //delete post
            $post->delete();            
            
            //response JSON
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => "success",                
                    'message' => 'Successfully Deleted'
                    
                ]
            ],200);

        }        
        
        //response Failed JSON
        return response()->json([
            'status' => [
                'code' => 409,
                'response' => "Failed",                
                'message' => 'Data Not Found'
                
            ]
        ],404);
    }
}
