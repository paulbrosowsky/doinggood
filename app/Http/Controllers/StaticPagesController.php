<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StaticPagesController extends Controller
{
    /**
     * Show Imprint
     *
     * @return view
     */
    public function imprint()
    {
        $response = Http::get('https://doinggoodchallenge.de/wp-json/community/api/impressum');
        $content = $response->successful() ? nl2br($response->json()) : null;
    
        return view('static-pages.imprint', compact('content'));
    }

    /**
     * Show Privacy
     *
     * @return view
     */
    public function privacy()
    {
        $response = Http::get('https://doinggoodchallenge.de/wp-json/community/api/datenschutz');
        $content = $response->successful() ? nl2br($response->json()) : null;

        return view('static-pages.privacy', compact('content'));
    }

    /**
     * Show Terms
     *
     * @return view
     */
    public function terms()
    {
        return view('static-pages.terms');
    }

    /**
     * Show FAG
     *
     * @return view
     */
    public function faq()
    {
        return view('static-pages.faq');
    }
}
