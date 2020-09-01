<template>
    <div class="productTable">
        <BarcodeModal v-bind:data="barcodeData"/>
        <table class="table table-sm">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th v-if="sell == false">Base Price</th>
                <th>SRP</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <tr>
                <td colspan="6">
                    <ProductSearch v-bind:records="records" v-on:setFiltered="setFiltered"/>
                </td>
            </tr>
            <tr
                v-for="(record, idx) in filtered"
                v-bind:records="filtered"
                v-bind:key="idx"
            >
                <td>
                    <div class="orig">
                        <img class="photo s1" v-if="record.photo == null" v-bind:src="defaultImage"/>
                        <!-- <img class="photo s2" v-else src="./../assets/logo.png"/>  -->
                        <img class="photo s2" v-else v-bind:src="require('./../../api/uploads/' + record.photo)"  />
                    </div>
                    <div class="hidden edit">
                        <img class="preview" src=""/>
                        <input type="file" v-on:change="handleFileChange"/>
                    </div>
                </td>
                <td>
                    <div class="orig">
                        {{ record.name }}
                    </div>
                    <div class="hidden edit">
                        <input type="text" class="form-control" v-model="selectedName" />
                    </div>
                </td>
                <td v-if="sell == false">
                    <div class="orig">
                        <div v-if="sell==false">
                            {{ record.base_price }}
                        </div>
                        <div v-else>
                            <input type="number" class="form-control base " value="1"/>
                        </div>
                    </div>
                    <div class="hidden edit">
                        <input type="number" class="form-control" v-model="selectedBase" />
                    </div>
                </td>
                <td>
                    <div class="orig">
                        <div v-if="sell==false">
                            {{ record.srp }}
                        </div>
                        <div v-else>
                            <input type="text" disabled class="form-control srp short" v-bind:value="'P ' + record.srp"/>
                        </div>
                    </div>
                    <div class="hidden edit">
                        <input type="number" class="form-control" v-model="selectedSrp" />
                    </div>
                </td>
                <td>
                    <div class="orig">
                        <div v-if="sell==false">
                            {{ record.qty }}
                        </div>
                        <div v-else>
                            <input type="number" class="form-control sellQty short" value="1"/>
                        </div>
                    </div>
                    <div class="hidden edit">
                        <input type="number" class="form-control" v-model="selectedQty" />
                    </div>
                </td>
                <td v-if="sell==false">
                    <div class="orig">
                        <a href="" class="btn btn-sm btn-link" v-on:click.prevent="editRow(record)" >Edit</a>
                        <a href="" v-on:click.prevent="deleteRow(record.id, idx)" class="btn btn-sm  btn-link">Delete</a>
                        <a href="" v-on:click.prevent="showBarcodeModal(record)" class="btn btn-sm btn-success">Barcode</a>
                    </div>
                    <div class="hidden edit">
                        <a href="" class="btn btn-sm btn-link" v-on:click.prevent="editSave(idx)" >Save</a>
                        <a href="" class="btn btn-sm btn-link" v-on:click.prevent="editCancel" >Cancel</a>
                    </div>
                </td>
                <td v-else>
                    <button class="btn btn-primary" v-on:click="addItem(record)">+</button>
                </td>
            </tr>
           
        </table>
    </div>
</template>
<script>
import ProductSearch from "./ProductSearch.vue"
import BarcodeModal from "./BarcodeModal.vue"

const axios = require("axios")

export default {
    name : "ProductTable"
    , props : ["records", "filtered", "sell"]
    , data : function(){
        return {
            selectedId : null
            , selectedName  : null
            , selectedQty : null
            , selectedBase : null
            , selectedSrp : null
            , selectedPic : null
            , defaultImage : window.upload + "default.png"
            , barcodeData : null
        }
    }
    , components : {
        ProductSearch
        , BarcodeModal
    }
    , methods : {
        setFiltered : function(data){
            this.$emit("setFiltered", data)
        }
        , showBarcodeModal : function(data){
            this.barcodeData = data

            let modal = document.querySelectorAll(".barcode-modal")
    
            this.removeClass(modal,"hidden")
        }
        , addItem : function(data){
            let  parentTr = event.target.parentElement.parentElement
            let sellQty = parentTr.querySelectorAll(".sellQty")

            data.qty = sellQty[0].value
            this.$emit("addItem", data)
        }
        , removeClass(ele, classname) {
            for(var o in ele){
                let classes = ele[o].classList
                
                if(classes != undefined){
                    classes.remove(classname)
                }
            }
        }
        , toggleClass(ele, classname) {
            let classes = ele[0].classList
            
            if(classes != undefined){
                classes.remove(classname)
            } else {
                classes.add(classname)
            }
        }
        , handleFileChange : function(event){
            let ele = event.target.files[0]
            let  parentTr = event.target.parentElement.parentElement.parentElement
            let photo = parentTr.querySelectorAll(".preview")
            let formData = new FormData();

            formData.append('file', ele);

            axios({
                url : window.url
                , data : formData
                , method : 'post'
            }).then(response => {
                console.log(response)
                if(response.data.filename != false){
                    photo[0].src = window.upload + response.data.filename

                    this.selectedPic = window.upload + response.data.filename
                }
            })
        }
        
        , addClass : function(ele, classname){
            for(var o in ele){
                let classes = ele[o].classList
                
                if(classes != undefined){
                    classes.add(classname)
                }
            }
        }
        , editSave : function(idx){
            let  parentTr = event.target.parentElement.parentElement.parentElement
            let params = new URLSearchParams()

            params.append("id", this.selectedId)
            params.append("name", this.selectedName)
            params.append("qty", this.selectedQty)
            params.append("photo", this.selectedPic)
            params.append("base", this.selectedBase)
            params.append("srp", this.selectedSrp)
            params.append("updateProduct", true)

            axios({
                url : window.url
                , data : params
                , method : 'post'
            }).then(() => {
                this.records[idx].name = this.selectedName
                this.records[idx].qty = this.selectedQty
                this.records[idx].base_price = this.selectedBase
                this.records[idx].srp = this.selectedSrp
                
            }).finally(() => {
                let orig = parentTr.querySelectorAll(".orig")
                let edit = parentTr.querySelectorAll(".edit")
                let photo = parentTr.querySelectorAll(".photo")
                let preview = parentTr.querySelectorAll(".preview")
                
                preview[0].src = ""
                photo[0].src = this.selectedPic

                this.removeClass(orig, "hidden")
                this.removeClass(edit, "displayed")
            })

        
        }
        , editCancel : function(event = false){
            let  parentTr = event.target.parentElement.parentElement.parentElement
            let orig = parentTr.querySelectorAll(".orig")
            let edit = parentTr.querySelectorAll(".edit")

            this.removeClass(orig, "hidden")
            this.removeClass(edit, "displayed")
        }
        , editRow :function(data){
            let  parentTr = event.target.parentElement.parentElement.parentElement

            this.selectedId = data.id
            this.selectedName = data.name
            this.selectedQty = data.qty

            //hide all previously shown edit
            let others = document.querySelectorAll(".hidden")
            let allOtherOrig = document.querySelectorAll(".orig")

            this.removeClass(others, "displayed")
            this.removeClass(allOtherOrig, "hidden")

            //hide originally displayed data
            let orig = parentTr.querySelectorAll(".orig")

            this.addClass(orig, "hidden")

            let hidden = parentTr.querySelectorAll(".edit")

            this.addClass(hidden, "displayed")
            
        }
        , deleteRow(id, idx){
            console.log(id, idx)

            axios({
                url : window.url
                , params : {
                    deleteProduct : true,
                    id : id
                }
                , method : "get"
            }).then(response => {
                if(response.data){
                    this.records.splice(idx,1)
                }
            })

        }
    }   
   
}
</script>
<style scoped>
    img.photo,
    img.preview {
        height : 50px;
        width : auto;
    }
    .hidden {
        display : none;
    }
    .displayed {
        display :block;
    }
    .short {
        width: 70px;
        text-align: center;
    }
</style>