<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    // GET PRODUCTS
    public function index()
    {
        return Product::all();
    }

    // GET PRODUCTS WITH ID
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    // POST PRODUCTS
    public function store(Request $request)
    {
        // RECEBENDO E REQUISIÇÃO 'PUT' VIA 'POST' E TRANSFERINDO PARA A FUNÇÃO ESPECÍFICA
        if($request->update == "true"){
            return $this->update($request, $request->id);
        }

        if ($request->id == null ||
            $request->name == null ||
            $request->description == null ||
            $request->price == null )
                return json_encode([
                    "result" => "PARAMETROS INVALIDOS",
                    "code" => 400
                ]);

        if (Product::find($request->id) != null)
            return json_encode([
                "result" => "REGISTRO JA EXISTENTE",
                "code" => 400
            ]);

        $product = new Product();
        $product->id = $request->id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $this->uploadImage($request);
        $product->created_at = date("Y-m-d H:i:s", time());
        $product->updated_at = date("Y-m-d H:i:s", time());
        $product->save();

        return json_encode([
           "result" => "REGISTRO INSERIDO",
           "code" => 200
        ]);
    }

    // PUT PRODUCTS
    public function update(Request $request, $id)
    {
        if ($request->id == null ||
            $request->name == null ||
            $request->description == null ||
            $request->price == null )
            return json_encode([
                "result" => "PARAMETROS INVALIDOS",
                "code" => 400
            ]);

        $product = Product::findOrFail($id);
        $product->id = $request->id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = ($this->uploadImage($request) != "") ? $this->uploadImage($request) : $product->image;
        $product->updated_at = date("Y-m-d H:i:s", time());
        $product->update();

        return json_encode([
            "result" => "REGISTRO ATUALIZADO",
            "code" => 200
        ]);
    }

    // DELETE PRODUCTS
    public function destroy(Request $request, $id = null)
    {

        $json = ["result" => "", "code" => ""];

        if($request->pass == env("ADMPASS")){
            if($id != 0){
                $product = Product::findOrFail($id);

                $product->delete();

                $json['result'] = ["status" => "REGISTRO DELETADO", "product" => $product];
                $json['code'] = 200;
            }else{
                // DELETE ALL PRODUCTS
                Product::truncate();

                $json['result'] = "TODOS OS REGISTROS FORAM DELETADOS";
                $json['code'] = 200;
            }
        }else{
            $json['result'] = "ACESSO NAO PERMITIDO";
            $json['code'] = 400;
        }

        return json_encode($json);
    }

    public function uploadImage(Request $request):string
    {
        $fullPath = "";
        if ($request->allFiles() > 0){
            if ($request->file('image') != null){

                $path = public_path() . "/img/upload/" . $request->id . "/";
                $fullPath = $path . "image.jpg";

                if(!file_exists($fullPath)){
                    $request->file('image')->move($path, "image.jpg");
                }
            }
        }
        return $fullPath;
    }

}
