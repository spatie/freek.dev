<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class LazyViewComposer
{
    public function compose(View $view)
    {
        $view->with('usesInternetExplorer', $this->usesInternetExplorer());
    }

    private function usesInternetExplorer(): bool
    {
        if (app()->runningInConsole()) {
            return false;
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (preg_match('~MSIE|Internet Explorer~i', $userAgent)) {
            return true;
        }

        if (strpos($userAgent, 'Trident/7.0; rv:11.0') !== false) {
            return true;
        }

        return false;
    }
}
