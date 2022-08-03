<?php

namespace App\Http\Controllers;

use App\Models\carrito;
use App\Models\empresa;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaymentPayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $payPalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],
                $payPalConfig['secret']
            )
        );

        $this->apiContext->setConfig($payPalConfig['settings']);
    }

    public function getCartItems()
    {
        //$fechaActual = date('Y-m-d');
        $user_id = auth()->user()->id;

        $carritoItems = carrito::with('producto')
                        ->where('user_id', $user_id)
                        //->whereDate('created_at', $fechaActual)
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
                            $empresa = empresa::all()->first();
                            $impuesto = ($empresa->impuesto / 100);
                            $impuestoNeto = ($impuesto + 1); 
                            $puntosCanje=Producto::where('id',$carritoItem->producto_id)->get('puntos_canje')->first();
                            
                            $finalData[$carritoItem->producto_id]['id'] = $carritoProducto->id;
                            $finalData[$carritoItem->producto_id]['Puntos'] = $puntosCanje->puntos_canje;
                            $finalData[$carritoItem->producto_id]['nombre'] = $carritoProducto->nombre;
                            $finalData[$carritoItem->producto_id]['cantidad'] = $carritoItem->cantidad;
                            $finalData[$carritoItem->producto_id]['precio'] = $carritoItem->precio;
                            $finalData[$carritoItem->producto_id]['total'] = $carritoItem->precio * $carritoItem->cantidad;
                            
                            $total += $carritoItem->precio * $carritoItem->cantidad;
                            $subtotal = ($total / $impuestoNeto);
                            $iva = ($subtotal * $impuesto);
                            $valorTotal = $subtotal + $iva;

                            $finalData['impuesto'] = $empresa->impuesto;  
                            $finalData['subtotal'] = number_format($subtotal, 2);
                            $finalData['iva'] = number_format($iva, 2); 
                            $finalData['valorTotal'] = number_format($valorTotal, 2);
                        }
                    }
                }
            }
        }

        return response()->json([
            'datos' => $finalData,
            //'usuario'=>auth()->user()
        ]);
    }

    public function payWithPayPal()
    {
        $user_id = auth()->user()->id;

        $carritoItems = carrito::with('producto')
                        ->where('user_id', $user_id)
                        //->whereDate('created_at', $fechaActual)
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
                            $empresa = empresa::all()->first();
                            $impuesto = ($empresa->impuesto / 100);
                            $impuestoNeto = ($impuesto + 1); 
                            $puntosCanje=Producto::where('id',$carritoItem->producto_id)->get('puntos_canje')->first();
                            
                            $finalData[$carritoItem->producto_id]['id'] = $carritoProducto->id;
                            $finalData[$carritoItem->producto_id]['Puntos'] = $puntosCanje->puntos_canje;
                            $finalData[$carritoItem->producto_id]['nombre'] = $carritoProducto->nombre;
                            $finalData[$carritoItem->producto_id]['cantidad'] = $carritoItem->cantidad;
                            $finalData[$carritoItem->producto_id]['precio'] = $carritoItem->precio;
                            $finalData[$carritoItem->producto_id]['total'] = $carritoItem->precio * $carritoItem->cantidad;
                            
                            $total += $carritoItem->precio * $carritoItem->cantidad;
                            $subtotal = ($total / $impuestoNeto);
                            $iva = ($subtotal * $impuesto);
                            $valorTotal = $subtotal + $iva;

                            $finalData['impuesto'] = $empresa->impuesto;  
                            $finalData['subtotal'] = number_format($subtotal, 2);
                            $finalData['iva'] = number_format($iva, 2); 
                            $finalData['valorTotal'] = number_format($valorTotal, 2);
                        }
                    }
                }
            }
        }

        $data = [
            'datos' => collect($finalData)
        ];

        //dd($data);

        return view('pages.checkout', $data);
    }

    public function payPalStatus(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
            //return redirect('/paypal/failed')->with(compact('status'));
            return redirect('/checkout')->with(compact('status'));
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            $status = 'Gracias! El pago a través de PayPal se ha ralizado correctamente.';
            return redirect('/checkout')->with(compact('status'));
        }

        $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
        return redirect('/checkout')->with(compact('status'));
    }

    public function paypalPaymentResponse()
    {
        return view('pages.response');
    }

    public function payOrderPayPal(Request $request)
    {
        $pedidos = $request->get('pedido');

        $total = (float) str_replace(',', '', $pedidos['valorTotal']);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($total);
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        // $transaction->setDescription('See your IQ results');

        $callbackUrl = url('/paypal/status');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    
}
