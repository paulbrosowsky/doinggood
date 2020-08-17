<template>
    <div class="mb-10">
        <div class="relative bg-gray-500 rounded-xl overflow-hidden pb-2/3">

            <a :href="`/needs/${need.id}`">
                <img class="absolute w-full h-full object-cover" :src="need.title_image" alt="">
                        
             
                <div v-if="need.state.id != 1">
                    <div class="absolute w-full h-full bg-white opacity-75"></div>                  
                    <span                                           
                        class="absolute right-0 border-2 rounded-full text-sm font-bold px-3 py-1 m-5"                    
                        v-text="need.state.name"
                        :style="{borderColor:need.state.color, color:need.state.color}"
                    ></span>             
                </div>
            </a>
          
        </div> 
        <div class="mx-3 my-3">
            <p class="text-xs text-gray-500 leading-none">wir brauchen </p>
            <categories :categories="need.categories"></categories>

            <h4 class="leading-tight font-semibold my-2 text-lg" v-text="need.title"></h4>          
            
        </div>

        <tags></tags>            
        
    </div>
</template>

<script>
    export default {
        props:['need'],         
    }
</script>
