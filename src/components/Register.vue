<template>
    <div class="register">
        <Navigation page="register"/>
        <h2>{{ title }}</h2>
        <form>
            <label>
                Username
                <input type="text"  class="form-control" name="username" v-model="username" placeholder="Username..."/>
            </label>
            <label>
                Password
                <input type="password"  class="form-control"  name="password1" v-model="password" placeholder="Password..."/>
            </label>
            <label>
                Retype Password
                <input type="password"  class="form-control"  name="password2" v-model="password2" placeholder="Password..."/>
            </label>
            <br/>
            <input type="submit" v-on:click.prevent="handleSubmit" class="btn btn-primary" value="Sign Up"/>
            <blockquote>
                <p>{{ success }}</p>
                <p>{{ error }}</p>
            </blockquote>
        </form>
    </div>
</template>

<script>
import Navigation from "./Navigation.vue";

const axios = require("axios")
const url = "http://localhost/inventory/api/model.php"

export default {
    name : "Register"
    , data : function(){
        return {
            title : "Sign Up"
            , username : ""
            , password : ""
            , password2 : ""
            , error : ''
            , success : ''
            , usernames : []
        }
    }
    , components : {
        Navigation
    }
    , mounted : function(){
        this.getUsernames()
    }
    , methods : {
        handleSubmit : function(){
            let usernames = this.usernames
            let errCount = 0

            this.error = ""
            this.success = ""

            for(var i in usernames){
                let username = usernames[i].username

                if(username == this.username){
                    this.error = "Username already exists."
                    ++errCount
                    break
                } 
            }

            if(errCount == 0){
                if(this.password != this.password2){
                    this.error = "Paswords should be the same."
                    ++errCount
                }

                if(this.password.length <7 ){
                    this.error = "Password is too short."
                    ++errCount
                }

                if(this.username.length <7 ){
                    this.error = "Username is too short."
                    ++errCount
                }

            }   

            if(errCount == 0){
                this.error = ""
                this.register()
            }
        },
        getUsernames : function(){
            console.log("fetching usernames..")
            axios({
                url : url,
                params : {
                    getUsernames : true
                },
                method : 'GET'
            })
            .then( response => {
                this.usernames = response.data
            }).finally( ()=> {
                console.log("final",this.usernames)
            })
        },
        register : function(){
            var params = new URLSearchParams()

            params.append("username", this.username)
            params.append("password", this.password)
            params.append("registerUser", true)

            axios({
                url : url
                , data : params
                , method : "post"
            }).then(response => {
                console.log(response)
                this.success = "You can now login using user : " + this.username
                this.username = ""
                this.password = ""
                this.password2 = ""
                this.getUsernames()
            })
        }
    }
}
</script>
<style scoped>
    label {
        /* display: block; */
    }
</style>