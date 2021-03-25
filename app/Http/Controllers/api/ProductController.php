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

    // APENAS VIA QUERY STRING
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());

    }

    public function destroy(Request $request, $id = null): array
    {
        $json = ["result" => "", "code" => ""];

        if($request->pass == env("ADMPASS")){
            if($id != 0){
                $product = Product::findOrFail($id);

                $product->delete();

                $json['result'] = ["status" => "REGISTRO DELETADO", "product" => $product];
                $json['code'] = 200;
            }else{
                Product::truncate();

                $json['result'] = "TODOS OS REGISTROS FORAM DELETADOS";
                $json['code'] = 200;
            }
        }else{
            $json['result'] = "SENHA INCORRETA";
            $json['code'] = 10;
        }

        return $json;
    }

    public function uploadImage(Request $request):string
    {
        $imagePath = "";
        if ($request->allFiles() > 0){
            if ($request->file('image') != null){

                $path = public_path() . "/img/upload/" . $request->id . "/";
                $request->file('image')->move($path, "image.jpg");
                $imagePath = $path . "image.jpg";

            }
        }
        return $imagePath;
    }

}
