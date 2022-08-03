<template>
    <div>
        <template v-if="itemCantidad > 0">
            <li class="nav-item">
                <a href="/checkout" 
                    class="btn btn-warning btn-sm">
                        Carrito {{ itemCantidad }}
                </a>
            </li>
        </template>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                itemCantidad: '',
            }
        },
        mounted() {
            this.$root.$on('actualizaCarrito', (item) => {
                this.itemCantidad = item;
            })
        },
        methods:{
            async getCantidadItemsAlCargarPagina() {
                let response = await axios.post('/carrito');
                this.itemCantidad =response.data.items
            }
        },
        created(){
            this.getCantidadItemsAlCargarPagina();
        }
    }
</script>
