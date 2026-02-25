<?php

use App\Actions\GenerateOgImageAction;
use Spatie\OgImage\Actions\InjectOgImageFallbackAction;
use Spatie\OgImage\Actions\RenderOgImageScreenshotAction;

return [

    /*
     * The filesystem disk used to store generated OG images.
     */
    'disk' => 'public',

    /*
     * The path within the disk where OG images will be stored.
     */
    'path' => 'og-images',

    /*
     * The dimensions of the generated OG images in pixels.
     */
    'width' => 1200,
    'height' => 630,

    /*
     * The default image format. Supported: "jpeg", "png", "webp".
     */
    'format' => 'jpeg',

    /*
     * The image quality for JPEG and WebP formats (1-100).
     * Set to null to use the driver's default quality.
     */
    'quality' => null,

    /*
     * The query parameter used to trigger OG image preview mode.
     * Appending this parameter to any page URL renders just the
     * template content at the configured dimensions.
     */
    'preview_parameter' => 'ogimage',

    /*
     * The number of seconds that CDNs and browsers may cache the image
     * response from /og-image/{hash}.jpeg.
     * Since image URLs are content-hashed, this is safe to cache aggressively.
     * Set to 0 to disable caching.
     */
    'redirect_cache_max_age' => 60 * 60 * 24,

    /*
     * The maximum number of seconds to wait for a lock when generating
     * an OG image. This prevents concurrent requests from generating
     * the same image simultaneously.
     */
    'lock_timeout' => 60,

    /*
     * The actions used by this package. You can replace any of them with
     * your own class to customize the behavior. Your custom class should
     * extend the default action.
     *
     * Learn more: https://spatie.be/docs/laravel-og-image/v1/advanced-usage/customizing-actions
     */
    'actions' => [
        'generate_og_image' => GenerateOgImageAction::class,
        'inject_og_image_fallback' => InjectOgImageFallbackAction::class,
        'render_og_image_screenshot' => RenderOgImageScreenshotAction::class,
    ],

];
