<template>
    <div>
        <div class="flex">
            <button class="btn btn-yellow" @click="offerHelpModal">Interesse zeigen</button> 
        </div>
    </div>   
</template>
<script>
    export default {

        methods:{
        
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
                    .catch(error => {
                        flash(error.response.data.message);
                        this.$modal.hide('message-form');
                        window.loading()
                    });
                
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