<template>
    <div class="mb-10">
        <div class="relative bg-gray-500 rounded-xl overflow-hidden pb-2/3">
           
                <img class="absolute w-full h-full object-cover" src="https://source.unsplash.com/600x820/?nature" alt="">
             
                <div v-if="need.status != 'opened'">
                    <div class="absolute w-full h-full bg-white opacity-75"></div>                  
                    <span  
                        :class="status.classes"                   
                        class="absolute right-0 border-2 rounded-full text-sm font-bold px-3 py-1 m-5"                    
                        v-text="status.name"
                    ></span>             
                </div>
          
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

        computed:{
            status(){
                return this.need.status == 'completed' 
                    ? {name: 'abgeschlossen', classes: 'text-dg-yellow border-dg-yellow' } 
                    : {name: 'vergeben', classes: 'text-dg-blue border-dg-blue' } ;
            }
        }
        
    }
</script>
