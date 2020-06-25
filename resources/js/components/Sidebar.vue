<template>    
    <transition name="slide">
        <nav 
            class="dg-sidebar fixed h-full w-full bg-white top-0 right-0 mt-16 z-20 md:w-80"               
            v-show="show"
        >  
            <div class="h-full">
                <div class="flex items-center bg-gray-200 px-2 pb-3 pt-5 md:pt-3">                        
                    <button class="icon-btn icon-btn-blue mr-3" @click="show = !show">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>
                    </button>
                    <h3 class="text-gray-600 text-lg"> Ergebnisse Filtern</h3>
                </div>                   
                
                    <perfect-scrollbar class="h-full pt-5 px-5 pb-32">                        
                        <slot></slot>
                    </perfect-scrollbar> 
                              
            </div>
           
            
            </nav>
    </transition>
</template>
<script>
    import { PerfectScrollbar } from 'vue2-perfect-scrollbar';
    import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css';

    export default {
        components: {
            PerfectScrollbar
        },

        data(){
            return{
                show: false
            }
        },        


        created(){
            // screen.width > 768 ? this.show = true : '';
            
            Event.$on('toggle-sidebar', ()=>{
                this.show =  !this.show               
            });
        },

        beforeDestroy(){
            Event.$off('toggle-sidebar', ()=>{
                this.show =  !this.show               
            });
        }
        
    }
</script>
<style>
    .dg-sidebar{
        box-shadow: -1px 0 3px 0 rgba(0, 0, 0, 0.1), -1px 0 2px 0 rgba(0, 0, 0, 0.06);
    }
    .slide-enter-active, .slide-leave-active {
        transition: all .3s ease-in-out;
    }
    .slide-enter, .slide-leave-to {       
        right: -350px;
    }
</style>