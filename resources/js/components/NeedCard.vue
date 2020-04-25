<template>
    <div class="mb-10">
        <div class="relative bg-gray-500 rounded-xl overflow-hidden pb-2/3">
            <a href="#">
                <img class="absolute w-full h-full object-cover" src="https://source.unsplash.com/600x820/?nature" alt="">
             
                <div v-if="need.status != 'opened'">
                    <div class="absolute w-full h-full bg-white opacity-75"></div>                  
                    <span  
                        :class="status.classes"                   
                        class="absolute right-0 border-2 rounded-full text-sm font-bold px-3 py-1 m-5"                    
                        v-text="status.name"
                    ></span>             
                </div>
            </a> 
        </div> 
        <div class="mx-3 my-3">  
            <div class="">
                <p class="text-xs text-gray-500 leading-none">wir brauchen </p>
                <div class="flex items-center">   
                    <div 
                        v-for="(category, index) in need.categories" 
                        :key="index" 
                        :style="{color: category.color}"
                        class="flex uppercase font-bold text-sm text-white"
                    >                    
                        <div class="mr-1" v-html="category.icon"></div>
                        <p v-text="category.name"></p>
                    </div>
                </div>             
            </div>

            <h4 class="leading-tight font-bold my-2 text-lg" v-text="need.title"></h4>           
            
        </div>

        <div class="flex flex-wrap mt-3">
            <div 
                    v-for="(tag, index) in tags" 
                    :key="index" 
                    class="bg-gray-300 text-sm lowercase leading-none rounded-full text-gray-600 px-3 py-1 mr-1"
                >
                    <span v-text="tag.name"></span>
                </div>
        </div>       
        
    </div>
</template>

<script>
    export default {
        props:['need'],

        data(){
            return{
                tags:[
                    { name: 'Umwelt'},
                    { name: 'Fisch'},
                    { name: 'Plastik'},
                    { name: 'Meer'}
                ]
            }
        },

        computed:{
            status(){
                return this.need.status == 'completed' 
                    ? {name: 'abgeschlossen', classes: 'text-dg-yellow border-dg-yellow' } 
                    : {name: 'vergeben', classes: 'text-dg-blue border-dg-blue' } ;
            }
        }
        
    }
</script>
