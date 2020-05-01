<template>
    <div class="flex flex-wrap mt-3">
        <div 
            v-for="(tag, index) in tags" 
            :key="index" 
            class="bg-gray-300 text-sm lowercase leading-none rounded-full text-gray-600 px-3 py-1 mr-1"
        >
            <span v-text="tag.name"></span>
        </div>
    </div>   
</template>
<script>
export default {
    

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
    
}
</script>