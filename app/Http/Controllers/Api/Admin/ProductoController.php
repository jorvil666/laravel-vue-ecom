<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth:api');
    }*/
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $response = [];
            
            $productos = Producto::All();

            foreach ($productos as $producto)
            {
                $response[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'stock' => $producto->stock,
                    'precio' => $producto->precio,
                    'imagen' => $producto->imagen,
                    'ratings' => $producto->ratings,
                    'fidelizacion' => $producto->fidelizacion,
                    'estado' => $producto->estado,
                    'categoria' => $producto->categorias->only(['id', 'nombre'])
                ];
            }

            return response()->json($response, 200);

        } catch (\Throwable $th) {
            Log::error('al consultar Producto: '.$th->getMessage());

            return response()->json(
                [
                    'error' => 'Ha ocurrido un error, por favor inténtelo más tarde!!',
                    'code' => 500
                ],
                500
            );
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $imagen = '';

            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->stock = $request->stock;
            $producto->precio = $request->precio;
            $producto->ratings = $request->ratings;          
            $producto->fidelizacion = $request->fidelizacion;
            $producto->estado = true;
            $producto->categoria_id = $request->categoria_id;
            //$producto->imagen = null;
            
            if(!empty($request->imagen)){
                $imagen = $request->imagen->store('public/images/productos');
            }

            $producto->imagen = Str::substr($imagen, 7);
            

            $producto->save();
            
            return response()->json(
                [
                    'success' => 'Registro agregado exitosamente!!',
                    'code' => 201
                ],
                201
            );

        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error('al insertar Prodcuto: '.$request.' '.$ex->getMessage());

            return response()->json(
                [
                    'error' => 'Ha ocurrido un error, por favor inténtelo más tarde!!',
                    'code' => 500
                ],
                500
            );
        }
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if (Producto::where('id', $id)->exists()) {
                $producto = Producto::find($request->id);
                $producto->nombre = $request->nombre;
                $producto->descripcion = $request->descripcion;                
                $producto->stock = $request->stock;
                $producto->precio = $request->precio;
                $producto->ratings = $request->ratings;
                $producto->imagen = $request->imagen;
                $producto->fidelizacion = $request->fidelizacion;
                $producto->estado = $request->estado;
                $producto->categoria_id = $request->categoria_id;

                $producto->save();

                return response()->json(
                    [
                        'success' => 'Registro actualizado exitosamente!!',
                        'code' => 200
                    ],
                    200
                );
    
            } else {
                return response()->json(
                    [
                        'error' => 'No existe el registro a ser actualizado!!',
                        'code' => 404
                    ],
                    404
                );
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error('al actualizar Prodcuto: '.$request.' '.$ex->getMessage());

            return response()->json(
                [
                    'error' => 'Ha ocurrido un error, por favor inténtelo más tarde!!',
                    'code' => 500
                ],
                500
            );
        }
    }
    

    public function obtenerCategorias()
    {
        try {
            $response = [];

            $categorias = Categoria::where('estado', true)->get();

            foreach ($categorias as $categoria) {
                $response[] = [
                    'id' => $categoria->id,
                    'nombre' => $categoria->nombre
                ];
            }
    
            return response()->json($response, 200);

        } catch (\Throwable $th) {
            Log::error('al consultar ProdcutoCategoias: '.$th->getMessage());

            return response()->json(
                [
                    'error' => 'Ha ocurrido un error, por favor inténtelo más tarde!!',
                    'code' => 500
                ],
                500
            );
        }
    }
}
