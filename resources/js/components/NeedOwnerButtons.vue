<template>
    <div>
        <button class="btn btn-blue ml-2" @click="assign" v-if="!assigned && !completed">vermittelt</button>
        <button class="btn btn-yellow ml-2" @click="complete" v-if="assigned && !completed && need.completable"> 
            abgeschlossen
        </button>
    </div>
</template>
<script>
export default {

    props:['need'],

    computed:{
        assigned(){
            return this.need.state_id == 2;
        },

        completed(){
            return this.need.state_id == 3;
        }
    },

    methods:{
        assign(){
            window.loading();
            axios
                .put(`/needs/${this.need.id}/assign`)
                .then(() => {
                    flash('Dein Bedarf wurde als vermittelt markiert');

                    setTimeout(() => {    
                        window.loading();                    
                        window.location.reload();
                    }, 3000); 
                })
                .catch((errors)=> {
                    window.loading();   
                });            
        },

        complete(){
            this.$modal.show('confirm-dialog', {
                title: 'Hilfe wirklich als abgeschlossen markieren?',                
                handler: () => this.completeHandler()
            });
        },

        completeHandler(){
            window.loading();  
            axios
                .put(`/needs/${this.need.id}/complete`)
                .then(()=>{
                    flash('Dein Bedarf wurde als abgeschlossen markiert');

                    setTimeout(() => {
                        window.loading();  
                        window.location.reload();
                    }, 3000); 
                });
        },
    }
    
}
</script>