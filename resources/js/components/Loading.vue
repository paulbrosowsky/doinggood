<template>
    <div class="w-full h-full flex justify-center items-center top-0 left-0 z-40" 
        :class="this.position" 
        v-if="loading"
    >
        <clip-loader 
            class="z-50" 
            :loading="loading" 
            :color="'#f7a81b'" 
            :size="size"
            style=""
        ></clip-loader> 

        <div  class="absolute w-full h-full bg-white opacity-75 rounded-xl"></div>
        
    </div>
   
</template>
<script>
    import ClipLoader from './ClipLoader';
    
    export default {        
        components: {
            ClipLoader
        },

        props:{
            // loading: { default:false},            
            size: { default:'48px' }, 
            position: { default: 'fixed' },  
        },

        data(){
            return{
                loading: false
            }
        },

        created(){
            window.Event.$on('loading', () => this.loading = !this.loading);
        }
    }
</script>