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

                        <div class="flex md:mb-3 md:-mt-3">
                            <button class="btn btn-red mr-2">Ablehnen</button>
                            <button class="btn btn-yellow">Vermittlen</button>
                        </div>
                    
                </div> 
            </div>                                            
            
        </div>
       
    </div>
</template>
<script>
export default {
    props:['user', 'feedCount'],

    methods:{
        toProfile(){
            window.location.href = `/profiles/${this.user.username}`;
        }
    }
    
}
</script>
