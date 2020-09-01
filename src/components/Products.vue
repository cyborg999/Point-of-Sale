<template>
<div class="products">
    <h1 class="display-4">Add New Product</h1>
    <form v-on:submit.prevent="handleSubmit">
        <label>Product name
            <input type="text" v-model="name" class="form-control" required placeholder="Name"/>
        </label> 
        <label>Quantity
            <input type="number" v-model="qty" min="1" class="form-control" placeholder="Qty"/>
        </label> 
        <label>Base Price
            <input type="number" v-model="base" min="1" class="form-control" placeholder="Base Price"/>
        </label> 
        <label>Sales Retail Price
            <input type="number" v-model="srp" min="1" class="form-control" placeholder="SRP"/>
        </label> 
        <p class="lead">
            <input type="submit" class="btn btn-primary btn-lg" value="Add"/>
        </p>
        <div class="alert alert-primary" role="alert" v-if="success !== ''">
            <p>{{ success }}</p>
        </div>
        <div class="alert alert-danger" v-if="errors !== ''">
            <ul
                v-for="(error, idx) in errors"
                v-bind:errors = "errors"
                v-bind:key="idx"
            >
                <li>{{ error}}</li>
            </ul>
        </div>
    </form>
    
    <br/>
    <ProductTable 
        v-bind:sell="false" 
        v-bind:records="records" 
        v-on:setFiltered="setFiltered" 
        v-bind:filtered="filtered"  />
</div>
</template>
<script>
import ProductTable from "./ProductTable.vue"

const axios = require("axios")

export default {
    name  : "Products"
    , data : function(){
        return {
            name : ''
            , qty : 1
            , base : 1
            , srp : 1
            , errors : ''
            , success : ''
            , records : []
            , filtered : []
            , count : 0
        }
    }
    , components : {
        ProductTable
    }
    , mounted :  function(){
        this.getProducts()
    }
    , methods : {
        setFiltered : function(data){
            this.filtered = data
        }
        , getProducts : function(){
            axios({
                url : window.url
                , params : {
                    getProducts : true
                }
                , method : 'get'
            }).then(response => {
                this.records = response.data
                this.filtered = response.data
            })
        }
        , handleSubmit : function(){
            let params = new URLSearchParams()

            params.append("name", this.name)
            params.append("qty", this.qty)
            params.append("base", this.base)
            params.append("srp", this.srp)
            params.append("addProduct", true)
            
            axios({
                url : window.url
                , data : params
                , method : "POST"
            }).then(response => {
                console.log(response)
                if(response.data.added == false){
                    this.errors = response.data.errors
                    this.success = ""
                } else {
                    this.errors = []
                    this.success = "Item is succesfully added"

                    this.getProducts()
                }
            })
        }
    }
}
</script>
<style scoped>
    label {
        display : block;
        text-align: left;
    }
</style>