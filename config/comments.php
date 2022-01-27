<?php


use Spatie\Comments\Notifications\NewCommentNotification;

return [
    /*
     * These are the reactions that can be made on a comment. We highly recommend
     * only enabling positive ones for getting good vibes in your community.
     */
    'allowed_reactions' => ['👍', '🥳', '👀', '😍', '💅'],

    'allow_anonymous_comments' => false,

    /*
     * A comment transformer is a class that will transform the comment text
     * for example from Markdown to HTML
     */
    'comment_transformers' => [
        Spatie\Comments\CommentTransformers\MarkdownToHtmlTransformer::class,
    ],

    'models' => [
        /*
         * The model you want to use as a Comment model. It needs to be or
         * extend the `Spatie\Comments\Models\Comment::class` model.
         */
        'comment' => Spatie\Comments\Models\Comment::class,

        /*
         * The model you want to use as a React model. It needs to be or
         * extend the `Spatie\Comments\Models\Reaction::class` model.
         */
        'reaction' => Spatie\Comments\Models\Reaction::class,

        /*
         * The model you want to use as an opt-out model. It needs to be or
         * extend the `Spatie\Comments\Models\CommentNotificationOptOut::class` model.
         */
        'comment_notification_opt_out' => Spatie\Comments\Models\CommentNotificationOptOut::class,

        /*
         * The class that will comment on other things. Typically, this
         * would be a user model.
         */
        'commentator' => App\Models\User::class,
    ],

    'notifications' => [
        'enabled' => true,

        'notifications' => [
            'new_comment' => NewCommentNotification::class,
        ],

        'mail' => [
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],
    ],

    'actions' => [
        /*
         * This class is responsible for storing the input of the user as a comment.
         *
         * Unless you need fine-grained customisation, you don't need to change
         * this class. If you do change it, make sure that your class
         * extends `Spatie\Comments\Actions\ProcessCommentAction`.
         */
        'process_comment' => Spatie\Comments\Actions\ProcessCommentAction::class,

        /*
         * This class is responsible for send out notifications for new comments.
         */
        'send_notifications_for_new_comment' => Spatie\Comments\Actions\SendNotificationsForNewCommentAction::class,
    ],
];
