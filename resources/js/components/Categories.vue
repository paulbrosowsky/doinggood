<template>
    <div class="">
        <p class="text-xs text-gray-500 leading-none">wir brauchen </p>
        <div class="flex items-center">
            <div v-for="(category, index) in categories" :key="index" :style="{color: category.color}"
                class="flex uppercase font-bold text-sm text-white">
                <div class="mr-1" v-html="category.icon"></div>
                <p v-text="category.name"></p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['categories']
        
    }
</script>