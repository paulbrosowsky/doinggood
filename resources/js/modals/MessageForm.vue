<template>
    <modal   
        classes="dg-modal relative"      
        name="message-form"
        height="auto"   
        @before-open="beforeOpen"  
        @before-close="beforeClose"                  
    >
        <button class="icon-btn absolute right-0 top-0 m-3" @click="close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M405 136.798L375.202 107 256 226.202 136.798 107 107 136.798 226.202 256 107 375.202 136.798 405 256 285.798 375.202 405 405 375.202 285.798 256z"/></svg>
        </button>

        <h3 class="text-xl mb-5 text-gray-500" v-text="title"></h3>

        <form @submit.prevent="submit"> 

            <p class="text-sm text-red-500 mb-2 ml-2" v-if="error" v-text="error"></p>
            <text-editor 
                class="mb-5"
                :placeholder="placeholder"
                :editorId="'message'"   
                :text="text"            
                @update="updateText"
            ></text-editor>

            <div class="flex justify-end">
                <button class="btn mr-2" @click.prevent="close">Abbrechen</button>
                <button class="btn btn-yellow" v-text="title" type="submit"></button>
            </div>
            
        </form>
    </modal>
</template>
<script>
export default {

    data(){
        return{
            title: 'Modal Title',
            placeholder: 'Erzähl mehr ...',
            action: null,            
            text: null,
            messageId: null,
            error: null            
        }
    },

    computed:{
        submitEvent(){
            return this.messageId ? `submit-message-${this.messageId}`: 'submit-message';
        }
    },

    methods:{
        beforeOpen(event){
            this.title = event.params.title;
            this.placeholder = event.params.placeholder;
            this.action = event.params.action;
            this.messageId = event.params.messageId;                       
        },    
        
        beforeClose(){            
            this.messageId = null;         
        },

        submit(){
            if(this.text){
                Event.$emit( this.submitEvent , {
                    action: this.action,
                    body: this.text
                }); 
            }else{
                this.error = 'Text muss ausgefüllt sein.'
            }         
        },

        updateText(text){
            this.error = null;
            this.text = text;
        },

        close(){
            this.text = '';
            this.$modal.hide('message-form');
        }
    } 
    
}
</script>