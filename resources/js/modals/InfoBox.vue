<template>
    <modal   
        classes="dg-modal"      
        name="info-box"
        @before-open="beforeOpen"        
        width="360" 
        height="auto"       
    >
        <div>
            <strong v-text="title"></strong>
            <p v-text="text"></p>
        </div>
    </modal>
</template>
<script>
    export default {

        data(){
            return{
                title: '',
                text: ''
            }
        },


        methods:{
            beforeOpen(event){  
                this.title = event.params.title; 
                this.text = event.params.text;               
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