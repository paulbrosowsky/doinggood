<template>
    <section >
        <div class="li-tabs flex justify-center mb-3 overflow-x-scroll">
            <div                          
                v-for="(tab, index) in tabs" 
                :key="index"                
            >   
                <button 
                    class="flex items-center nav-link mr-2"
                    :class="{ 'bg-gray-200' : tab == activeTab }"
                    @click="setActiveTab(tab)"
                    role-tab
                    :aria-selected="tab == activeTab"
                >                            
                    <p v-text="tab.name" ></p>                   

                    <p 
                        class="text-xs text-white px-2 mr-2 rounded-full bg-gray-500 font-bold"
                        :class="{ 'bg-teal-500' : tab == activeTab }"                            
                        v-text="tab.count"
                        v-if="tab.count"
                    ></p>

                </button> 
            </div>  
        </div>
       
        
        <slot></slot>
    

    </section>

</template>
<script>
    // import { dragscroll } from 'vue-dragscroll';

    export default {      
        
        // directives: {
        //     'dragscroll': dragscroll
        // },  

        data(){
           return{
               tabs:[],
               activeTab: null
           }
        },    
        
        watch:{
            activeTab(activeTab){
                this.tabs.map(tab => (tab.show = tab == activeTab ))
            }
        },

        methods:{
            setActiveTab(tab){
                this.activeTab = tab;

                if(tab.hash){
                    history.pushState({}, null, '#'+ tab.hash) 
                }else{
                    var noHashURL = window.location.href.replace(/#.*$/, '');
                    window.history.replaceState({}, null, noHashURL) 
                }   
                
                this.$emit('update', this.activeTab.hash);
              
            },
        },       

        mounted(){            
            this.tabs = this.$children;

            window.location.hash 
                ? this.tabs.map(tab => (tab.isActive ? this.activeTab = tab : ''))
                : this.activeTab = this.tabs[0]; 
        },
       
    }
</script>

<style >
    .li-tabs{
        -ms-overflow-style: none;
    }
    .li-tabs::-webkit-scrollbar{
        display: none;
    }
</style>