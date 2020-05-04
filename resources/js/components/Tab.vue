<template>
    <div class="w-full" role="tabpanel" v-if="show">
        <slot></slot>
    </div>
</template>
<script>
    export default {
        props:{
            name:'',
            hash:{default:null} ,
            count:{default:null}                    
        },  
        
        data(){
            return{
                show: false
            }
        },

        computed:{
            isActive(){               
                return this.hash == window.location.hash.substring(1)
            }            
        },        
    }
</script>
