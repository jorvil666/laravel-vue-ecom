<template>
    <div>
        <div class="container checkoutBox">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                    <div class="box">
                        <h3 class="box-title">Productos en su carrito</h3>                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>                                    
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items" :key="item.id">
                                    <template v-if="item.nombre">
                                        <th scope="row">
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminarProductos(item.id)">X</button>
                                        </th>                                        
                                        <td>{{ item.nombre }}</td>
                                        <td>
                                            <div class="input-group w-auto align-items-center">
                                                <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity" @click="disminuirCantidad($event, item.id)">
                                                <input type="number" step="1" max="10" :value="item.cantidad" name="quantity" class="quantity-field border-0 text-center w-25" disabled="disabled">
                                                <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity" @click="aumentarCantidad($event, item.id)">
                                            </div>
                                        </td>
                                        <td>$ {{ item.precio }}</td>
                                    </template>
                                </tr>                                
                            </tbody>
                        </table>
                        <br>

                        <div class="alert alert-primary" role="alert">
                            Por cada compra superior a ${{items.montoFactura}} puede acumular {{items.puntosAcumulacionPorCompra}} puntos.
                            <br>
                            <div>
                                <b>Aplica unicamente para pagos con Tarjeta y PayPal</b>
                            </div>
                        </div>

                        <hr style="background-color: blue; height: 1px; border: 0;" />

                        <!--SHIPPING METHOD-->
                        <div class="panel panel-info">
                            <div class="panel-body">

                                <div class="col-md-12">
                                    <h3 class="box-title">Información de Cliente</h3>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Nombres:</b> {{ cliente.name }}</li>                                        
                                        <li class="list-group-item"><b>Email:</b> {{ cliente.email }}</li>
                                        <li class="list-group-item"><b>Teléfono:</b> {{ cliente.telefono }}</li>
                                        <li class="list-group-item"><b>Dirección:</b> {{ cliente.direccion }}</li>
                                        <li class="list-group-item"><b>Refencia:</b> {{ cliente.referencia }}</li>
                                        <li class="list-group-item"><b>Puntos Acumulados:</b>
                                            <template v-if="cliente.puntos_acumulados > 0.00">
                                                <span class="badge badge-success"><h6 style="color:#fff;">{{ cliente.puntos_acumulados }}</h6></span>
                                            </template>
                                            <template v-else>
                                                <span class="badge badge-warning"><h6 style="color:#fff;">{{ cliente.puntos_acumulados }}</h6></span>
                                            </template>
                                        </li>
                                    </ul> 
                                </div>
                                <br>                                
                            </div>
                        </div>
                        <!--SHIPPING METHOD END-->
                        <hr style="background-color: blue; height: 1px; border: 0;" />
                        <!--CREDIT CART PAYMENT-->
                        <div class="panel panel-info" v-if="parseFloat(items.valorTotal).toFixed(2) > 0">                            
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h3 class="box-title">Método de Pago</h3>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioTarjeta" id="radioTarjeta" value="tarjeta" v-model="modoPago" @change="validarModoPago($event)" >
                                        <label class="form-check-label" for="exampleRadios1">
                                            Tarjeta (Se finzalizar la transacción como ejemplo)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioPaypal" id="radioPaypal" value="paypal" v-model="modoPago" @change="validarModoPago($event)">
                                        <label class="form-check-label" for="exampleRadios2">
                                            PayPal                                        
                                        </label>
                                    </div>

                                    <br>
                                    <div class="form-check" v-if="cliente.puntos_acumulados >= items.totalTransaccionPuntos">
                                        <input class="form-check-input" type="radio" name="radioPuntos" id="radioPuntos" value="canjePuntos" v-model="modoPago" @change="validarModoPago($event)">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Canjear con Puntos                                        
                                        </label>
                                    </div>
                                </div>                                

                                <br>
                                
                                <template v-if="modoPago == 'tarjeta'">
                                    <div class="alert alert-secondary">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputState">Tarjeta:</label>                                    
                                                <select
                                                    id="CreditCardType"                                            
                                                    name="tarjeta"
                                                    v-model="tarjeta"
                                                    class="form-control"
                                                >
                                                    <option selected>Seleccione...</option>
                                                    <option value="5">Visa</option>
                                                    <option value="6">MasterCard</option>
                                                    <option value="7">American Express</option>
                                                    <option value="8">Discover</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="inputPassword4">Número de Tarjeta:</label>
                                                <input type="text" class="form-control" id="inputApellidos" name="numeroTarjeta" v-model="numeroTarjeta" placeholder="0000 0000 0000 0000" size="18" minlength="19" maxlength="19">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">CVV:</label>
                                                <input type="text" class="form-control" id="inputApellidos" name="cvv" v-model="cvv" placeholder="000" size="1" minlength="3" maxlength="3">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">Fecha Expiración:</label>
                                                <input type="text" class="form-control" name="fechaExp" v-model="fechaExp" placeholder="MM/YY" size="6" id="exp" minlength="5" maxlength="5">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <span span></span>
                                            </div>
                                            <div class="col-md-12">
                                                <ul class="cards">
                                                    <li class="visa hand">Visa</li>
                                                    <li class="mastercard hand">MasterCard</li>
                                                    <li class="amex hand">Amex</li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>

                                        <hr style="background-color: blue; height: 1px; border: 0;" />
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-submit-fix"
                                                    v-on:click.prevent="validarInformacion()"
                                                    :disabled="bloquearBoton"
                                                >
                                                    Realizar pedido
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </template>

                                <template v-else-if ="modoPago == 'paypal'">
                                    <div class="alert alert-primary">
                                        <a href="/paypal/pay" class="btn btn-primary stretched-link">PayPal</a>
                                    </div>
                                </template>

                                <template v-else-if ="modoPago == 'canjePuntos'">
                                    <div class="alert alert-success">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-submit-fix"
                                                    v-on:click.prevent="validarInformacion()"
                                                    :disabled="bloquearBoton"
                                                >
                                                    Realizar pedido
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template v-if="modoPago == 'paypal'">
                                    <!--<a href="/payOrderPayPal" class="btn btn-primary stretched-link" >PayPal</a>-->
                                    
                                </template>
                                
                            </div>
                        </div>
                        <!--CREDIT CART PAYMENT END-->
                    </div>
                </div>
               
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                    <div class="widget">
                        <h4 class="widget-title">Resumen del pedido</h4>
                        <div class="summary-block">
                            <div class="summary-content" >
                                <div class="summary-head">
                                    <h5 class="summary-title">
                                        Base {{ items.impuesto }} %:
                                    </h5>
                                </div>
                                <div class="summary-price">
                                    <p class="summary-text">
                                        $ {{ items.subtotal }}
                                    </p>                                    
                                </div>
                            </div>                            
                        </div>

                        <div class="summary-block">
                            <div class="summary-content" >
                                <div class="summary-head">
                                    <h5 class="summary-title">
                                        Subtotal:
                                    </h5>
                                </div>
                                <div class="summary-price">
                                    <p class="summary-text">
                                        $ {{ items.subtotal }}
                                    </p>                                    
                                </div>
                            </div>                            
                        </div>

                        <div class="summary-block">
                            <div class="summary-content" >
                                <div class="summary-head">
                                    <h5 class="summary-title">
                                        Iva:
                                    </h5>
                                </div>
                                <div class="summary-price">
                                    <p class="summary-text">
                                        $ {{ items.iva }}
                                    </p>                                    
                                </div>
                            </div>                            
                        </div>

                        <div class="summary-block">
                            <div class="summary-content">
                               <div class="summary-head"> <h5 class="summary-title">TOTAL:</h5></div>
                                <div class="summary-price">
                                    <p class="summary-text">$ {{ items.valorTotal }}</p>
                                    <span class="summary-small-text pull-right"></span>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="alert alert-warning" v-if="items.fidelizacion">
                        <h1 class="summary-title">Puntos necesarios para canjear esta transacción:</h1><br>
                        <h4 class="summary-text pull-right">
                            PTS: <span class="badge badge-secondary"><h4 style="color:#fff;">{{items.totalTransaccionPuntos}}</h4></span>   
                        </h4><br>
                        <template v-if="cliente.puntos_acumulados >= items.totalTransaccionPuntos">
                            <span class="badge badge-success"><h4 style="color:#fff;">Si me alcanza</h4></span>
                        </template>
                        <template v-else>
                            <span class="badge badge-danger"><h4 style="color:#fff;">No me alcanza</h4></span>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [],
            cliente: [],
            empresa: [],
            cantidad: 0,

            modoPago: '',

            tarjeta: '',
            numeroTarjeta:'',
            cvv:'',
            fechaExp:'',

            aplicaPuntos: '',

            puntosTransaccion: 0,
            totalTransaccionPuntos: 0,
            bloquearBoton: false
        }
    },
    computed: {

    },
    methods: {
        async obtenerCarritoItems(){
            let response = await axios.get('/checkout/get/items');
            this.items = response.data.datos;
            this.cliente = response.data.cliente;

            this.puntosTransaccion = ((this.items.valorTotal * this.items.puntosAcumulacionPorCompra) / this.items.montoFactura); 

            this.totalTransaccionPuntos = parseFloat(this.puntosTransaccion).toFixed(2);
        },
        validarInformacion() {
            if (this.modoPago == 'tarjeta') {
                if (this.tarjeta == '') {
                    this.$toastr.e('El campo Tarjeta es obligatorio');                
                    return;
                } else if (this.numeroTarjeta == '') {
                    this.$toastr.e('El campo Número Tarjeta es obligatorio');                
                    return;
                } else if (this.cvv == '') {
                    this.$toastr.e('El campo CVV es obligatorio');                
                    return;
                } else if (this.fechaExp == '') {
                    this.$toastr.e('El campo Fecha Expriración es obligatorio');                
                    return;
                }

                this.aplicarPago();
            } else if (this.modoPago == 'canjePuntos') {
                this.aplicarPago();
            }
        },
        validarModoPago(e) {
            console.log(e.target.checked, this.modoPago);  
        },
        async aplicarPago() {
            let datos = {
                'idCliente': this.cliente.id,
                'formaPago': this.modoPago,

                'tarjeta': this.tarjeta,
                'numeroTarjeta': this.numeroTarjeta,
                'cvv': this.cvv,
                'fechaExpiracion': this.fechaExp,
                

                'impuesto': this.items.impuesto,
                'subtotal': this.items.subtotal,
                'iva': this.items.iva,
                'total': this.items.valorTotal,
                'totalTransaccionPuntos': this.totalTransaccionPuntos,

                'pedido': this.items,
            }

            let response = await axios.post('/process/user/payment', datos);
            
            if (response.data.success) {
                this.bloquearBoton = true;
                this.$toastr.s(response.data.success);
                setTimeout(()=> {
                window.location.href= '/';
                }, 2500);
            } else {
                this.bloquearBoton = false;
                this.$toastr.e(response.data.error);
            }
        },
        async eliminarProductos(idProducto) {
            let datos = {
                'idProducto': idProducto,
                'idCliente': this.cliente.id
            }

            await axios.post('/eliminarProducto', datos);

            window.location.href= '/checkout';
        },
        aumentarCantidad(e, idProducto) {
            e.preventDefault();
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

            if (!isNaN(currentVal)) {
                parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
            } else {
                parent.find('input[name=' + fieldName + ']').val(0);
            }

            this.cantidad = parent.find('input[name=' + fieldName + ']').val();

            this.actualizarCantidad('suma', this.cantidad, idProducto);
        },
        disminuirCantidad(e, idProducto) {
            e.preventDefault();
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

            if (!isNaN(currentVal) && currentVal > 0) {
                parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
            } else {
                parent.find('input[name=' + fieldName + ']').val(0);
            }

            this.cantidad = parent.find('input[name=' + fieldName + ']').val();
            
            this.actualizarCantidad('resta', this.cantidad, idProducto);
        },
        async actualizarCantidad(tipo, cantidad, idProducto) {
            let datos = {
                'tipo': tipo,
                'cantidad': cantidad,
                'idProducto': idProducto,
                'idCliente': this.cliente.id
            }

            await axios.post('/aumentarODisminuir', datos);

            window.location.href= '/checkout';
        }

    },
    mounted() {
        //this.obtenerCarritoItems();
    },
    created(){
        this.obtenerCarritoItems();
    }
};
</script>
