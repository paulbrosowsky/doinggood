@if (!auth()->user()->hasVerifiedEmail())    

    <div class="border-2 border-dg-yellow rounded-xl py-3 px-5 mb-5">
        <h4 class="text-lg font-semibold leading-tight text-dg-yellow mb-2">Bitte bestätige deine Email-Adresse</h4>
        @if (session('resent'))
            <div class="text-red-500" role="alert">                
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        <div class="flex flex-col items-center md:flex-row ">
            <p class="flex-1 text-sm text-center text-dg-yellow leading-tight  mb-2 md:text-left md:mr-2">
                Wir haben die eine Email mit Bestätigunglink gesendet. Bitte Überprüfe zuerst deinen Postfach.
            </p>       
        
            <form class="-mb-5" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-yellow">Sende Nochmal</button>.
            </form>
        </div>
        
    </div>
@endif