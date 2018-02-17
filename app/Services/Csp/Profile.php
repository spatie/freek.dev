<?php

namespace App\Services\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Profiles\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, "'self'")
            ->addDirective(Directive::FONT, [
                'fonts.gstatic.com',
                '*.bootstrapcdn.com',
            ])
            ->addDirective(Directive::SCRIPT, [
                'murze.be',
                'murze.be.test',
                'srv.carbonads.net',
                'fonts.googleapis.com',
                'script.carbonads.com',
                'cdn.carbonads.com',
                'platform.twitter.com',
                '*.twimg.com',
                '*.bootstrapcdn.com',
                '*.googletagmanager.com',
            ])
            ->addNonceForDirective(Directive::SCRIPT)
            ->addDirective(Directive::STYLE, [
                'murze.be',
                'murze.be.test',
                'fonts.googleapis.com',
                'platform.twitter.com',
                "'unsafe-inline'",
                '*.bootstrapcdn.com',
            ])
            ->addDirective(Directive::FRAME, [
                'platform.twitter.com',
                'syndication.twitter.com',
                '*.youtube.com',
            ])
            ->addDirective(Directive::FORM_ACTION, [
                'murze.be',
                'murze.be.test',
                'platform.twitter.com',
                'syndication.twitter.com',
                'sendy.murze.be',
            ])
            ->addDirective(Directive::IMG, [
                '*',
                "'unsafe-inline'",
                'data:',
            ])
            ->addDirective(Directive::OBJECT, "'none'");
    }
}