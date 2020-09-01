<template>
<div class="login">
    <Navigation page="login"/>
    <form v-on:submit.prevent="handleSubmit">
        <div class="text-center mb-4">
            <img class="mb-4" src="/docs/4.5/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
        </div>
        <div class="form-label-group">
            <input type="text" v-model="username" class="form-control" placeholder="Username" required autofocus>
            <label for="inputEmail">Username</label>
        </div>

        <div class="form-label-group">
            <input type="password"  v-model="password" class="form-control" placeholder="Password" required>
            <label for="inputPassword">Password</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted text-center">{{ status }}</p>
    </form>

  
</div>
</template>
<script>
import Navigation from "./Navigation.vue";

const axios = require("axios")
const url = "http://localhost/inventory/api/model.php"

export default {
    name : "Login"
    , components : {
        Navigation
    }
    , data : function(){
        return {
            username : ''
            , password : ''
            , status : ''
        }
    }
    , methods : {
        handleSubmit : function(){
            //  this.$router.push({ name: 'dashboard', query: { redirect: '/dashboard' } })
            //  this.$router.push("dashboard")
            // this.$router.push({ path: `/dashboard/${userId}` })
            let params = new URLSearchParams();

            params.append("username", this.username)
            params.append("password", this.password)
            params.append("login", true)

            axios({
                url : url
                , data : params
                , method : 'post'
            }).then(response => {
                if(response.data.found){
                    localStorage.setItem("id", response.data.id)
                    localStorage.setItem("username", response.data.username)

                    this.$router.push("dashboard/3")
                } else {
                    this.status = "Invalid login info."
                }
            })
        }
    }
}
</script>
<style scoped>
    .login  form {
        max-width:400px;
        margin: 0 auto;
    }
</style>