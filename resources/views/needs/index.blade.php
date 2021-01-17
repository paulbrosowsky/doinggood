@extends('layouts.app')

@section('content')

<div class="mx-5 md:mx-10 lg:mx-32">

    <search 
        class="w-full"
        algolia-id="{{ config('scout.algolia.id') }}"
        algolia-secret="{{ config('scout.algolia.secret') }}"  
        inline-template
    >
        <ais-instant-search
            :search-client="searchClient"
            index-name="needs"
        >        
            <div class=" mb-2 mx-auto md:flex md:w-2/3 "> 
                <div class="relative w-full rounded-lg ">                   
                    <svg class="fill-current h-8 m-2 absolute text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M337.509 305.372h-17.501l-6.571-5.486c20.791-25.232 33.922-57.054 33.922-93.257C347.358 127.632 283.896 64 205.135 64 127.452 64 64 127.632 64 206.629s63.452 142.628 142.225 142.628c35.011 0 67.831-13.167 92.991-34.008l6.561 5.487v17.551L415.18 448 448 415.086 337.509 305.372zm-131.284 0c-54.702 0-98.463-43.887-98.463-98.743 0-54.858 43.761-98.742 98.463-98.742 54.7 0 98.462 43.884 98.462 98.742 0 54.856-43.762 98.743-98.462 98.743z"/></svg>
                    <ais-search-box 
                        placeholder="Suchen nach Bedarf ..."
                        :class-names="{
                            'ais-SearchBox-form': 'w-full top-0 left-0 ',
                            'ais-SearchBox-input': 'bg-gray-300 px-12 rounded-lg px-5 py-3 w-full focus:outline-none ',
                            'ais-SearchBox-submit': 'hidden',
                            'ais-SearchBox-resetIcon': 'fill-current w-4 h-4 text-gray-500',
                            'ais-SearchBox-reset': 'absolute top-0 right-0 m-4'
                        }"
                    />                       
                </div>                              
            </div>
            
            <div class="flex items-center justify-between w-full mx-auto mb-5 md:w-2/3">                
                <div class="flex items-center mt-2">
                    <x-new-need-button></x-new-need-button>
                    <button 
                        class="flex items-center text-sm font-bold uppercase text-gray-600  ml-2 pl-2 cursor-waithover:text-gray-800 focus:outline-none" @click="toggleSidebar">
                        <svg class="h-6 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M32 384h272v32H32zM400 384h80v32h-80zM384 447.5c0 17.949-14.327 32.5-32 32.5-17.673 0-32-14.551-32-32.5v-95c0-17.949 14.327-32.5 32-32.5 17.673 0 32 14.551 32 32.5v95z"/><g><path d="M32 240h80v32H32zM208 240h272v32H208zM192 303.5c0 17.949-14.327 32.5-32 32.5-17.673 0-32-14.551-32-32.5v-95c0-17.949 14.327-32.5 32-32.5 17.673 0 32 14.551 32 32.5v95z"/></g><g><path d="M32 96h272v32H32zM400 96h80v32h-80zM384 159.5c0 17.949-14.327 32.5-32 32.5-17.673 0-32-14.551-32-32.5v-95c0-17.949 14.327-32.5 32-32.5 17.673 0 32 14.551 32 32.5v95z"/></g></svg>
                        <span>Filtern </span>  
                    </button>   
                </div>
                <ais-powered-by class="opacity-75 mt-1" theme="light"/>
            </div>
            

            <div class="mx-auto  mb:mt-0 md:w-2/3">
                <ais-current-refinements
                :included-attributes="['state.name', 'categories.name', 'tags']"
                :class-names="{
                    'ais-CurrentRefinements-list': 'flex flex-wrap mb-3 pl-0',
                    'ais-CurrentRefinements-item':'flex flex-wrap',
                    'ais-CurrentRefinements-category': 'text-sm bg-gray-600 text-white font-semibold leading-none wor rounded-full py-2 px-3 mr-2 mb-2',
                    'ais-CurrentRefinements-label': 'hidden',                                    
                }"
             />
            </div>

            <sidebar v-cloak>
                <div class="mb-10">
                    <h4 class="font-semibold mb-2">Status</h4>
                    <ais-refinement-list
                        attribute="state.name" 
                        :class-names="{      
                            'ais-RefinementList-list': 'pl-0',          
                            'ais-RefinementList-item': 'flex justify-between mb-2',
                            'ais-RefinementList-label': 'cursor-pointer', 
                            'ais-RefinementList-count': 'text-sm font-bold text-dg-yellow ml-1'
                        }"
                    />                   
                </div>
                <div class="mb-10">
                    <h4 class="font-semibold mb-2">Bedarf</h4>
                    <ais-refinement-list
                        attribute="categories.name"
                        :class-names="{      
                            'ais-RefinementList-list': 'pl-0',         
                            'ais-RefinementList-item': 'flex justify-between mb-2',
                            'ais-RefinementList-label': 'cursor-pointer', 
                            'ais-RefinementList-count': 'text-sm font-bold text-dg-yellow ml-1'
                        }"
                    />                   
                </div>

                <div class="mb-10">
                    <h4 class="font-semibold mb-2">Bliebte Themen</h4>
                    <ais-refinement-list
                        attribute="tags"
                        :limit="10"
                        show-more
                        :show-more-limit="20"
                        :class-names="{ 
                            'ais-RefinementList-list': 'pl-0',             
                            'ais-RefinementList-item': 'flex justify-between mb-2',
                            'ais-RefinementList-label': 'cursor-pointer', 
                            'ais-RefinementList-count': 'text-sm font-bold text-dg-yellow ml-1',
                            'ais-RefinementList-showMore': 'font-semibold text-gray-600 text-sm hover:text-dg-blue focus:text-dg-blue'
                        }"
                    />            
                </div>  
            </sidebar>  

            <ais-infinite-hits>
                <div slot-scope="{ items, refineNext }">
                    <masonry
                        :cols="{default: 3, 1500:3, 800: 2, 420: 1}"
                        :gutter="{default: '2rem', 700: '15px'}"
                    >                              
                        <need-card                                                 
                            class="mb-5"  
                            v-for="(need, index) in items"
                            :key="index"                           
                            :need="need"
                        ></need-card> 
                    </masonry> 

                    <div class="flex justify-center">
                        <button 
                            class="btn" 
                            @click="refineNext"
                        >
                            Weitere Ergebnisse
                        </button>
                    </div>     
                </div>
            </ais-infinite-hits>            

        </ais-instant-search>
    </search>

   
</div>
  
@endsection