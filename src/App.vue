<template>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <router-view  name="nav"></router-view>
        </div>
      </div>
      <div class="row">
          <div class="col-sm-3">
            <router-view name="left"></router-view>
          </div>
          <div class="col-sm-9">
              <router-view ></router-view>
              <router-view name="content"></router-view>
          </div>
      </div>
    </div>

  </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css';

export default {
  name: 'App'
  , data : function(){
    return {
      title : "Home"
    }
  }
  , mounted : function(){
 
  }

}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
