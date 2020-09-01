<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="" v-on:click.prevent="logout">Logout</a>
            </li>
        </ol>
    </nav>
</template>
<script>
// const axios = require("axios")
// const url = "http://localhost/inventory/api/model.php"

export default {
    name : "DashboardNavigation"
    , props : ["page"]
    ,data : function(){
        return {
            loginActive : (this.page =="dashbard") ? "active"  :""          
            , homeActive : (this.page =="dashboard") ? "active"  :""          
        }
       
    }
    , methods : {
        checkIfLoggedIn : function(){
            let id = localStorage.getItem("id")

            if(id == null){
                this.logout()
            }
        }
        , logout : function(){
            localStorage.removeItem("id");

            this.$router.push("/")
        }
    }
    , beforeMount : function(){
        this.checkIfLoggedIn()
    }
    
}
</script>
<style scoped>
    .active {
        font-weight: 900;
    }
</style>