<navdrawer 
    :user="{{ json_encode( auth()->user()) }}" 
    :route="{{ json_encode(Route::currentRouteName()) }}"
></navdrawer>
<confirm-dialog><confirm-dialog>