@extends('layouts.app')

@section('content')
<div class="w-full mx-auto mt-10 md:mt-20 md:w-1/2 lg:w-1/3">
    <div class="container md:px-8 md:rounded-xl">
        <h4 class="container-title">Passwort zurücksetzen</h4>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

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

                <p class="text-xs leading-tight mb-2 mt-5 text-gray-700">Auf diese Adresse werden wir den Link zur Wiederherstellung deines Passworts senden. Bitte prüfe deinen Postfach evtl. auch den Spam-Ordner. </p>
                <button type="submit" class="btn btn-yellow w-full">
                    Link senden
                </button>
                  
            </form>
        </div>
    </div>
</div>


                
            
@endsection
