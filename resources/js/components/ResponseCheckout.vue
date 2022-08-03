<template>
    <div>
        <div class="container responseCheckoutBox">
            <div class="row" style='padding-top:25px; padding-bottom:25px;'>
                <div class='col-md-12'>
                    <div id='mainContentWrapper'>
                        <div class="col-md-8 col-md-offset-2">
                            <h2 style="text-align: center;">
                                Review Your Order & Complete Checkout
                            </h2>
                            <hr/>
                            <a href="#" class="btn btn-info" style="width: 100%;">Add More Products & Services</a>
                            <hr/>
                            <div class="shopping_cart">
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
