@extends('layouts.app')

@section('content')

    <div class="w-full mx-auto md:w-2/3 lg:w-1/2">

        <section class="mt-10">

            <div class="flex flex-col items-center px-5">
                <avatar :user="{{$user}}" size="lg"></avatar>
            
                <div class="mt-5 mb-2"> 
                    @if ($user->helper)
                        <p class="text-dg-yellow text-xs leading-none text-right">Helfer</p>
                    @endif                
                    <h2 class=" text-2xl font-semibold leading-tight"> {{$user->name}}</h2>
                </div>

                <div class="flex mb-5">
                    @if ($user->helper)
                        <div class="text-center mr-5">
                            <h1 class="text-4xl font-light leading-tight ">12</h1>
                            <div class="text-xs text-gray-500 leading-none">
                                <p>aktive</p>
                                <p>Hilfen</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="text-4xl font-light leading-tight">6</h1>
                            <div class="text-xs text-gray-500 leading-none">
                                <p>abgeschl.</p>
                                <p>Hilfen</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center mr-5">
                            <h1 class="text-4xl font-light leading-none">2</h1>
                            <div class="text-xs text-gray-500 leading-none">
                                <p>aktive</p>
                                <p>Bedarfe</p>
                            </div>
                        </div>

                        <div class="text-center">
                            <h1 class="text-4xl font-light leading-none">23</h1>
                            <div class="text-xs text-gray-500 leading-none">
                                <p>abgeschl.</p>
                                <p>Bedarfe</p>
                            </div>
                        </div> 
                    
                    @endif  
                </div>

                <p class="text-center">{{ $user->excerpt }}</p>                
               
                <div class="mt-5">
                    <p class="text-sm text-gray-500 leading-none text-center -mb-1">unsere Themen</p>
                    <tags></tags>  
                </div>        

            </div>

            <div>

            </div>
            
            <div class="w-full mt-10">
                <div class=" container md:rounded-xl">                      
                    @if ($user->helper && !$user->categories->isEmpty())
                        <div class="mb-5">
                            <p class="text-xs text-gray-500 leading-none">wir bitten an</p>
                            <categories :categories="{{$user->categories}}"></categories>
                        </div>
                    @endif  

                    {{-- Location Info --}}
                    <div class="flex items-center mb-5" >
                        <svg class="h-6 fill-current text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 32c-88.004 0-160 70.557-160 156.801C96 306.4 256 480 256 480s160-173.6 160-291.199C416 102.557 344.004 32 256 32zm0 212.801c-31.996 0-57.144-24.645-57.144-56 0-31.357 25.147-56 57.144-56s57.144 24.643 57.144 56c0 31.355-25.148 56-57.144 56z"/></svg>
                        <div >
                            <p class="text-xs text-gray-500 leading-none">Standort</p>
                            <p class="text-lg leading-none">Trier</p>
                        </div>                        
                    </div>
                
                    <p>{{ $user->description}}</p>
                    
                    @if ($user->web_link || $user->facebook_link || $user->instagram_link || $user->tweeter_link)
                        <div>
                            <p class="text-sm text-gray-600 mt-5 mb-1">hier findest du mehr Informationen</p>
                            {{-- Extern Links --}}            
                            <div class="flex">
                                @if ($user->web_link)
                                    <a class="icon-btn" href="{{$user->web_link}}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48C141.124 48 48 141.125 48 256s93.124 208 208 208c114.875 0 208-93.125 208-208S370.875 48 256 48zm-21.549 384.999c-39.464-4.726-75.978-22.392-104.519-50.932C96.258 348.393 77.714 303.622 77.714 256c0-42.87 15.036-83.424 42.601-115.659.71 8.517 2.463 17.648 2.014 24.175-1.64 23.795-3.988 38.687 9.94 58.762 5.426 7.819 6.759 19.028 9.4 28.078 2.583 8.854 12.902 13.498 20.019 18.953 14.359 11.009 28.096 23.805 43.322 33.494 10.049 6.395 16.326 9.576 13.383 21.839-2.367 9.862-3.028 15.937-8.13 24.723-1.557 2.681 5.877 19.918 8.351 22.392 7.498 7.497 14.938 14.375 23.111 21.125 12.671 10.469-1.231 24.072-7.274 39.117zm147.616-50.932c-25.633 25.633-57.699 42.486-92.556 49.081 4.94-12.216 13.736-23.07 21.895-29.362 7.097-5.476 15.986-16.009 19.693-24.352 3.704-8.332 8.611-15.555 13.577-23.217 7.065-10.899-17.419-27.336-25.353-30.781-17.854-7.751-31.294-18.21-47.161-29.375-11.305-7.954-34.257 4.154-47.02-1.417-17.481-7.633-31.883-20.896-47.078-32.339-15.68-11.809-14.922-25.576-14.922-42.997 12.282.453 29.754-3.399 37.908 6.478 2.573 3.117 11.42 17.042 17.342 12.094 4.838-4.043-3.585-20.249-5.212-24.059-5.005-11.715 11.404-16.284 19.803-24.228 10.96-10.364 34.47-26.618 32.612-34.047s-23.524-28.477-36.249-25.193c-1.907.492-18.697 18.097-21.941 20.859.086-5.746.172-11.491.26-17.237.055-3.628-6.768-7.352-6.451-9.692.8-5.914 17.262-16.647 21.357-21.357-2.869-1.793-12.659-10.202-15.622-8.968-7.174 2.99-15.276 5.05-22.45 8.039 0-2.488-.302-4.825-.662-7.133a176.585 176.585 0 0 1 45.31-13.152l14.084 5.66 9.944 11.801 9.924 10.233 8.675 2.795 13.779-12.995L282 87.929V79.59c27.25 3.958 52.984 14.124 75.522 29.8-4.032.361-8.463.954-13.462 1.59-2.065-1.22-4.714-1.774-6.965-2.623 6.531 14.042 13.343 27.89 20.264 41.746 7.393 14.801 23.793 30.677 26.673 46.301 3.394 18.416 1.039 35.144 2.896 56.811 1.788 20.865 23.524 44.572 23.524 44.572s10.037 3.419 18.384 2.228c-7.781 30.783-23.733 59.014-46.769 82.052z"/></svg>
                                    </a>  
                                @endif

                                @if ($user->facebook_link)
                                    <a class="icon-btn" href="{{$user->facebook_link}}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M426.8 64H85.2C73.5 64 64 73.5 64 85.2v341.6c0 11.7 9.5 21.2 21.2 21.2H256V296h-45.9v-56H256v-41.4c0-49.6 34.4-76.6 78.7-76.6 21.2 0 44 1.6 49.3 2.3v51.8h-35.3c-24.1 0-28.7 11.4-28.7 28.2V240h57.4l-7.5 56H320v152h106.8c11.7 0 21.2-9.5 21.2-21.2V85.2c0-11.7-9.5-21.2-21.2-21.2z"/></svg>
                                    </a>  
                                @endif

                                @if ($user->instagram_link)
                                    <a class="icon-btn" href="{{$user->instagram_link}}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M336 96c21.2 0 41.3 8.4 56.5 23.5S416 154.8 416 176v160c0 21.2-8.4 41.3-23.5 56.5S357.2 416 336 416H176c-21.2 0-41.3-8.4-56.5-23.5S96 357.2 96 336V176c0-21.2 8.4-41.3 23.5-56.5S154.8 96 176 96h160m0-32H176c-61.6 0-112 50.4-112 112v160c0 61.6 50.4 112 112 112h160c61.6 0 112-50.4 112-112V176c0-61.6-50.4-112-112-112z"/><path d="M360 176c-13.3 0-24-10.7-24-24s10.7-24 24-24c13.2 0 24 10.7 24 24s-10.8 24-24 24zM256 192c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64m0-32c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96z"/></svg>
                                    </a>  
                                @endif  
                                
                                @if ($user->tweeter_link)
                                    <a class="icon-btn" href="{{$user->tweeter_link}}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492 109.5c-17.4 7.7-36 12.9-55.6 15.3 20-12 35.4-31 42.6-53.6-18.7 11.1-39.4 19.2-61.5 23.5C399.8 75.8 374.6 64 346.8 64c-53.5 0-96.8 43.4-96.8 96.9 0 7.6.8 15 2.5 22.1-80.5-4-151.9-42.6-199.6-101.3-8.3 14.3-13.1 31-13.1 48.7 0 33.6 17.2 63.3 43.2 80.7-16-.4-31-4.8-44-12.1v1.2c0 47 33.4 86.1 77.7 95-8.1 2.2-16.7 3.4-25.5 3.4-6.2 0-12.3-.6-18.2-1.8 12.3 38.5 48.1 66.5 90.5 67.3-33.1 26-74.9 41.5-120.3 41.5-7.8 0-15.5-.5-23.1-1.4C62.8 432 113.7 448 168.3 448 346.6 448 444 300.3 444 172.2c0-4.2-.1-8.4-.3-12.5C462.6 146 479 129 492 109.5z"/></svg>
                                    </a>  
                                @endif                                
                            </div> 
                        </div> 
                    @endif
                                      
               </div>
           </div>    
            
        </section>
      
    </div>
    
@endsection