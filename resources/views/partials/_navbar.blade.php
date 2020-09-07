<navbar inline-template>
    <nav class="fixed top-0 left-0 right-0 bg-white shadow z-50 py-2 px-5">
        <div class="flex items-center mx-auto" style="max-width:1280px">

            <div class="mr-10">
                <a class="flex items-center"  href="{{ url('/') }}">
                    <div class="w-32">
                        <img src="/storage/assets/logo.png" alt="">
                    </div>
                </a>            
            </div> 

            <div class="w-full flex justify-end md:justify-between items-center ">
                <div class="">
                    <div class="hidden uppercase font-semibold text-sm text-gray-700 md:flex">
                        <a                                         
                            href="{{ route('needs')}}"
                            class="{{ Route::currentRouteName() == 'needs' 
                                ? 'bg-gray-200 rounded-lg py-2 px-3 mr-1'  
                                : 'rounded-lg py-2 px-3 hover:bg-gray-200' }}"
                        >
                            Entdecken
                        </a>

                    </div>
                </div> 
                <div class="">            
                    @guest
                        <div class="items-center hidden md:flex">
                            <a href="{{ route('login') }}">
                                <button class="btn btn-yellow mr-2">
                                    Anmelden
                                </button>    
                            </a>                     
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">
                                    <button class="btn btn-blue">
                                        Registrieren
                                    </button>
                                </a>
                            @endif
                        </div>

                        <button class="icon-btn my-2 md:hidden" @click="$modal.show('navdrawer')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M64 384h384v-42.666H64V384zm0-106.666h384v-42.667H64v42.667zM64 128v42.665h384V128H64z"/></svg>
                        </button>
                     
                    @else        
                        <!-- Right Side Of Navbar -->
                        <div class="flex items-center">
                            <!-- Authentication Links -->                 
                            <p class="hidden text-sm text-gray-700 font-semibold mr-3 md:block">{{ Auth::user()->name }}</p>
                            
                            <a class="cursor-pointer" @click="$modal.show('navdrawer')">                        
                                <avatar 
                                    :image="{{ json_encode(auth()->user()->avatar) }}" 
                                    :badge="{{ json_encode(auth()->user()->helper) }}" 
                                    size="xs"
                                ></avatar>
                            </a>                                      
                        </div>
                    @endguest                    
                </div>
            </div>       
        </div>
    </nav>
</navbar>