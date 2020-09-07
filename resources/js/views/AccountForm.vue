<template>
    <div>
        <div class="container mb-5 md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Email ändern</h4>
            <form @submit.prevent="updateEmail">
                <div>
                    
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.email">{{errors.email[0]}}</p>
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>                   
                        <input class="pl-12 pr-5"
                            type="text"
                            name="email"
                            v-model="email"
                            required 
                            placeholder="Email"
                        >
                    </div>
                </div>

                <div class="flex justify-end mt-5">
                    <button class="btn mr-2" @click.prevent="cancel">Abbrechen</button>
                    <button class="btn btn-yellow" type="submit">Ändern</button>
                </div> 
            </form>
        </div>

        <div class="container mb-5 md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Password ändern</h4>
            <form @submit.prevent="updatePassword">  
                <div>                    
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.password">{{errors.password[0]}}</p>
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M249.2 224c-14.2-40.2-55.1-72-100.2-72-57.2 0-101 46.8-101 104s45.8 104 103 104c45.1 0 84.1-31.8 98.2-72H352v64h69.1v-64H464v-64H249.2zm-97.6 66.5c-19 0-34.5-15.5-34.5-34.5s15.5-34.5 34.5-34.5 34.5 15.5 34.5 34.5-15.5 34.5-34.5 34.5z"/></svg>
                        <input class="pl-12 pr-5"
                            type="password"
                            name="password"
                            v-model="password"                        
                            placeholder="Passwort"
                        >
                    </div>
                </div>
                <div>            
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M249.2 224c-14.2-40.2-55.1-72-100.2-72-57.2 0-101 46.8-101 104s45.8 104 103 104c45.1 0 84.1-31.8 98.2-72H352v64h69.1v-64H464v-64H249.2zm-97.6 66.5c-19 0-34.5-15.5-34.5-34.5s15.5-34.5 34.5-34.5 34.5 15.5 34.5 34.5-15.5 34.5-34.5 34.5z"/></svg>
                        <input class="pl-12 pr-5"
                            type="password"
                            name="password_confirmation"
                            v-model="password_confirmation"                        
                            placeholder="Passwort bestätigen"
                        >
                    </div>
                </div>

                <div class="flex justify-end mt-5">
                    <button class="btn mr-2" @click.prevent="cancel">Abbrechen</button>
                    <button class="btn btn-yellow" type="submit">Ändern</button>
                </div> 

            </form>
        </div>

        <div class="container md:rounded-xl">
            <div class="mx-auto md:w-2/3">
                <button class="btn btn-red w-full" @click="deleteAccount">Benutzerkonto löschen</button>
                <p class="text-xs text-red-500 mt-2">Nach dem Löschen kannst du auf dein Benutzerkonto nicht mehr zugreifen. Deine Daten werden vollständig gelöscht und können nicht wiederhergestellt werden.</p>
            </div>
        </div>
    </div>
   
</template>
<script>
export default {
    props:['user'],

    data(){
        return{            
            email: this.user.email,
            password: null,
            password_confirmation: null,            

            errors:[]
        }
    },

    methods:{
        updateEmail() {
            window.loading();
            axios
                .post(`/account/update/email`, {email: this.email})
                .then(() => {
                    window.loading();
                    flash('Bitte bestätige noch deine neue Email-Adresse.');
                    
                    setTimeout(() => {
                        window.location.href = `/profiles/${this.user.username}`;
                    }, 3000);                      
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },

        updatePassword() {
            window.loading();
            axios
                .post(`/account/update/password`, {
                    password: this.password,
                    password_confirmation: this.password_confirmation
                 })
                .then(() => {
                    window.loading();
                    flash('Dein Password wurde geändert');

                    setTimeout(() => {
                        window.location.href = `/profiles/${this.user.username}`;
                    }, 3000);  
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },

        deleteAccount(){
            this.$modal.show('confirm-dialog', {
                title: 'Willst du dein Benutzerkonto wirklich löschen?',
                text: 'Schade, ich dachte wir wären inzwischen sowas wie Freunde.',
                handler: () => this.deleteHandler()
            });
        },

        deleteHandler(){
            window.loading();
            axios
                .delete('/account/destroy')
                .then(()=>{
                    window.loading();
                    flash('Dein Benuzerkonto wurde gelöscht, Schade. Wir hoffen dich bald wieder zusehen.');

                    setTimeout(() => {
                        window.location.href = `/`;
                    }, 3000); 
                });
        },

        cancel(){
            window.history.back();
        }
    }
}
</script>