<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\empresa;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Categorias de Producto
        $categorias = Categoria::where('estado', true)->get();
        //Productos
        $productos = Producto::where('estado', true)->get();
        $acategorias = Categoria::where('estado', true)->get()->toArray();
        //Empresa
        $empresa = empresa::get([
                        'nombre',
                        'descripcion',
                        'direccion',
                        'email',
                        'telefono',
                        'fidelizacion'
                    ])->first();

        $data = [
            'categorias' => $categorias,
            'productos' => $productos,
            'acategorias' => $acategorias,
            'empresa' => $empresa 
        ];

        
        
        return view('productos',$data);
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
        //
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
        //
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

    public function obtenerCategorias()
    {
        $categorias = Categoria::where('estado', true)->get();

        return view('productos', compact('categorias'));
    }
}
