<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }
    public function store(Request $request)
    {
        $respuesta = [];
        $validar = $this->validar($request->all());
        if (!is_array($validar)) {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->save();

            array_push($respuesta, ['status' => 'success']);
            return response()->json($respuesta);
        } else {
            return response()->json($validar);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }


    public function update(Request $request)
    {
        $respuesta = [];
        $validar = $this->validar($request->all());
        if (!is_array($validar)) {
            $id = $request->id;
            $product = Product::find($id);
            if ($product) {
                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->stock = $request->stock;
                $product->save();

                array_push($respuesta, ['status' => 'success']);
            } else {
                array_push($respuesta, ['status' => 'error']);
                array_push($respuesta, ['errors' => ['id' => ['No existe el ID']]]);
            }
            return response()->json($respuesta);
        } else {
            return response()->json($validar);
        }
    }


    public function destroy(Request $request)
    {
        $respuesta = [];
        $product = Product::destroy($request->id);
        if ($product) {

            array_push($respuesta, ['status' => 'success']);
        } else {
            array_push($respuesta, ['status' => 'error']);
            array_push($respuesta, ['errors' => ['id' => ['No existe el ID']]]);
        }
        return response()->json($respuesta);
    }

    public function validar($parametros)
    {
        $respuesta = [];
        $messages = [
            'max' => 'El campo :attribute No debe tener más de :max caracteres',
            'required' => 'El campo :attribute No debe de estar vacío',
            'price.numeric' => 'El precio deber ser numérico',
            'stock.numeric' => 'La cantidad deber ser numérico',

        ];
        $attributes = [
            'name' => 'nombre',
            'description' => 'descripción',
            'price' => 'precio',
            'stock' => 'cantidad',

        ];
        $validacion = Validator::make(
            $parametros,
            [
                'name' => 'required|max:80',
                'description' => 'required|max:150',
                'price' => 'required|numeric|max:999999',
                'stock' => 'required|numeric'
            ],
            $messages,
            $attributes
        );
        //para saber si falla la validacion , nos retorne el estado y que error se genero
        if ($validacion->fails()) {
            array_push($respuesta, ['status' => 'error']);
            array_push($respuesta, ['errors' => $validacion->errors()]);
            return $respuesta;
        } else {
            return true;
        }
    }
}
