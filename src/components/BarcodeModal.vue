<template>
    <div class="barcode-modal hidden ">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <button class=" close" v-on:click="closeModal">x</button>
                </div>
            </div>
            <div class="row" v-if="data!=null">
                <div class="col-sm">
                    <label>Product Name: {{ data.name}}</label>
                    <label>Quantity: 
                        <input type="number" v-bind:max="data.qty" v-bind:min="1" v-bind:value="data.qty" />
                    </label>
                    <label>SRP: P {{ data.srp }}{{data.qty}}
                    </label>
                    <input type="submit" v-on:click.prevent="generateBarcode(data)" class="btn btn-lg btn-primary" value="Generate Barcode"/>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm" id="content">
                 <iframe id="iframeb" frameborder="0" v-bind:src="iframeb"></iframe>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
const axios = require("axios")

export default {
    name : "BarcodeModal",
    props : [ "data"]
    , data : function(){
        return {
            iframeb : ''
        }
    }
    , mounted : function(){
        this.iframeb = window.iframeb
    }
    , methods : {
        closeModal : function(){
            let modal = document.querySelectorAll(".barcode-modal")

            modal[0].classList.add("hidden")
        }
        , generateBarcode : function(data){
            console.log(data)

            var params = new URLSearchParams()

            params.append("id", data.id)
            params.append("qty", data.qty)
            params.append("name", data.name)
            params.append("srp", data.srp)
            params.append("generateBarcode", true)

            axios({
                url : window.barcodeAPI
                , data : params
                , method : "post"
            }).then(response => {
                document.getElementById("iframeb").src =  "data:text/html;charset=utf-8," + escape(response.data);

            });
        }
    }
}
</script>
<style scoped>
    .barcode-modal {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.9);
        left : 0;
        top : 0;
        z-index: 9;
    }
    .close {
        margin: 10px 0;
        float : right;
    }
    .hidden {
        display: none;
    }
    label {
        display :block;
        margin-bottom: 5px;
    }
    input[type="number"] {
        color:black;
    }
    .container {
        background: white;
        padding: 20px;
    }
    #iframeb {
        width: 100%;
        min-height: 700px;
    }
</style>