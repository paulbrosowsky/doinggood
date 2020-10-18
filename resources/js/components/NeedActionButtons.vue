<template>
    <div>
        <div class="flex">
            <!-- <button class="btn mr-2" @click="askQuestionModal">Frage stellen</button> -->
            <button class="btn btn-yellow" @click="offerHelpModal">Interesse zeigen</button> 
        </div>
    </div>   
</template>
<script>
    export default {

        methods:{
            askQuestionModal(){
                this.$modal.show('message-form', {
                    title: 'Frage stellen',                   
                    placeholder: 'Stelle hier deine Frage ...', 
                    action:  'askQuestion'                                                    
                });
            },

            askQuestion(body){                
                window.loading();

                axios
                    .post(`${window.location.href}/question`, {body: body})
                    .then(()=> {
                        flash('Deine Frage wurde geschickt.');  
                        window.loading(); 
                        
                        this.$modal.hide('message-form');
                    })
                    .catch(()=> window.loading())
                
            },

            offerHelpModal(){
                this.$modal.show('message-form', {
                    title: 'Interesse zeigen',                   
                    placeholder: 'Beschreibe hier deine Motivation ...', 
                    action:  'offerHelp'                    
                });
            },

            offerHelp(message){                
                window.loading();

                axios
                    .post(`${window.location.href}/help`, {message: message})
                    .then(()=> {
                        flash('Dein Angebot wurde geschickt.');  
                        window.loading(); 
                        
                        this.$modal.hide('message-form');
                        window.location.reload();
                    })
                    .catch(()=> window.loading())
                
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