<template>
    <div class="flex items-center flex-wrap">
        <div v-for="(category, index) in categories" 
            :key="index" 
            :style="{color: category.color}"
            class="dg-category mr-2"
        >
            <div class="mr-1" v-html="category.icon"></div>
            <p v-text="category.name"></p>
        </div>
    </div>
</template>
<script>
    export default {
        props:['categories']
        
    }
</script>