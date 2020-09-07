<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    /**
     * Show Imprint
     *
     * @return view
     */
    public function imprint()
    {
        return view('static-pages.imprint');
    }

    /**
     * Show Privacy
     *
     * @return view
     */
    public function privacy()
    {
        return view('static-pages.privacy');
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
