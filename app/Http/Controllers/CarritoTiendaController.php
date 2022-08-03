<?php

namespace App\Http\Controllers;

use App\Models\CabeceraPedido;
use App\Models\carrito;
use App\Models\empresa;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe;

class CarritoTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.checkout');
        
        //return view('pages.checkout', compact($this->getCartItemsForCheckout()));
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
        //Obtener información del producto
        $producto_id = $request->get('producto_id');
        $user_id = auth()->user()->id;  
        $producto = Producto::where('id', $producto_id)->first();

        if (!$producto_id) {
            $totalItems = carrito::where('user_id', $user_id)
                            ->sum('cantidad');

            return [
                'message'=>'Articulos del carrito total',
                'code' => 200,
                'items' => $totalItems
            ];
        }

        $productoEnCarrito = carrito::where('producto_id', $producto_id)
                                ->where('user_id', $user_id)
                                ->get();

        if ($productoEnCarrito->isEmpty()) {
            //Agregar producto al carrito
            $carrito  = carrito::create([
                'producto_id' => $producto->id,
                'cantidad' => 1,
                'precio' => $producto->precio,
                'user_id' => $user_id,
            ]);
        } else {
            
            $cantidadCarritoActual = carrito::where('producto_id', $producto_id)
                        ->where('user_id', $user_id)
                        ->first();

            // Valida que no se exceda la cantidad del producto en base al stock    
            if ($cantidadCarritoActual->cantidad < $producto->stock) {
                //Si ya existe el producto en el carrito, se incrementa la cantidad
                $carrito = carrito::where('producto_id', $producto_id)->increment('cantidad');
            } else {
                $totalItems = carrito::where('user_id', $user_id)
                            //->whereDate('created_at', $fechaActual)
                            ->sum('cantidad');

                return [
                    'message'=>'No existe suficiente stock para este producto!!',
                    'code' => 999,
                    'items' => $totalItems 
                ];
            }
        }

        // Verificamos los productos del usuario en el carrito
        if ($carrito) {
            $totalItems = carrito::where('user_id', $user_id)
                            //->whereDate('created_at', $fechaActual)
                            ->sum('cantidad');

            return [
                'message'=>'Carrito de compras actualizado!!',
                'code' => 200,
                'items' => $totalItems 
            ];
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

    public function getCartItemsForCheckout()
    {
        $user_id = auth()->user()->id;

        $carritoItems = carrito::with('producto')
                        ->where('user_id', $user_id)
                        ->get();

        $finalData = [];
        $total = 0;
        $subtotal = 0;
        $iva = 0;
        $valorTotal = 0;

        if (isset($carritoItems)) {
            foreach($carritoItems as $carritoItem) {
                if ($carritoItem->producto) {
                    foreach($carritoItem->producto as $carritoProducto) {
                        if($carritoProducto->id == $carritoItem->producto_id) {
                            $empresa = empresa::get([
                                'impuesto',
                                'fidelizacion',
                                'condiciones'
                            ])->first();

                            $condiciones = json_decode($empresa->condiciones, TRUE);
                            $aplicaEn = $condiciones['aplicaEn'];
                            $montoFactura = $condiciones['montoFactura'];
                            $puntosAcumulacionPorCompra = $condiciones['puntosAcumulacionPorCompra'];

                            $impuesto = ($empresa->impuesto / 100);
                            $impuestoNeto = ($impuesto + 1); 
                            
                            $finalData[$carritoItem->producto_id]['id'] = $carritoProducto->id;
                            $finalData[$carritoItem->producto_id]['Puntos'] = $carritoProducto->puntos_canje;
                            $finalData[$carritoItem->producto_id]['nombre'] = $carritoProducto->nombre;
                            $finalData[$carritoItem->producto_id]['cantidad'] = (int) $carritoItem->cantidad;
                            $finalData[$carritoItem->producto_id]['precio'] = $carritoItem->precio;
                            $finalData[$carritoItem->producto_id]['total'] = $carritoItem->precio * $carritoItem->cantidad;
                            
                            $total += $carritoItem->precio * $carritoItem->cantidad;
                            $subtotal = ($total / $impuestoNeto);
                            $iva = ($subtotal * $impuesto);
                            $valorTotal = $subtotal + $iva;
                            
                            $finalData['fidelizacion'] = $empresa->fidelizacion;
                            $finalData['aplicaEn'] = $aplicaEn;
                            $finalData['montoFactura'] = $montoFactura;
                            $finalData['puntosAcumulacionPorCompra'] = $puntosAcumulacionPorCompra;
                            
                            $finalData['impuesto'] = $empresa->impuesto;  
                            $finalData['subtotal'] = number_format($subtotal, 2);
                            $finalData['iva'] = number_format($iva, 2); 
                            $finalData['valorTotal'] = number_format($valorTotal, 2);

                            $PuntosAcumula = (($valorTotal * $puntosAcumulacionPorCompra) / $montoFactura);
                            $clientePuntosAcumula = number_format((float) $PuntosAcumula, 2);
                            $puntos = (float) $clientePuntosAcumula;
                            $finalData['totalTransaccionPuntos'] = $puntos;
                        }
                    }
                }
            }
        }

        

        $cliente = User::where('id', $user_id)
                    ->get([
                        'id',
                        'name',
                        'email',
                        'direccion',
                        'telefono',
                        'referencia',
                        'puntos_acumulados'
                    ])->first();

        return response()->json([
            'datos' => $finalData,
            'cliente' => $cliente
        ]);
    }

    public function procesarPago(Request $request)
    {
        if ($request->get('formaPago') == 'tarjeta') {
            $tarjeta = $request->get('tarjeta');
            $mesExpiracion = $request->get('mesExpiracion');
            $anioExpiracion = $request->get('anioExpiracion');
            $cvv = $request->get('cvv');
            $numeroTarjeta = $request->get('numeroTarjeta');
        }

        $idCliente = $request->get('idCliente');
        $pedidos = $request->get('pedido');
        $totalTransaccionPuntos = $request->get('totalTransaccionPuntos');
        
        $impuesto = (int) $pedidos['impuesto'];
        $subtotal = (float) str_replace(',', '', $pedidos['subtotal']);
        $iva = (float) str_replace(',', '', $pedidos['iva']);
        $total = (float) str_replace(',', '', $pedidos['valorTotal']);
        
        unset(
            $pedidos['impuesto'],
            $pedidos['subtotal'],
            $pedidos['iva'],
            $pedidos['valorTotal'],
            $pedidos['fidelizacion'],
            $pedidos['aplicaEn'],
            $pedidos['montoFactura'],
            $pedidos['puntosAcumulacionPorCompra'],
            $pedidos['totalTransaccionPuntos']
        );

        foreach ($pedidos as $pedido) {
            if ($pedido['id']) {
                $pedidoArray[] = array(
                    "producto_id" => $pedido['id'],
                    "cantidad" => $pedido['cantidad'],
                    "precio" => number_format((float) $pedido['precio'], 2)
                );
            }
        }

        if (isset($pedidoArray)) {
            try {
                $fechaHoraActual = date('Y-m-d H:i:s');
                $cabecera = CabeceraPedido::create([
                    'user_id' => $idCliente,
                    'impuesto' => $impuesto,
                    'subtotal' => $subtotal,
                    'iva' => $iva,
                    'total' => $total,
                    'forma_pago' => $request->get('formaPago'),
                    'estado' => 'Finalizado',
                    'fecha_creacion' => $fechaHoraActual
                ]);

                $cabecera->detalle()->createMany($pedidoArray);

                // Limpiamos el caarito de compras
                carrito::where('user_id', $idCliente)->delete();

                //Acumulación de puntos
                if ($request->get('formaPago') != 'canjePuntos') {
                    $empresa = empresa::get([
                        'fidelizacion',
                        'condiciones'
                    ])->first();

                    $aplicaFdz = $empresa->fidelizacion;
                    $clientePuntosAcumula = 0;
                    $puntos = 0;

                    if ($aplicaFdz) {
                        $condiciones = json_decode($empresa->condiciones, TRUE);
                        $aplicaEn = $condiciones['aplicaEn'];
                        $montoFactura = $condiciones['montoFactura'];
                        $puntosAcumulacionPorCompra = $condiciones['puntosAcumulacionPorCompra'];
                        
                        if ($aplicaEn == 'totalFactura') {
                            $PuntosAcumula = (($total * $puntosAcumulacionPorCompra) / $montoFactura);
                            $clientePuntosAcumula = number_format((float) $PuntosAcumula, 2);
                            $puntos = (float) $clientePuntosAcumula; 
                        }
                    }

                    $puntosActualesCliente = User::where('id', $idCliente)->get('puntos_acumulados')->first();
                    $puntosCliente = (float) $puntosActualesCliente->puntos_acumulados;
                    $puntosTotalesAcumulados = $puntos + $puntosCliente;

                    User::where('id', $idCliente)->update(['puntos_acumulados' => $puntosTotalesAcumulados]);
                }

                //Canje de puntos
                if ($request->get('formaPago') == 'canjePuntos') {
                    $puntosActualesCliente = User::where('id', $idCliente)->get('puntos_acumulados')->first();
                    $puntosCliente = (float) $puntosActualesCliente->puntos_acumulados;
                    $puntosTotalesAcumulados = $puntosCliente - $totalTransaccionPuntos;

                    User::where('id', $idCliente)->update(['puntos_acumulados' => $puntosTotalesAcumulados]);
                }

                return [
                    'success'=>'Pedido ingresado con exito!!',
                    'code' => 200 
                ];
            } catch (\Throwable $th) {
                return [
                    'error'=>'Pedido fallido, por favor intentelo más tarde o comuniquese con soporte',
                    'code' => 500 
                ];
            }
        }
    }

    public function aumentarODisminuirCantidad(Request $request)
    { 
        $cantidad = (int) $request->cantidad;
        
        try {
            carrito::where([
                ['user_id', '=', $request->idCliente],
                ['producto_id', '=', $request->idProducto]
            ])->update(['cantidad' => $cantidad]);

            return [
                'success'=>'Cantidad actualizada',
                'code' => 200 
            ];
        } catch (\Throwable $th) {
            return [
                'error' => 'Pedido fallido, por favor intentelo más tarde o comuniquese con soporte',
                'code' => 500 
            ];
        }
    }

    public function eliminarProducto(Request $request)
    {
        try {
            // Limpiamos el caarito de compras
            carrito::where([
                ['user_id', '=', $request->idCliente],
                ['producto_id', '=', $request->idProducto]
            ])->delete();

            return [
                'success'=>'Producto Eliminado',
                'code' => 200 
            ];
        } catch (\Throwable $th) {
            return [
                'error' => 'Pedido fallido, por favor intentelo más tarde o comuniquese con soporte',
                'code' => 500 
            ];
        }
    }
}
