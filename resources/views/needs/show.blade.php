@extends('layouts.app')

@section('content')    
    <section class="w-full mx-auto md:w-1/2">
        <div class="px-5 md:px-0">

            <div class="relative bg-gray-500 rounded-xl overflow-hidden pb-2/3 mb-5">           
                <img class="absolute w-full h-full object-cover" src="https://source.unsplash.com/800x600/?nature" alt="">
            </div>

            <div class="px-3">
                <categories :categories="{{$need->categories}}"></categories>

                <h2 class="leading-tight font-bold my-2 text-xl md:text-2xl">{{$need->title}}</h2> 

                <div class="flex items-center mt-5">
                    <svg class="h-8 fill-current text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z"/></svg>
                    <div>
                        <p class="text-xs text-gray-500 leading-none">Deadline</p>
                        <p class="leading-none">{{ Carbon\Carbon::parse($need->deadline)->format('d.m.Y') }}</p>
                    </div>
                </div>
            </div>  
        </div>

        <div class="container py-3 mb-5 mt-5  md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Was haben wir vor ?</h4>

            <p>{{$need->project_description}}</p>
        </div>

        <div class="container py-3 mb-5 md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Was brauchen wir ?</h4>

            <p>{{$need->need_description}}</p>
        </div>

        <div class="container py-3 md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Über uns</h4>

            <div class="flex items-center mb-5">
                <div class="relative h-20 w-20 rounded-full bg-gray-500 overflow-hidden mr-5">
                    <img class="absolute w-full h-full object-cover" src="https://source.unsplash.com/800x600/?avatar" alt="">                    
                </div>
                <div>
                    <h4 class="font-bold mb-2">{{$need->creator->name}}</h4>
                    <button class="btn btn-blue">zum Profil</button>
                </div>                
            </div>

            <p>{{$need->creator->excerpt}}</p>
        </div>  
        
        <div class="flex justify-end py-5 px-5">
            <button class="btn mr-2">Frage stellen</button>
            <button class="btn btn-yellow">Interesse ziegen</button>            
        </div>



    </section> 
@endsection