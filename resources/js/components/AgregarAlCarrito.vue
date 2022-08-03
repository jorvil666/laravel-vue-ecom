<template>
    <div>
        <hr>
        <button class="btn btn-warning text-center"
            v-on:click.prevent="agregarProductoAlCarrito()"
        >
            Agregar al carrito
        </button>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                
            }
        },
        props: [
            'productoId',
            'userId'
        ],
        methods: {
            async agregarProductoAlCarrito() {
                //Validamos si el usaurio esta logueado
                if (this.userId == 0) {
                    this.$toastr.e('Es necesario iniciar sesión para agregar productos al carrito de compras!!');

                    return;
                }

                let response = await axios.post('/carrito', {
                    'producto_id': this.productoId
                });

                if (response.data.code == 999) {
                    this.$toastr.e(response.data.message);   
                }

                this.$root.$emit('actualizaCarrito', response.data.items)
            }    
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
