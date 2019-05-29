<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Ad
 *
 * @property int $id
 * @property string|null $display_on_url
 * @property string $text
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $excerpt
 * @property-read mixed $formatted_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad current()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereDisplayOnUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 */
    class Ad extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Talk
 *
 * @property int $id
 * @property string $title
 * @property string $location
 * @property \Illuminate\Support\Carbon $presented_at
 * @property string|null $video_link
 * @property string|null $slides_link
 * @property string|null $joindin_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $links
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereJoindinLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk wherePresentedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereSlidesLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Talk whereVideoLink($value)
 */
    class Talk extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $text
 * @property string|null $wp_id
 * @property \Illuminate\Support\Carbon|null $publish_date
 * @property bool $published
 * @property int $tweet_sent
 * @property int $posted_on_medium
 * @property string $author
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $original_content
 * @property string|null $external_url
 * @property-read mixed $emoji
 * @property-read mixed $excerpt
 * @property-read mixed $external_url_host
 * @property-read mixed $formatted_text
 * @property-read mixed $formatted_title
 * @property-read mixed $is_original
 * @property-read mixed $promotional_url
 * @property-read mixed $publish_action
 * @property-read mixed $reading_time
 * @property-read mixed $tags_text
 * @property-read mixed $theme
 * @property-read mixed $url
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post originalContent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post scheduled()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExternalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereOriginalContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePostedOnMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTweetSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereWpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withAnyTagsOfAnyType($tags)
 */
    class Post extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
    class User extends \Eloquent
    {
    }
}

namespace App\Models{
/**
 * App\Models\Redirect
 *
 * @property int $id
 * @property string $old_url
 * @property string $new_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect whereNewUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect whereOldUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redirect whereUpdatedAt($value)
 */
    class Redirect extends \Eloquent
    {
    }
}
