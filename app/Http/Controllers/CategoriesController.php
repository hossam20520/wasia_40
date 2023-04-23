<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    //

    public function categories(){


        $Category =  Category::where("isparent" , 1)->get();
        // $Category =  Category::all();
        $data = [
            'data' => $Category
        ];
        return response()->json($data, 200);


    }


    public function GetParentscategories(Request $request , $id){


        $Category =  Category::where("parent_category_id" , $id)->get();
        // $Category =  Category::all();
        $data = [
            'data' => $Category
        ];
        return response()->json($data, 200);


    }


    


 
}
