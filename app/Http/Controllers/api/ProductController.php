<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\directoryExists;

class ProductController extends Controller
{
    public function get(Request $request)
    {
        if ($request->pass != null){
            return $this->delete($request);
        }

        $id = $request->id;

        if($id == null){ // GET ALL PRODUCTS
            return Product::all();
        }else{ // GET A SPECIFIC PRODUCT
            return (Product::find($id) != null)
                ? Product::find($id)
                : json_encode([ "result" => "PRODUTO NAO ENCONTRADO", "code" => 404]);
        }
    }

    public function post(Request $request)
    {

        if($request->update == "true"){ // METHOD PUT
            return $this->put($request);
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

    public function put(Request $request)
    {
        $id = $request->id;

        if ($request->id == null ||
            $request->name == null ||
            $request->description == null ||
            $request->price == null )
            return json_encode([
                "result" => "PARAMETROS INVALIDOS",
                "code" => 400
            ]);

        $product = Product::find($id);
        if($product == null){
            return json_encode([
                "result" => "PRODUTO NAO ENCONTRADO",
                "code" => 404
            ]);
        }

        $product->id = $request->id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $imagePath = $this->uploadImage($request);
        $product->image = ($imagePath != "") ? $imagePath : $product->image;
        $product->updated_at = date("Y-m-d H:i:s", time());
        $product->update();

        return json_encode([
            "result" => "REGISTRO ATUALIZADO",
            "code" => 200
        ]);

    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $json = ["result" => "", "code" => ""];

        if($request->pass == env("ADMPASS")){
            if($id != 0){

                $product = Product::findOrFail($id);

                $product->delete();
                $this->deletarDiretorio($id);

                $json['result'] = "REGISTRO DELETADO";
                $json['code'] = 200;
            }else{

                $json['result'] = "PARAMETROS INVÁLIDOS, FORNEÇA UM ID";
                $json['code'] = 404;
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
                $ext = $request->file('image')->extension();

                if ($ext != "jpg" && $ext != "jpeg" && $ext != "png"){
                    die(json_encode([
                        "result" => "FORMATO DE IMAGEM INVÁLIDO",
                        "code" => 400
                    ]));
                }

                $path = public_path() . "/img/upload/" . $request->id . "/";

                $request->file('image')->move($path, "image.jpg");

                $fullPath = "/tecpaper/public/img/upload/{$request->id}/image.jpg";
            }
        }
        return $fullPath;
    }

    private function deletarDiretorio($id)
    {
        $path = public_path() . "/img/upload/" . $id . "/";
        if(directoryExists($path)){
            File::deleteDirectory($path);
        }
    }
}
