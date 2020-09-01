<template>

<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center" v-bind:class="{ active : (active==1)}">
        <router-link to="/sell/1">Sell Item</router-link>
        <span class="badge badge-primary badge-pill">14</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center"  v-bind:class="{ active : (active==2)}">
        <router-link to="/products/2">Products</router-link>
        <span class="badge badge-primary badge-pill">2</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center"  v-bind:class="{ active : (active==3)}">
        <router-link to="/dashboard/3">Add New Product</router-link>
        <span class="badge badge-primary badge-pill">2</span>
    </li>
</ul>
</template>
<script>
export default {
    name : "Sidebar"
    , computed : {
        active : function(){
            return this.$route.params.active
        }
    }
}
</script>
<style sscoped>
    .active a {
        color : white;
    }
</style>