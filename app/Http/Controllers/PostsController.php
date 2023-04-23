<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostsController extends Controller
{
    public function posts(Request $request , $id){


        $post =  Post::where("category_id" , $id)->get();
        // $Category =  Category::all();
        $data = [
            'data' => $post 
        ];
        return response()->json($data, 200);


    }


    public function post(Request $request , $id){


        $post =  Post::where("id" , $id)->first();
        // $Category =  Category::all();
        $data = [
            'data' => $post 
        ];
        return response()->json($data, 200);


    }
}
