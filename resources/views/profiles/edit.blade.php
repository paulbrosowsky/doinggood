@extends('layouts.app')

@section('content')

    <div class="w-full mx-auto md:w-2/3 lg:w-1/2">

        <div class="flex flex-col items-center mt-10">
            <avatar class="mb-10" :user="{{$user}}" size="lg"></avatar>

            <tabs class="w-full">
                <tab name="Benutzerprofil" hash="">
                    
                    <profile-form 
                        :user="{{ $user }}" 
                        :categories="{{ $categories }}" 
                        :tags="{{ $tags }}"
                    ></profile-form>
                    
                </tab>
                <tab name="Benutzerkonto" hash="account">
                    Account
                </tab>
            </tabs>
        </div>

    </div>
    
@endsection