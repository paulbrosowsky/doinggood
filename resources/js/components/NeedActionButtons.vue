<template>
    <div>
        <div class="flex">
            <button class="btn mr-2" @click="askQuestionModal">Frage stellen</button>
            <button class="btn btn-yellow">Interesse ziegen</button> 
        </div>

        <loading v-if="loading"></loading>
    </div>   
</template>
<script>
    export default {

        data(){
            return{
                loading: false
            }
        },

        methods:{
            askQuestionModal(){
                this.$modal.show('message-form', {
                    title: 'Frage stellen',                   
                    placeholder: 'Stelle hier deine Frage ...', 
                    action:  'askQuestion'                 
                });
            },

            askQuestion(body){                
                this.loading = true;

                axios
                    .post(`${window.location.href}/question`, {body: body})
                    .then(()=> {
                        flash('Deine Frage wurde geschickt.');  
                        this.loading = false; 
                        
                        this.$modal.hide('message-form');
                    })
                    .catch(()=> this.loading = false)
                
            },

            submitQuestion(message){               
                this[message.action](message.body);
            }
        },

        mounted(){
            Event.$on('submit-message', (value)=> this.submitQuestion(value))
        },

        beforeDestroy(){
            Event.$off('submit-message', (value)=> this.submitQuestion(value))
        }
        
    }
</script>