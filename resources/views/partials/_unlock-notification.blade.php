@if (!auth()->user()->isUnlocked)
    <div class="border-2 border-dg-blue rounded-xl py-3 px-5 mb-5">
        <h4 class="text-lg font-semibold leading-tight text-dg-blue mb-2">Profil muss freigeschaltet werden</h4>
        
        <div class="flex flex-col items-center md:flex-row ">
            <p class="flex-1 text-sm text-center text-dg-blue leading-tight mb-3 md:text-left md:mr-2">                
                Teile uns bitte mit, was du vor hast, indem du dein Profil vervollständigst.  
                Wir werden dein Benutzerkonto schnellstmöglich freischalten.  
            </p> 
            
            <a href="{{route('profile.edit', auth()->user()->username)}}">
                <button class="btn btn-blue">Einstellungen</button>
            </a>                
        
        </div>
        
    </div>
@endif
   