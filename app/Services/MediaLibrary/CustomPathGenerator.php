<?php

namespace App\Services\MediaLibrary;

use App\Models\NewsletterTestimonial;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;

class CustomPathGenerator implements BasePathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->prefix($media).$this->base($media);
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->prefix($media).$this->base($media).'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->prefix($media).$this->base($media).'responsive-images/';
    }

    protected function base(Media $media): string
    {
        return md5($media->id.config('services.media-library.salt')).'/';
    }

    protected function prefix(Media $media): string
    {
        return match ($media->model_type) {
            NewsletterTestimonial::class => 'avatars/',
            default => '',
        };
    }
}
