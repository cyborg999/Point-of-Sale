<template>
    <div class="navigation">
         <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="#">Top navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"  v-bind:class="{ active : homeActive}">
        <router-link class="nav-link" to="/">Home</router-link> / 
      </li>
      <li class="nav-item" v-bind:class="{ active : registerActive}">
        <router-link class="nav-link"  to="/register">Register</router-link> / 
      </li>
      <li class="nav-item" v-bind:class="{ active : loginActive}" >
        <router-link class="nav-link" to="/login">Login</router-link>
      </li>
    </ul>
  </div>
</nav>

    </div>
</template>
<script>
export default {
    name : "Navigation"
    , props : ["page"]
    ,data : function(){
        return {
            loginActive : (this.page =="login") ? "active"  :""          
            , homeActive : (this.page =="home") ? "active"  :""          
            , registerActive : (this.page =="register") ? "active"  :""          
        }
       
    }
}
</script>
<style scoped>
    .active {
        font-weight: 900;
    }
</style>