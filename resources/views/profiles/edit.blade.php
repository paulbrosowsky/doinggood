@extends('layouts.app')

@section('content')

    <div class="w-full mx-auto md:w-2/3 lg:w-1/2">
        <edit-profile
            inline-template
            :user="{{ $user }}" 
            :categories="{{ $categories }}" 
            :tags="{{ $tags }}"
        >
            <div class="flex flex-col items-center mt-10">
                <avatar class="mb-5" :image="avatar" :badge="user.helper" size="lg"></avatar>
                <image-upload                    
                    :url="`/profiles/${user.username}/avatar`"
                    @preview="showPreview"
                    @cancel="removePreview"
                ></image-upload>
    
                <tabs class="w-full mt-10">
                    <tab class="mt-5" name="Benutzerprofil" hash="">
                        
                        <profile-form                             
                            :user="user" 
                            :categories="categories" 
                            :tags="tags"
                        ></profile-form>
                        
                    </tab>
                    <tab name="Benutzerkonto" hash="account">
                        <account-form :user="user"></account-form>
                    </tab>
                </tabs>
            </div>
        </edit-profile>     

    </div>
    
@endsection