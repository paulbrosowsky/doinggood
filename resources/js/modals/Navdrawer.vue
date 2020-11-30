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
                    href="https://doinggoodchallenge.de/ueber-uns-kontakt/"
                    class="nav-link" 
                    :class="route == 'about' ? 'bg-gray-200' : ''"
                    v-if="!user"
                >Über uns</a>

                <button 
                    class="nav-link flex items-center text-sm font-bold uppercase text-dg-blue  hover:text-blue-700 focus:outline-none"
                    :class="route == 'need.create' ? 'bg-gray-200' : ''"
                    v-if="user && !user.helper"
                    @click="goto('/needs/create')"
                >
                    <svg class="h-6 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M363 277h-86v86h-42v-86h-86v-42h86v-86h42v86h86v42z"/><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422c-44.3 0-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256c0-44.3 17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/></svg>
                    <span class="hidden md:block">Neuer Bedarf </span> 
                    <span class="md:hidden">Neu</span>   
                </button>

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
                window.loading();
                axios.post('/logout')
                    .then(()=>{
                        window.loading();
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