<template>
    <div>
        <div class="flex justify-between items-center mb-2">
            <div>
                <p class="text-xs text-gray-600" v-if="comment.user_id == help.user_id">{{help.user.name}} sagt:</p>  
                <p class="text-xs text-gray-600" v-else>{{need.creator.name}} sagt:</p>
            </div>

            <div class="flex" v-show="owner">
                <button class="icon-btn" @click="destroy" > 
                    <svg class="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128 405.429C128 428.846 147.198 448 170.667 448h170.667C364.802 448 384 428.846 384 405.429V160H128v245.429zM416 96h-80l-26.785-32H202.786L176 96H96v32h320V96z"/></svg>
                </button>

                <button class="icon-btn" @click="updateModal">                                
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z"/></svg>
                </button>
            </div>
        </div>
       
        <p class="italic ml-5 " v-html="comment.body"></p>  

    </div>
</template>
<script>
export default {
    props:['comment', 'need', 'help', 'auth'],

    computed:{
        owner(){
            return this.comment.user_id == this.auth.id;
        }
    },

    methods:{
        destroy(){
            this.$modal.show('confirm-dialog', {
                title: 'Willst du dein Kommentar wirklich löschen?',                
                handler: () => this.destroyHandler()
            });
        },

        destroyHandler(){  
            window.loading()           
            axios
                .delete(`/comments/${this.comment.id}`)
                .then(()=>{
                    flash('Dein Kommentar wurde gelöscht.');
                    window.loading() 
                    window.location.reload();
                });
        },

        updateModal(){
            this.$modal.show('message-form', {
                title: 'Kommentar barbeiten',                   
                placeholder: 'Wie ist es gelaufen? ...', 
                action:  'update',
                messageId: this.comment.id,
                text: this.comment.body,                
            });
        },

        update(body){ 
            window.loading() 
            axios
                .put(`/comments/${this.comment.id}`, { body: body })
                .then(()=>{
                    window.loading() 
                    flash('Deine Kommentar wurde geändert');
                    window.location.reload();
                });
        },
    },

    mounted(){
        Event.$on(`submit-message-${this.help.id}`, (value)=> this.submitMessage(value))
    },

    beforeDestroy(){
        Event.$off(`submit-message-${this.help.id}`, (value)=> this.submitMessage(value))
    }


}
</script>