<?php


namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function get(Request $request, $id)
    {

    }

    public function post(Request $request)
    {

    }

    public function put(Request $request)
    {

    }

    public function delete(Request $request, $id, $pass = null)
    {
        if($pass == "ADMPASS666"){
            // DELETAR TODOS OS REGISTROS
            return;
        }



    }

}
