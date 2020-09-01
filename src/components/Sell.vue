<template>
    <div class="sell row">

        {{ active }}
        <div class="col-sm">
            <ProductTable 
                v-bind:sell = "true"
                v-bind:records="records" 
                v-on:addItem="addItem"
                v-on:setFiltered="setFiltered" 
                v-bind:filtered="filtered"  />
        </div>
        <div class="col-sm">
            <table class="table table-sm table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>SRP</th>
                    <th>Action</th>
                </tr>
                <tr 
                    v-for="(item, idx) in cartItem"
                    v-bind:cartItem = "cartItem"
                    v-bind:key="idx"
                    >
                    <th scope="row">
                        <img class="photo" v-bind:src="item.photo" />
                        </th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.qty }}</td>
                    <td>{{ item.srp }}</td>
                    <td><input type="submit" class="btn btn-sm btn-info" v-on:click.prevent="removeItem(idx)" value="remove"/></td>
                </tr>
                <tr>
                    <th colspan="4" class="total">
                        <p class="total">Total: <b>{{ total }}</b></p>
                    </th>
                    <th > 
                        <button class="btn btn-lg btn-primary" v-on:click.prevent="buyItem">Buy</button>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
import ProductTable from "./ProductTable.vue"

const axios = require("axios")
export default {
    name : "Sell"
    , data : function(){
        return {
            records : []
            , filtered : []
            , cartItem : []
            , total : 0
        }
    }
    , components : {
        ProductTable
    }
    , mounted :  function(){
        this.getProducts()
    }
    , computed : {
        active : function(){
            return this.$route.params.active
        }
    }
    , methods : {
        setFiltered : function(data){
            this.filtered = data
        }
        , buyItem : function(){
            let userId = localStorage.getItem("id")
            let params = new URLSearchParams()

            params.append("userid", userId)
            params.append("total", this.total)
            params.append("items", JSON.stringify(this.cartItem))
            params.append("buyItems", true)

            axios({
                url : window.url
                , data : params
                , method : "post"
            }).then(response => {
                if(response.data){
                    this.total = 0
                    this.cartItem = []
                }
            })
        }
        , addItem : function(data){
            let addedItems = this.cartItem
            let found = false
            let total = 0

            for(var i in addedItems){
                total += (addedItems[i].srp * addedItems[i].qty)

                if(addedItems[i].id == data.id){
                    found = true
                    // break 
                }
            }

            if(!found){
                this.cartItem.push(data);
                total += (data.qty*data.srp)
            }

            this.total = total
        }
        , removeItem : function(idx){
            this.cartItem.splice(idx,1)
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
    }
 
   
}
</script>
<style scoped>
    .productTable {
        position:sticky;
        top:30px;
    }
    .photo {
        height: 30px;
        width: auto;
    }
    .total {
        text-align:left;
        padding: 10px 10px 0;
    }
    .total b {
        font-size: 20px;
        font-weight: 500;;
    }
</style>