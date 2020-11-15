<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\Http;

trait HasWPContent {

    public function getContents()
    {
        $url = config('doinggood.wp_api.url') .'/'. $this->url ."?token=". config('doinggood.wp_api.token');

        $response = Http::get($url);

        if ($response->failed()) {
            return $this->defaultContent;
        }

        return $response->json();
    }
}