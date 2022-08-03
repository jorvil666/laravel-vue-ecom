<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
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
        $categorias = Categoria::All();

        return $categorias;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->estado = true;

            $categoria->save();

            return response()->json([
                'estado' => 201
                , 'mensaje' => 'Registro agregado exitosamente!!'
            ], 201);
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error('al insertar Categoria: '.$request.' '.$ex->getMessage());

            return response()->json([
                'estado' => 400
                , 'mensaje' => 'Ha ocurrido un error, por favor inténtelo más tarde!!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            if (Categoria::where('id', $id)->exists()) {
                $categoria = Categoria::find($request->id);
                $categoria->nombre = $request->nombre;
                $categoria->descripcion = $request->descripcion;
                $categoria->estado = $request->estado;
    
                $categoria->save();
    
                return response()->json([
                    'estado' => 200
                    , 'mensaje' => 'Registro actualizado exitosamente!!'
                ], 200);
            } else {
                return response()->json([
                    'estado' => 400
                    , 'mensaje' => 'No existe el registro a ser actualizado!!'
                ], 404);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error('al actualizar Categoria: '.$request.' '.$ex->getMessage());

            return response()->json([
                'estado' => 400
                , 'mensaje' => 'Ha ocurrido un error, por favor inténtelo más tarde!!'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
