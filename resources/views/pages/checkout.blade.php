@extends('layouts.frontend')
@section('styles')
    <!--====== Style Checkout ======-->
    <link rel="stylesheet" href="assets/css/checkout.css">
@endsection
@section('content')
    <div class="container checkoutBox">
        @if (session('status'))
            <div class="alert alert-success text-center" role="alert">
                <h4>Gracias! El pago a través de PayPal se ha realizado correctamente.</h4>
                <br/>
                <h4>Por favor, presione el botón continuar para finalizar la trasacción.</h4>
            </div>
        @endif
    </div>

    <checkout></checkout>
    <!--<payment></payment>-->
@endsection