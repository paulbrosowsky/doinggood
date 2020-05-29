@extends('layouts.app')

@section('content')    
    <section class="w-full mx-auto md:w-2/3 lg:w-1/2">
        <div class="px-5 md:px-0">

            <div class="relative bg-gray-500 rounded-xl overflow-hidden pb-2/3 mb-5">           
                <img class="absolute w-full h-full object-cover" src="{{ $need->title_image }}" alt="">
            </div>

            <div class="px-3">
                <p class="text-xs text-gray-500 leading-none">wir brauchen </p>
                <categories :categories="{{$need->categories}}"></categories>

                <h2 class="leading-tight font-bold my-2 text-xl md:text-2xl">{{$need->title}}</h2>                 

                <div class="flex items-center mt-5">
                    <svg class="h-8 fill-current text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z"/></svg>
                    <div>
                        <p class="text-xs text-gray-500 leading-none">Deadline</p>
                        <p class="leading-none">{{ Carbon\Carbon::parse($need->deadline)->format('d.m.Y') }}</p>
                    </div>
                </div>

                @if($need->tagNames)
                    <div class="mt-5">
                        {{-- <p class="text-sm text-gray-500 leading-none ">unsere Themen</p> --}}
                        <tags :tags="{{ json_encode($need->tagNames) }}"></tags>  
                    </div>              
                @endif 
            </div>  
        </div>

        <div class="container py-3 mb-5 mt-3  md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Was haben wir vor ?</h4>

            <p>{!!$need->project_description!!}</p>
        </div>

        <div class="container py-3 md:rounded-xl">
            <h4 class="text-gray-500 mb-3">Was brauchen wir ?</h4>

            <p>{!!$need->need_description!!}</p>
        </div>

        @if ($need->creator->id != auth()->id())
            <div class="container py-3 mt-5 md:rounded-xl">
                <h4 class="text-gray-500 mb-3">Über uns</h4>

                <div class="flex items-center mb-5">
                    <avatar 
                        :image="{{ json_encode($need->creator->avatar) }}" 
                        :badge="{{json_encode( $need->creator->helper)}}" 
                        size="md"
                    ></avatar>
                    
                    <div class="ml-5">
                        <h4 class="font-semibold mb-2">{{$need->creator->name}}</h4>
                        <a href="{{route('profile', $need->creator->username)}}">
                            <button class="btn btn-blue">zum Profil</button>
                        </a>
                        
                    </div>                
                </div>

                <p>{{$need->creator->excerpt}}</p>
            </div>   
        @endif
        
        @if (auth()->check())        
            <div class="flex justify-end py-5 px-5">
                @can('update', $need)
                    <a href="{{route('need.edit', $need->id)}}">
                        <button class="btn btn-blue">Bearbeiten</button>
                    </a>                    
                @endcan                
                @if ($need->creator->id != auth()->id())
                    <need-action-buttons></need-action-buttons>
                @endif   
            </div>
        @endif
       

    </section> 
@endsection