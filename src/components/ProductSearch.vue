<template>
    <div class="search">
        <input type="text" class="form-control" v-model="search" placeholder="Search..."/>
    </div>
</template>
<script>
export default {
    name : "ProductSearch"
    , props : ["records"]
    , data : function(){
        return {
            filtered : []
            , search : ''
        }
    }
    , mounted : function(){

    }
    , watch : {
        search : function(){
            console.log(this.search)
            let data = this.records
            let keyword = this.search
            let filtered = []

            if(keyword !== ""){
                Object.keys(data).map(function(key) {
                    let product = data[key].name
                    let found = product.toLowerCase().indexOf(keyword.toLowerCase())
                    
                    if(found > -1){
                        filtered.push(data[key])
                    }
                });

                this.$emit("setFiltered", filtered)
            } else {
                this.$emit("setFiltered", this.records)
            }
        }
    }
}
</script>