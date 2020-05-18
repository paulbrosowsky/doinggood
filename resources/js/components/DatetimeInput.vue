<template>
    <div class="relative">
        <datetime 
            v-model="date"
            input-class="bg-gray-300 rounded-lg leading-none py-3 pl-10" 
            @input="$emit('update', date)"
        ></datetime>
        <svg class="absolute top-0 h-6 fill-current text-gray-500 m-3 leading-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z"/></svg>
    </div>
    
</template>
<script>    
    export default {
        props:{
            selected:{
                default: DateTime.local().toString() 
            }
        },

        data(){
            return{
                date: this.selected
            }
        },

        mounted(){           
            
        }
    }
</script>

<style lang="scss" >


</style>
