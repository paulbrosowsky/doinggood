<navdrawer 
    :user="{{ json_encode( auth()->user()) }}" 
    :route="{{ json_encode(Route::currentRouteName()) }}"
></navdrawer>

@if (auth()->check())
    <confirm-dialog></confirm-dialog>
    <info-box></info-box>
    <message-form></message-form>
@endif
