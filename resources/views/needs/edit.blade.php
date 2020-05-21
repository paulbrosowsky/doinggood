@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto md:w-2/3 lg:w-1/2">
        <need-form
            :need="{{ $need }}"
            :categories="{{ $categories }}" 
            :tags="{{$tags}}"
        ></need-form>        
    </div>    
@endsection