@extends('layouts.app')

@section('content')
<div class="w-full mx-auto mt-10 md:mt-20 md:w-1/2 lg:w-1/3">
    <div class="container md:px-8 md:rounded-xl">
        <h4 class="container-title">Registrieren</h4>
        
        <div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    @error('name')
                            <span class="text-sm text-red-500 mb-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror

                    <div class="input">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96z"/></svg>
                        <input 
                            class="pl-12 pr-5"                            
                            type="text"                             
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autocomplete="name"                             
                            autofocus
                            placeholder="Name"
                        >                        
                    </div>
                </div>

                <div>
                    @error('email')
                    <p class="text-sm text-red-500 mb-2" role="alert">
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="input">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>
                        <input 
                            class="pl-12 pr-5"
                            type="email"                            
                            name="email" 
                            value="{{ old('email') }}" 
                            required autocomplete="email" 
                            placeholder="Email"
                            autofocus
                        >
                    </div>
                </div>

                <div>
                    @error('password')
                        <p class="text-sm text-red-500 mb-2" role="alert">
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="input">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M249.2 224c-14.2-40.2-55.1-72-100.2-72-57.2 0-101 46.8-101 104s45.8 104 103 104c45.1 0 84.1-31.8 98.2-72H352v64h69.1v-64H464v-64H249.2zm-97.6 66.5c-19 0-34.5-15.5-34.5-34.5s15.5-34.5 34.5-34.5 34.5 15.5 34.5 34.5-15.5 34.5-34.5 34.5z"/></svg>
                        <input
                            class="pl-12 pr-5" 
                            type="password"                            
                            name="password" 
                            required
                            placeholder="Passwort"
                            autocomplete="current-password">                       
                    </div>
                </div>      
                
                <div>
                    <div class="input">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M249.2 224c-14.2-40.2-55.1-72-100.2-72-57.2 0-101 46.8-101 104s45.8 104 103 104c45.1 0 84.1-31.8 98.2-72H352v64h69.1v-64H464v-64H249.2zm-97.6 66.5c-19 0-34.5-15.5-34.5-34.5s15.5-34.5 34.5-34.5 34.5 15.5 34.5 34.5-15.5 34.5-34.5 34.5z"/></svg>
                        
                        <input 
                            class="pl-12 pr-5" 
                            type="password"  
                            name="password_confirmation" 
                            required 
                            placeholder="Passwort bestätigen"
                            autocomplete="new-password"
                        >                      
                    </div>
                </div>  

                <div class="w-full">
                    <p class="text-xs leading-tight mb-2 mt-5 text-gray-700">
                        Mit deiner Registrierung erstellst du ein neues Benutzerkonto und gibst dein Einverständnis zu unseren Datenschutz- und Nutzungsbedingungen.
                    </p>
                    <button type="submit" class="btn btn-blue w-full">
                        Registrieren 
                    </button>                    
                </div>
            </form> 
        </div>
    </div>
</div>


              
    
@endsection
