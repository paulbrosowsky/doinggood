<template>
    <div class="container py-3 mt-3 md:rounded-xl">
        <div class="flex items-center">
            <a class="cursor-pointer"  @click="toProfile">
                <avatar 
                    :image="user.avatar" 
                    :badge="user.helper" 
                    size="sm"
                ></avatar>
            </a>
            
            <div class="w-full ml-5">
                <a class="cursor-pointer " @click="toProfile">
                    <h4 class="font-semibold mb-1 md:w-1/2 ">{{user.name}}</h4>  
                </a>                  

                <div class="w-full justify-between flex">
                    
                        <div class="items-center text-gray-500 hidden md:flex" >
                            <svg class="h-5 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 32c-88.004 0-160 70.557-160 156.801C96 306.4 256 480 256 480s160-173.6 160-291.199C416 102.557 344.004 32 256 32zm0 212.801c-31.996 0-57.144-24.645-57.144-56 0-31.357 25.147-56 57.144-56s57.144 24.643 57.144 56c0 31.355-25.148 56-57.144 56z"/></svg>
                              
                            <p class="leading-none">Trier</p>
                            <span class="mx-1"> &bull;</span>
                            
                            <p>
                                <strong>{{feedCount}}</strong>
                                <span>Hilfen</span>
                            </p>                            
                                                                          
                        </div>

                        <div class="flex md:mb-3 md:-mt-3" >
                            <contact-form v-if="needOwner" :user="user.username" :icon="true" class="mr-2"></contact-form>

                            <button 
                                class="btn btn-red mr-2" 
                                @click="rejectModal"
                                v-if="needOwner && !completed"
                            >Abbrechen</button>

                            <button 
                                class="btn btn-yellow" 
                                @click="assign"                                 
                                v-if="needOwner && !assigned && !completed
                            ">Annehmen</button>

                            <button 
                                class="btn btn-red mr-2" 
                                @click="withdrawModal"
                                v-if="helpOwner && !completed"
                            >Zurückziehen</button>

                            <button 
                                class="btn btn-yellow mr-2" 
                                @click="completeModal"
                                v-if="(needOwner || helpOwner) && assigned && !completed"
                            >Feedback</button>

                            <button 
                                class="btn btn-blue mr-2" 
                                @click="commentModal"
                                v-if="(needOwner || helpOwner) && completed"
                            >Kommentrieren</button>
                        </div>
                    
                </div>                
            </div>             
        </div>    

        <div class="border-t-2 pt-3 mt-3 " v-if="comments.length > 0">
            <comment 
                class="mb-5" 
                v-for="(comment, index) in comments" 
                :key="index"
                :comment="comment"
                :help="help"
                :need="need"
                :auth="auth"
            ></comment>            
        </div>       
       
    </div>
</template>
<script>
import Comment from "./Comment";

export default {
    components:{ Comment },
    
    props:['help', 'feedCount', 'auth', 'need'],

    data(){
        return{
            user: this.help.user,
            comments: this.help.comments            
        }
    },

    computed:{
        needOwner(){
            return this.need.user_id === this.auth.id;
        },

        helpOwner(){
            return this.help.user_id === this.auth.id;
        },

        assigned(){
            return this.help.state_id === 2;
        },

        completed(){
            return this.help.state_id === 3;
        }
    },

    methods:{
        toProfile(){
            window.location.href = `/profiles/${this.user.username}`;
        },

        assign(){  
            window.loading();          
            axios
                .put(`/helps/${this.help.id}/assign`)
                .then(()=>{
                    window.loading(); 
                    flash('Du hast dein Bedarf erfolgreich vermittelt.');
                    window.location.reload();
                })
        },

        rejectModal(){
            this.$modal.show('message-form', {
                title: 'Hilfe ablehnen',                   
                placeholder: 'Wieso lehnst du ab? ...', 
                action:  'reject',
                messageId: this.help.id                
            });
        },

        reject(body){
            window.loading();
            axios
                .put(`/helps/${this.help.id}/reject`, {message: body} )
                .then(()=>{
                    window.loading();
                    flash('Die Hilfe wurde abgelehnt.');
                    window.location.reload();
                })
        },

        withdrawModal(){
            this.$modal.show('message-form', {
                title: 'Hilfe zurückziehen',                   
                placeholder: 'Wieso ziehst du deine Hilfe zurück? ...', 
                action:  'withdraw',
                messageId: this.help.id                
            });
        },

        withdraw(body){       
            window.loading();
            axios
                .delete(`/helps/${this.help.id}`, {data:{ message: body }})
                .then(()=>{
                    window.loading();
                    flash('Deine Hilfe wurde zurückgezogen.');
                    window.location.reload();
                })
        },

        completeModal(){
            this.$modal.show('message-form', {
                title: 'Hilfe abgeschlossen',                   
                placeholder: 'Wie ist es gelaufen? ...', 
                action:  'complete',
                messageId: this.help.id                
            });
        },

        complete(body){ 
            window.loading();         
            axios
                .put(`/helps/${this.help.id}/complete`, { message: body })
                .then(()=>{
                    window.loading();
                    flash('Deine Hilfe wurde als abgeschlossen markiert.');
                    window.location.reload();
                });
        },

        commentModal(){
            this.$modal.show('message-form', {
                title: 'Kommentieren',                   
                placeholder: 'Wie ist es gelaufen? ...', 
                action:  'comment',
                messageId: this.help.id                
            });
        },

        comment(body){         
            window.loading();
            axios
                .post(`/helps/${this.help.id}/comment`, { body: body })
                .then(()=>{
                    window.loading();
                    flash('Kommentar gespeichert');
                    window.location.reload();
                });
        },

        submitMessage(message){               
            this[message.action](message.body);
        }
    },

    mounted(){
        Event.$on(`submit-message-${this.help.id}`, (value)=> this.submitMessage(value))
    },

    beforeDestroy(){
        Event.$off(`submit-message-${this.help.id}`, (value)=> this.submitMessage(value))
    }
    
}
</script>
