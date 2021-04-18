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
        $response = Http::get(config('doinggood.wp_api.url') .'/impressum?token='. config('doinggood.wp_api.token'));

        $content = NULL;
        if ($response->successful() && $response->json() != '"Token ist falsch, oder nicht gesetzt"') {
            $content = nl2br($response->json());
        }
        
        return view('static-pages.imprint', compact('content'));
    }

    /**
     * Show Privacy
     *
     * @return view
     */
    public function privacy()
    {
        $response = Http::get(config('doinggood.wp_api.url') .'/datenschutz?token='. config('doinggood.wp_api.token'));

        $content = NULL;
        if ($response->successful() && $response->json() != '"Token ist falsch, oder nicht gesetzt"') {
            $content = nl2br($response->json());
        }

        return view('static-pages.privacy', compact('content'));
    }

    /**
     * Show Terms
     *
     * @return view
     */
    public function terms()
    {
        $response = Http::get(config('doinggood.wp_api.url') .'/nutzungsbedingungen?token='. config('doinggood.wp_api.token'));

        $content = NULL;
        if ($response->successful() && $response->json() != '"Token ist falsch, oder nicht gesetzt"') {
            $content = nl2br($response->json());
        }

        return view('static-pages.terms', compact('content'));
    }

    /**
     * Show FAG
     *
     * @return view
     */
    public function about()
    {
        $response = Http::get(config('doinggood.wp_api.url') .'/ueber-uns?token='. config('doinggood.wp_api.token'));

        $content = NULL;
        if ($response->successful() && $response->json() != '"Token ist falsch, oder nicht gesetzt"') {
            $content = nl2br($response->json());
        }

        return view('static-pages.about', compact('content'));
    }
}
