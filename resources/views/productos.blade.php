@extends('layouts.frontend')
@section('styles')
@endsection
@section('content')
<section id="principal">    
    <!--====== SLIDER PART START ======-->        
    <section id="home" class="slider-area pt-100">
        <div class="container-fluid position-relative">
            <div id="carrusel_prod" class="slider-active">
                @if (isset($productos))
                    @foreach($productos as $producto)
                        <div class="single-slider">
                            <div class="slider-bg">
                                <div class="row no-gutters align-items-center ">
                                    <div class="col-lg-4 col-md-5">
                                        <div class="slider-product-image d-none d-md-block">
                                            <img  src="storage/{{ $producto->imagen }}" alt="Slider">
                                            @if ($producto->fidelizacion)
                                                <div class="slider-discount-tag">
                                                    <p>{{ $producto->puntos_canje }}<br> PUNTOS</p>
                                                </div>
                                            @endif
                                        </div> <!-- slider product image -->
                                    </div>
                                    <div class="col-lg-8 col-md-7">
                                        <div class="slider-product-content">
                                            <h1 class="slider-title mb-10" data-animation="fadeInUp" data-delay="0.3s">{{ Str::upper($producto->nombre) }}</h1>
                                            <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">{{ $producto->descripcion }}</p>
                                            <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">$ {{ $producto->precio }}</p>
                                            
                                        </div> <!-- slider product content -->
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- container -->
                        </div> 
                        @if ($loop->iteration == 3)
                        @break
                        @endif
                       
                    @endforeach
                @endif
                
            </div> <!-- slider active -->

            {{--<div id="DescProducto" class="slider-social">
                <div class="single-slider">
                    <div class="slider-bg">
                        <div class="row no-gutters align-items-center ">
                            <div class="col-lg-4 col-md-5">
                                <div class="slider-product-image d-none d-md-block">
                                    
                                    <div class="slider-discount-tag">
                                        <p>FREE<br> QUOTE</p>
                                    </div>
                                </div> <!-- slider product image -->
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="slider-product-content">
                                    <h1 class="slider-title mb-10" data-animation="fadeInUp" data-delay="0.3s">@{{ itemsProducto.nombre }}</h1>
                                    <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">@{{ itemsProducto.Descripcion }}</p>
                                    <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">@{{ itemsProducto.Precio }}</p>
                                    
                                </div> <!-- slider product content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                </div>

                </div>--}}
        </div> <!-- container fluid -->
    </section>        
    <!--====== SLIDER PART ENDS ======-->
    
    <!--====== PRODUCT PART START ======-->        
    <section id="product" class="product-area pt-100 pb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="collection-menu text-center mt-30">
                        <h4 class="collection-tilte">CATEGORÍAS</h4>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="active" id="v-pills-furniture-tab" data-toggle="pill" href="#v-pills-furniture" role="tab" aria-controls="v-pills-furniture" aria-selected="true">Todos</a>
                            @if (isset($categorias))
                                @foreach($categorias as $categoria)
                                <a id="v-pills-{{ $categoria->nombre }}-tab" data-toggle="pill" href="#v-pills-{{ $categoria->nombre }}" role="tab" aria-controls="v-pills-{{ $categoria->nombre }}" aria-selected="false">{{ $categoria->nombre }}</a>
                                @endforeach
                            @endif
                        </div> <!-- nav -->
                    </div> <!-- collection menu -->
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-furniture" role="tabpanel" aria-labelledby="v-pills-furniture-tab">
                            <div class="product-items mt-30">
                                <div class="row">
                                    @if (isset($productos))
                                        @foreach($productos as $producto)
                                            <div class="col-md-4" style="padding-top: 25px;">
                                                <div class="single-product-items">
                                                    <div class="product-item-image">
                                                        <a href="#">
                                                            <img src="storage/{{ $producto->imagen }}" alt="Producto"
                                                            height="320px">
                                                        </a>
                                                        
                                                        @if (isset($empresa))
                                                            @if ($empresa->fidelizacion == 1 && $producto->fidelizacion == 1)
                                                                <div class="product-discount-tag" style="height:90px; width:90px; top:30px; text-align:center; font-size:22px; line-height:30px; vertical-align: 50%; padding:20px 3px 5px 6px; color:#fff;">
                                                                    {{$producto->puntos_canje}} Pts
                                                                </div>
                                                            @endif
                                                        @endif                                                                                                                
                                                    </div>
                                                    <div class="product-item-content text-center mt-30">
                                                        <h5 class="product-title"><a href="#">{{ Str::upper($producto->nombre) }}</a></h5>
                                                        <ul class="rating">
                                                            <li><i class="lni-star-filled"></i></li>
                                                            <li><i class="lni-star-filled"></i></li>
                                                            <li><i class="lni-star-filled"></i></li>
                                                            <li><i class="lni-star-filled"></i></li>
                                                        </ul>
                                                        
                                                        @if ($producto->stock == 0)
                                                            <span class="">No Disponible</span>
                                                            
                                                            <hr>
                                                            <button class="btn btn-default text-center" disabled="disabled">
                                                                Agregar al carrito
                                                            </button>
                                                        @else
                                                            <span class="regular-price">${{ $producto->precio }}</span>

                                                            <agregar-al-carrito
                                                                producto-id="{{ $producto->id }}"
                                                                user-id="{{auth()->user()->id ?? 0}}"
                                                            />
                                                        @endif
                                                        
                                                    </div>                                            
                                                </div> <!-- single product items -->
                                            </div>
                                        @endforeach
                                    @endif                                        
                                </div> <!-- row -->
                            </div> <!-- product items -->
                        </div> <!-- tab pane -->
                        @if (isset($categorias))
                            @foreach($categorias as $categoria)
                            <div class="tab-pane fade" id="v-pills-{{ $categoria->nombre }}" role="tabpanel" aria-labelledby="v-pills-{{ $categoria->nombre }}-tab">
                                <div class="product-items mt-30">
                                    <div class="row">
                                        @if (isset($productos))
                                            @foreach($productos as $producto)
                                                @if ($producto->categoria_id == $categoria->id)
                                                    <div class="col-md-4" style="padding-top: 25px;">
                                                        <div class="single-product-items">
                                                            <div class="product-item-image">
                                                                <a href="#">
                                                                    <img src="storage/{{ $producto->imagen }}" alt="Producto"
                                                                    height="320px">
                                                                </a>
                                                                @if (isset($empresa))
                                                                    @if ($empresa->fidelizacion == 1 && $producto->fidelizacion == 1)
                                                                        <div class="product-discount-tag" style="height:90px; width:90px; top:30px; text-align:center; font-size:20px; line-height:30px; vertical-align: 50%; padding:20px 3px 5px 6px; color:#fff;">
                                                                            {{$producto->puntos_canje}} Pts
                                                                        </div>
                                                                    @endif
                                                                @endif                                                        
                                                            </div>
                                                            <div class="product-item-content text-center mt-30">
                                                                <h5 class="product-title"><a href="#">{{ Str::upper($producto->nombre) }}</a></h5>
                                                                <ul class="rating">
                                                                    <li><i class="lni-star-filled"></i></li>
                                                                    <li><i class="lni-star-filled"></i></li>
                                                                    <li><i class="lni-star-filled"></i></li>
                                                                    <li><i class="lni-star-filled"></i></li>
                                                                </ul>
                                                                
                                                                @if ($producto->stock == 0)
                                                                    <span class="">No Disponible</span>
                                                                    
                                                                    <hr>
                                                                    <button class="btn btn-default text-center" disabled="disabled">
                                                                        Agregar al carrito
                                                                    </button>
                                                                @else
                                                                    <span class="regular-price">${{ $producto->precio }}</span>

                                                                    <agregar-al-carrito
                                                                        producto-id="{{ $producto->id }}"
                                                                        user-id="{{auth()->user()->id ?? 0}}"
                                                                    />
                                                                @endif
                                                                
                                                            </div>                                            
                                                        </div> <!-- single product items -->
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif                                        
                                    </div> <!-- row -->
                                </div> <!-- product items -->
                            </div> <!-- tab pane -->
                            @endforeach
                        @endif
                        <div class="tab-pane fade" id="v-pills-decorative" role="tabpanel" aria-labelledby="v-pills-decorative-tab">
                            <div class="product-items mt-30">
                                <div class="row product-items-active">
                                    <div class="col-md-4">
                                        <div class="single-product-items">
                                            <div class="product-item-image">
                                                <a href="#"><img src="assets/images/product/p-1.jpg" alt="Product"></a>
                                                <div class="product-discount-tag">
                                                    <p>-60%</p>
                                                </div>
                                            </div>
                                            <div class="product-item-content text-center mt-30">
                                                <h5 class="product-title"><a href="#">Touchwood Chair</a></h5>
                                                <ul class="rating">
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                </ul>
                                                <span class="regular-price">$59.00</span>
                                                <span class="discount-price">$69.00</span>
                                            </div>
                                        </div> <!-- single product items -->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-product-items">
                                            <div class="product-item-image">
                                                <a href="#"><img src="assets/images/product/p-2.jpg" alt="Product"></a>
                                                <div class="product-discount-tag">
                                                    <p>-60%</p>
                                                </div>
                                            </div>
                                            <div class="product-item-content text-center mt-30">
                                                <h5 class="product-title"><a href="#">Touchwood Chair</a></h5>
                                                <ul class="rating">
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                </ul>
                                                <span class="regular-price">$59.00</span>
                                                <span class="discount-price">$69.00</span>
                                            </div>
                                        </div> <!-- single product items -->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-product-items">
                                            <div class="product-item-image">
                                                <a href="#"><img src="assets/images/product/p-3.jpg" alt="Product"></a>
                                                <div class="product-discount-tag">
                                                    <p>-60%</p>
                                                </div>
                                            </div>
                                            <div class="product-item-content text-center mt-30">
                                                <h5 class="product-title"><a href="#">Touchwood Chair</a></h5>
                                                <ul class="rating">
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                </ul>
                                                <span class="regular-price">$59.00</span>
                                                <span class="discount-price">$69.00</span>
                                            </div>
                                        </div> <!-- single product items -->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-product-items">
                                            <div class="product-item-image">
                                                <a href="#"><img src="assets/images/product/p-1.jpg" alt="Product"></a>
                                                <div class="product-discount-tag">
                                                    <p>-60%</p>
                                                </div>
                                            </div>
                                            <div class="product-item-content text-center mt-30">
                                                <h5 class="product-title"><a href="#">Touchwood Chair</a></h5>
                                                <ul class="rating">
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                </ul>
                                                <span class="regular-price">$59.00</span>
                                                <span class="discount-price">$69.00</span>
                                            </div>
                                        </div> <!-- single product items -->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-product-items">
                                            <div class="product-item-image">
                                                <a href="#"><img src="assets/images/product/p-2.jpg" alt="Product"></a>
                                                <div class="product-discount-tag">
                                                    <p>-60%</p>
                                                </div>
                                            </div>
                                            <div class="product-item-content text-center mt-30">
                                                <h5 class="product-title"><a href="#">Touchwood Chair</a></h5>
                                                <ul class="rating">
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                    <li><i class="lni-star-filled"></i></li>
                                                </ul>
                                                <span class="regular-price">$59.00</span>
                                                <span class="discount-price">$69.00</span>
                                            </div>
                                        </div> <!-- single product items -->
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- product items -->
                        </div> <!-- tab pane -->

                    </div> <!-- tab content --> 
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>        
    <!--====== PRODUCT PART ENDS ======-->

    <!--====== FOOTER PART START ======-->        
    <section id="footer" class="footer-area">
        <div class="container text_center">
            <div class="footer-widget pt-75 pb-75">
                <div class="row">
                    <div class="col-lg-3 col-md-5 col-sm-7">
                        <div class="footer-logo mt-40">
                            <a href="#">
                                <img src="assets/images/logo.png" alt="Logo">
                            </a>

                            @if (isset($empresa))
                                <p class="mt-10">{{Str::upper($empresa->nombre)}}</p>
                                <p class="mt-10">{{Str::upper($empresa->descripcion)}}</p>
                            @endif                           
                            
                        </div> <!-- footer logo -->
                    </div>                 
                    <div class="col-lg-4 col-md-5 col-sm-7">
                        <div class="footer-info mt-50">
                            <h5 class="f-title">Contacto</h5>
                            <ul>
                                <li>
                                    <div class="single-footer-info mt-20">
                                        <span>Teléfono :</span>
                                        <div class="footer-info-content">
                                            <p>{{$empresa->telefono}}</p>
                                        </div>
                                    </div> <!-- single footer info -->
                                </li>
                                <li>
                                    <div class="single-footer-info mt-20">
                                        <span>Email :</span>
                                        <div class="footer-info-content">
                                            <p>{{$empresa->email}}</p>
                                        </div>
                                    </div> <!-- single footer info -->
                                </li>
                                <li>
                                    <div class="single-footer-info mt-20">
                                        <span>Dirección: </span>
                                        <div class="footer-info-content">
                                            <p> {{ $empresa->direccion }}</p>
                                        </div>
                                    </div> <!-- single footer info -->
                                </li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                </div> <!-- row -->
            </div> <!-- footer widget -->            
            <div class="footer-copyright pt-15 pb-15">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright text-center">
                            <p>Creado por Jorge Castro</p>
                        </div> <!-- copyright -->
                    </div>
                </div> <!-- row -->
            </div> <!--  footer copyright -->
        </div> <!-- container -->
    </section>        
    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TO TOP PART START ======-->        
    <a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>        
    <!--====== BACK TO TOP PART ENDS ======-->
</section>


@endsection

@section('scripts')
    <script type="text/javascript">
        var aCategorias={!! json_encode($acategorias) !!};
        var aProductos={!! json_encode($productos) !!};


    </script>
@endsection
        
        