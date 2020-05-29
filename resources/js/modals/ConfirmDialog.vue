<template>
    <modal   
        classes="dg-modal"      
        name="confirm-dialog"
        @before-open="beforeOpen"        
        width="360" 
        height="auto"       
    >
        <div class="text-center">
            <h3 class="text-xl text-bold mb-5" v-text="title"></h3>
            <p class="text-gray-500 mb-5" v-text="text"></p>
            <div class="flex">
                <button class="btn w-full mr-1" @click="$modal.hide('confirm-dialog')">Nein</button>
                <button class="btn btn-yellow w-full ml-1 " @click="executeHandler">Ja</button>
            </div>
        </div>        
    </modal>
</template>
<script>
    export default {

        data(){
            return{
                title: '',
                text: '',
                handler: null           
            }
        },

        methods:{
            beforeOpen(event){  
                this.title = event.params.title;
                this.text = event.params.text;
                this.handler = event.params.handler;                
            },   
            
            executeHandler(){
                this.handler();                 
                this.$modal.hide("confirm-dialog");               
            },            
            
            resetData(){
                this.title = '';
                this.text = '';
                this.handler = null;
            }
            
        }
        
    }
</script>