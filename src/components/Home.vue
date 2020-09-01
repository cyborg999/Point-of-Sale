<template>
<div class="home">
    <Navigation page="home"/>
    <div class="jumbotron">
        <h1>Homepage</h1>
    </div>
</div>
</template>
<script>
import Navigation from "./Navigation.vue";
export default {
    name : "Home"
    , components : {
        Navigation
    }
}
</script>