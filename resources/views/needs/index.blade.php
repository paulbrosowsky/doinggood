@extends('layouts.app')

@section('content')

<div class="mx-5 md:mx-10 lg:mx-32">
    <masonry
        :cols="{default: 3, 1500:3, 800: 2, 420: 1}"
        :gutter="{default: '2rem', 700: '15px'}"
    > 
       
        @foreach ($needs as $need)                       
        
            <a href="{{ route('need', ['need' => $need->id]) }}">
                <need-card             
                    class="mb-5"                             
                    :need="{{$need}}"
                ></need-card>
            </a>
            
        @endforeach

    </masonry> 
</div>
  
@endsection