<template>
    <div>
        <transition name="slide-down">
            <div class="mb-3" v-show="show">
                <slot/>
            </div>   
        </transition>  
        <div class="flex justify-center">            
            <button 
                class="flex flex-col items-center text-gray-500 text-sm focus:outline-none" 
                v-show="show" 
                @click="show = !show"
            >
                <p class="leading-none">weniger</p>
                <svg class="h-8 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 217.9L383 345c9.4 9.4 24.6 9.4 33.9 0 9.4-9.4 9.3-24.6 0-34L273 167c-9.1-9.1-23.7-9.3-33.1-.7L95 310.9c-4.7 4.7-7 10.9-7 17s2.3 12.3 7 17c9.4 9.4 24.6 9.4 33.9 0l127.1-127z"/></svg>
            </button>

            <button 
                class="flex flex-col items-center text-gray-600 text-sm focus:outline-none"  
                v-show="!show"
                @click="show = !show"
            >
                <p class="leading-none">mehr</p>
                <svg class="h-8 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 294.1L383 167c9.4-9.4 24.6-9.4 33.9 0s9.3 24.6 0 34L273 345c-9.1 9.1-23.7 9.3-33.1.7L95 201.1c-4.7-4.7-7-10.9-7-17s2.3-12.3 7-17c9.4-9.4 24.6-9.4 33.9 0l127.1 127z"/></svg>
            </button>
        </div>   
    </div>
</template>
<script>
    export default {

        data(){
            return{
                show: false
            }
        }
        
    }
</script>

<style lang="scss">

    .slide-down-enter-active, .slide-down-leave-active {
        transition: max-height .5s ease-in-out;
        overflow: hidden;
    }
    .slide-down-enter, .slide-down-leave-to /* .fade-leave-active below version 2.1.8 */ {
        max-height: 0;  
    }

    .slide-down-leave, .slide-down-enter-to {
        max-height: 1280px;
    }

</style>