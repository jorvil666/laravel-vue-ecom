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
                                    <th scope="col">Puntos</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items" :key="item.id">
                                    <template v-if="item.nombre">
                                        <th scope="row"></th>
                                        <td>{{ item.Puntos }}</td>
                                        <td>{{ item.nombre }}</td>
                                        <td>{{ item.cantidad }}</td>
                                        <td>$ {{ item.precio }}</td>
                                    </template>
                                </tr>                                
                            </tbody>
                        </table>
                        <br>
                        <hr>

                        <!--SHIPPING METHOD-->
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h4>Aplicar Puntos?</h4>
                                    <br>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioPuntos" id="radioPuntos" value="si" v-model="aplicaPuntos">
                                    <label class="form-check-label" for="radioPuntos">
                                        Si
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioPuntos" id="radioPuntos" value="no" v-model="aplicaPuntos">
                                    <label class="form-check-label" for="radioPuntos">
                                        No                                        
                                    </label>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <h4>Dirección de Envío</h4>
                                    <br>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Nombres:</label>
                                        <input type="text" class="form-control" id="inputNombres" name="nombres" v-model="nombres">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="inputPassword4">Apellidos:</label>
                                    <input type="text" class="form-control" id="inputApellidos" name="apellidos" v-model="apellidos">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Dirección:</label>
                                    <input type="text" class="form-control" id="inputDireccion" name="direccion" v-model="direccion">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Referencia:</label>
                                    <input type="text" class="form-control" id="inputReferencia" name="referencia" v-model="referencia">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Teléfono:</label>
                                        <input type="text" class="form-control" id="inputTelefono" name="telefono" v-model="telefono">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="inputPassword4">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="inputEmail" name="email" v-model="email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">Ciudad:</label>
                                        <input type="text" class="form-control" id="inputCiudad" name="ciudad" v-model="ciudad">
                                    </div>                                   
                                    <div class="form-group col-md-6">
                                        <label for="inputZip">Zip / Código Postal:</label>
                                        <input type="text" class="form-control" id="inputZip" name="zipCode" v-model="zipCode">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--SHIPPING METHOD END-->
                        <hr />
                        <!--CREDIT CART PAYMENT-->
                        <div class="panel panel-info">                            
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h4>Método de Pago</h4>
                                    <br>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioTarjeta" id="radioTarjeta" value="tarjeta" v-model="modoPago" @change="validarModoPago($event)" >
                                    <label class="form-check-label" for="exampleRadios1">
                                        Tarjeta
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioPaypal" id="radioPaypal" value="paypal" v-model="modoPago" @change="validarModoPago($event)">
                                    <label class="form-check-label" for="exampleRadios2">
                                        PayPal                                        
                                    </label>
                                </div>

                                <br>                                

                                <template v-if="modoPago == 'tarjeta'">
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
                                            <input type="text" class="form-control" id="inputApellidos" name="numeroTarjeta" v-model="numeroTarjeta">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">CVV:</label>
                                            <input type="text" class="form-control" id="inputApellidos" name="cvv" v-model="cvv">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Mes Expiración:</label>
                                            <select
                                                class="form-control"
                                                name="mesExpiracion"
                                                v-model="mesExpiracion"
                                            >
                                                <option value="">Seleccione Mes...</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Año Expiración:</label>                                        
                                            <select
                                                class="form-control"
                                                name="anioExpiracion"
                                                v-model="anioExpiracion"
                                            >
                                                <option value="">Selecciones Año...</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
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
                                </template>
                                <template v-if="modoPago == 'paypal'">
                                    <!--<a href="/payOrderPayPal" class="btn btn-primary stretched-link" >PayPal</a>-->
                                    <form v-on:submit.prevent="validarInformacion">
                                        <div>
                                            <button class="btn btn-primary">Aplicar PayPal</button>
                                        </div>
                                    </form>
                                </template>
                                
                                <hr />
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-submit-fix"
                                             v-on:click.prevent="validarInformacion()"
                                        >
                                            Realizar pedido
                                        </button>
                                    </div>
                                </div>
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
            Usuario: [],
            nombres:'',
            apellidos:'',
            direccion:'',
            referencia: '',
            telefono:'',
            email:'',         
            zipCode:'',
            ciudad:'',
            tarjeta: '',
            mesExpiracion:'',
            anioExpiracion:'',
            cvv:'',
            numeroTarjeta:'',
            modoPago: '',
            aplicaPuntos: ''
        }
    },
    computed: {

    },
    methods: {
        async obtenerCarritoItems(){
            let response = await axios.get('/checkout/get/items');
            this.items = response.data.datos;
            this.Usuario= response.data.usuario;
            console.log(this.items);
        },
        validarInformacion() {
            if (this.nombres == '') {
                this.$toastr.e('El campo Nombre es obligatorio');                
                return;
            } /*else if (this.apellidos == '') {
                this.$toastr.e('El campo Apellido es obligatorio');
                return;
            } else if (this.direccion == '') {
                this.$toastr.e('El campo Dirección es obligatorio');
                return;
            } else if (this.telefono == '') {
                this.$toastr.e('El campo Teléfono es obligatorio');
                return;
            }  else if (this.email == '') {
                this.$toastr.e('El campo Email es obligatorio');
                return;
            } else if (this.modoPago == '') {
                this.$toastr.e('Debe seleccionar un método de pago');
                return;  
            }
            */

            this.aplicarPago();
        },
        validarModoPago(e) {
            console.log(e.target.checked, this.modoPago);  
        },
        async aplicarPago() {
            let data = {
                'nombres': this.nombres,
                'apellidos': this.apellidos,
                'direccion': this.direccion,
                'referencia': this.referencia,
                'telefono': this.telefono,
                'email': this.email,
                'zipCode': this.zipCode,
                'ciudad': this.ciudad,

                'tarjeta': this.tarjeta,
                'mesExpiracion': this.mesExpiracion,
                'anioExpiracion': this.anioExpiracion,
                'cvv': this.cvv,
                'numeroTarjeta': this.numeroTarjeta,

                'impuesto': this.items.impuesto,
                'subtotal': this.items.subtotal,
                'iva': this.items.iva,
                'total': this.items.valorTotal,

                'pedido': this.items,
                'radioPuntos': this.aplicaPuntos
            }
            
            if (!this.modoPago == 'paypal') {
                let response = await axios.post('/process/user/payment', data);
            
                if (response.data.success) {
                    this.$toastr.s(response.data.success);
                    setTimeout(()=> {
                    window.location.href= '/';
                    }, 2500);
                } else {
                    this.$toastr.e(response.data.error);
                }   
            } else {
                this.paypal(data);
            }
        },
        paypal(data) {

            axios.post('/payOrderPayPal', data)
            .then((res) => {
                console.log('res: ', res);
            })
            .catch((error) => {
                console.log('error: ', error);
            }).finally(() => {
                //Perform action in always
            });
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    created(){
        this.obtenerCarritoItems();
    }
};
</script>
