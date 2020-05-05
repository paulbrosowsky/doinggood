<template>
    <div class="flex flex-wrap justify-center mt-3">
        <div 
            v-for="(tag, index) in tags" 
            :key="index" 
            class="bg-gray-500 text-white font-semibold text-sm leading-tight rounded-full px-3 py-1 mr-2 mb-2"
        >
            <span v-text="tag"></span>
        </div>
    </div>   
</template>
<script>
export default {
    props:['tags']     
}
</script>