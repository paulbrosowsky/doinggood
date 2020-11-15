<template>
    <div>
        <button class="btn" :class="icon ? 'px-3' : ''" @click="askQuestionModal">
            <svg v-show="icon" class="fill-current h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>
            <span v-show="!icon">Kontaktieren</span> 
        </button>
    </div>
</template>
<script>
export default {

    props:{
        user:{
            type: String
        }, 
        icon:{
            type: Boolean,
            default: false
        }
    },
    
    methods:{
        askQuestionModal(){
            this.$modal.show('message-form', {
                title: 'Kontaktieren',                   
                placeholder: 'Stelle hier deine Frage ...', 
                action:  'askQuestion',     
                messageId: 'user-' + this.user                                              
            });
        },

        askQuestion(body){                
            loading();

            axios
                .post(`${window.location.href}/users/${this.user}`, {body: body})
                .then(()=> {
                    flash('Deine Frage wurde geschickt.');  
                    loading(); 
                    
                    this.$modal.hide('message-form');
                })
                .catch(()=> window.loading())
        },

      
    },

    mounted(){
            Event.$on('submit-message-user-' + this.user, (value)=> this.askQuestion(value.body))
        },

        beforeDestroy(){
            Event.$off('submit-message-user-' + this.user, (value)=> this.askQuestion(value))
        }
    
}
</script>