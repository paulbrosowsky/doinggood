<template>
    <modal 
        height="100%"
        :width="width"
        :pivotX=1
        name="navdrawer"
        classes="dg-navdrawer relative"  
    >
        <button class="icon-btn absolute right-0 mx-5 my-3" @click="$modal.hide('navdrawer')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M405 136.798L375.202 107 256 226.202 136.798 107 107 136.798 226.202 256 107 375.202 136.798 405 256 285.798 375.202 405 405 375.202 285.798 256z"/></svg>
        </button>

        <div class="flex h-full w-full flex flex-col items-center justify-center">

            <div class="flex flex-col items-center mb-10" v-if="user">                
                <avatar :image="user.avatar" :badge="user.helper" size="md"></avatar>

                <h4 class="font-semibold mt-5" v-text="user.name"></h4>
            </div>
            

            <div class="flex flex-col items-center mb-10">
                <a 
                    class="nav-link mb-1" 
                    :class="route == 'needs' ? 'bg-gray-200' : ''" 
                    @click="goto('/needs')"
                > Entdecken</a>               
                
                <a 
                    class="nav-link mb-1" 
                    :class="route == 'profile' ? 'bg-gray-200' : ''"
                    v-if="user"
                    @click="goto('/profiles/'+user.username)"
                >Profil</a>
                <a 
                    class="nav-link" 
                    :class="route == 'settings' ? 'bg-gray-200' : ''"
                    v-if="user"
                    @click="goto('/profiles/'+user.username+'/edit')"
                >Einstellungen</a>

                <a 
                    class="nav-link" 
                    :class="route == 'about' ? 'bg-gray-200' : ''"
                    v-if="!user"
                >Über uns</a>

                <a 
                    class="nav-link"
                    :class="route == 'about' ? 'bg-gray-200' : ''"
                >Kontakt</a>

                <a 
                    class="nav-link" 
                    :class="route == 'settings' ? 'bg-gray-200' : ''"
                    v-if="user"
                    @click="goto('/needs/create')"
                >Neuer Bedarf</a>
            </div>

            <div class="flex flex-col items-center" v-if="!user">
                <button 
                    class="btn btn-yellow mb-2" @click="goto('/login')">Anmelden</button>  
                <button class="btn btn-blue" @click="goto('/register')">Registrieren</button>   
            </div>     
                                      
            <button class="btn" @click="logout" v-if="user"> Abmelden</button>
        </div>
    </modal>
</template>
<script>
    export default {
       
       props:['user', 'route'],

        computed:{
            width(){
                return screen.width > 640 ? '350px' : '100%'
            }, 
        },

        methods:{
            logout(){
                axios.post('/logout')
                    .then(()=>{
                        this.goto('/');
                    });
            },

            goto(route){
                window.location.href = route;
            }
        }
        
    }
</script>
<style lang="scss">
    .dg-navdrawer{
        border-radius: 0;
    }
</style>