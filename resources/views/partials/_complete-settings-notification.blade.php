<div class="mx-auto mb-10 px-5 lg:w-1/2">
    <div class="border-2 border-dg-blue rounded-xl py-3 px-5 mb-5">
        <h4 class="text-center text-lg font-semibold leading-tight text-dg-blue mb-2 md:text-left">Profil vervollständigen</h4>
        
        <div class="flex flex-col items-center md:flex-row ">
            <p class="flex-1 text-sm text-center text-dg-blue leading-tight mb-3 md:text-left md:mr-2">                
                Suchen Sie nach Unterschatüzung, oder wollen helfen. Teilen Sie uns Bitte mit, was Sie vor haben, indem Sie Ihren Profil verfolständigen. 
            </p> 
            
            <a href="{{route('profile.edit', auth()->user()->username)}}">
                <button class="btn btn-blue">Einstellungen</button>
            </a>                
        
        </div>
        
    </div>
</div>