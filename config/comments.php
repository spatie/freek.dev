<?php

use Spatie\Comments\Notifications\ApprovedCommentNotification;
use Spatie\Comments\Notifications\PendingCommentNotification;
use Spatie\Comments\Actions\SendNotificationsForApprovedCommentAction;
use Spatie\Comments\Actions\RejectCommentAction;
use Spatie\Comments\Actions\ApproveCommentAction;
use Spatie\Comments\Actions\SendNotificationsForPendingCommentAction;
use Spatie\Comments\Actions\ProcessCommentAction;
use Spatie\Comments\Models\Reaction;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\CommentTransformers\MarkdownToHtmlTransformer;
use Spatie\Comments\Models\CommentNotificationSubscription;

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
        MarkdownToHtmlTransformer::class,
    ],

    /*
     * Comments need to be approved before they are shown. You can opt
     * to have all comments to be approved automatically.
     */
    'automatically_approve_all_comments' => true,

    'models' => [
        /*
         * The class that will comment on other things. Typically, this
         * would be a user model.
         */
        'commentator' => null,

        /*
         * The model you want to use as a Comment model. It needs to be or
         * extend the `Spatie\Comments\Models\Comment::class` model.
         */
        'comment' => Comment::class,

        /*
         * The model you want to use as a React model. It needs to be or
         * extend the `Spatie\Comments\Models\Reaction::class` model.
         */
        'reaction' => Reaction::class,

        /*
         * The model you want to use as an opt-out model. It needs to be or
         * extend the `Spatie\Comments\Models\CommentNotificationSubscription::class` model.
         */
        'comment_notification_subscription' => CommentNotificationSubscription::class,
    ],

    'notifications' => [
        /*
         * When somebody creates a comment, a notification will be sent to other persons
         * that commented on the same thing.
         */
        'enabled' => true,

        'notifications' => [
            'pending_comment' => PendingCommentNotification::class,
            'approved_comment' => ApprovedCommentNotification::class,
        ],

        /*
         * Here you can configure the notifications that will be sent via mail.
         */
        'mail' => [
            'from' => [
                'address' => 'info@spatie.be',
                'name' => 'Spatie',
            ],
        ],
    ],

    /*
     * Unless you need fine-grained customisation, you don't need to change
     * these action classes. If you do change any of them, make sure that your class
     * extends the original action class.
     */
    'actions' => [
        'process_comment' => ProcessCommentAction::class,
        'send_notifications_for_pending_comment' => SendNotificationsForPendingCommentAction::class,
        'approve_comment' => ApproveCommentAction::class,
        'reject_comment' => RejectCommentAction::class,
        'send_notifications_for_approved_comment' => SendNotificationsForApprovedCommentAction::class,
    ],
];
