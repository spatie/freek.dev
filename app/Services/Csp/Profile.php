<?php

namespace App\Services\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Profiles\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function configure()
    {
        $this
            ->addGeneralDirectives()
            ->addDirectivesForBootstrap()
            ->addDirectivesForCarbon()
            ->addDirectivesForGoogleFonts()
            ->addDirectivesForGoogleTagManager()
            ->addDirectivesForTwitter()
            ->addDirectivesForYouTube();
    }

    public function addGeneralDirectives(): self
    {
        return $this->addDirective(Directive::BASE, "'self'")
            ->addNonceForDirective(Directive::SCRIPT)
            ->addDirective(Directive::SCRIPT, [
                'murze.be',
                'murze.be.test',
            ])
            ->addDirective(Directive::STYLE, [
                'murze.be',
                'murze.be.test',
                "'unsafe-inline'",
            ])
            ->addDirective(Directive::FORM_ACTION, [
                'murze.be',
                'murze.be.test',
                'sendy.murze.be',
            ])
            ->addDirective(Directive::IMG, [
                '*',
                "'unsafe-inline'",
                'data:',
            ])
            ->addDirective(Directive::OBJECT, "'none'");
    }

    protected function addDirectivesForBootstrap(): self
    {
        return $this
            ->addDirective(Directive::FONT, ['*.bootstrapcdn.com'])
            ->addDirective(Directive::SCRIPT, ['*.bootstrapcdn.com'])
            ->addDirective(Directive::STYLE, ['*.bootstrapcdn.com']);
    }

    public function addDirectivesForCarbon(): self
    {
        return $this
            ->addDirective(Directive::SCRIPT, [
                'srv.carbonads.net',
                'script.carbonads.com',
                'cdn.carbonads.com',
            ]);
    }

    protected function addDirectivesForGoogleFonts(): self
    {
        return $this
            ->addDirective(Directive::FONT, ['fonts.gstatic.com'])
            ->addDirective(Directive::SCRIPT, ['fonts.googleapis.com'])
            ->addDirective(Directive::STYLE, ['fonts.googleapis.com']);
    }

    public function addDirectivesForGoogleTagManager(): self
    {
        return $this->addDirective(Directive::SCRIPT, ['*.googletagmanager.com']);
    }

    public function addDirectivesForTwitter(): self
    {
        return $this
            ->addDirective(Directive::SCRIPT, [
                'platform.twitter.com',
                '*.twimg.com',
            ])
            ->addDirective(Directive::STYLE, [
                'platform.twitter.com',
            ])
            ->addDirective(Directive::FRAME, [
                'platform.twitter.com',
                'syndication.twitter.com',
            ])
            ->addDirective(Directive::FORM_ACTION, [
                'platform.twitter.com',
                'syndication.twitter.com',
            ]);
    }

    public function addDirectivesForYouTube(): self
    {
        return $this->addDirective(Directive::FRAME, ['*.youtube.com']);
    }
}