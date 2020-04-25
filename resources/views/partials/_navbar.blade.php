<nav class="border-b py-2 px-5">
    <div class="flex justify-between mx-auto" style="max-width:1280px">

        <div>
            <a class="flex items-center"  href="{{ url('/') }}">
                <div class="w-12 h-12">
                    <img src="/storage/assets/logo_short.png" alt="">
                </div>
                       
                <div class="text-sm uppercase leading-none ml-2" style="font-family: 'Poppins', sans-serif"> 
                    <p>Doing</p>    
                    <p>Good</p>  
                    <p>Community</p>   
                </div>  
            </a>            
        </div>        

        <div class=" flex items-center">
            @guest
                <a href="{{ route('login') }}">
                    <button class="hidden btn btn-yellow mr-2 md:block">
                        Anmelden
                    </button>    
                </a> 
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        <button class="btn btn-blue hidden md:block">
                            Registrieren
                        </button>
                    </a>
                @endif
                @else

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
             
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>