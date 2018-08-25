<?php

namespace Freekmurze\GenerateNewsletter;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class GenerateNewsletterTool extends Tool
{
    public function boot()
    {
        Nova::script('generate-newsletter', __DIR__.'/../dist/js/tool.js');
        Nova::style('generate-newsletter', __DIR__.'/../dist/css/tool.css');
    }

    public function renderNavigation()
    {
        return view('generate-newsletter::navigation');
    }
}
