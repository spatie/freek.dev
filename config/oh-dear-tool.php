<?php

return [

    /*
     * A valid API token for your Oh Dear! account. Instructions on how to get a
     * token can be found on this page: https://ohdear.app/docs/api/authentication
     */
    'api_token' => env('OH_DEAR_API_TOKEN'),

    /*
     * A list of sites you want to display in the tool. Each entry should contain:
     * - `site_id`: you can get this via the api or in the url on the Oh Dear site details
     * - `site_label`: the label for this site to be displayed on the tool
     */
    'sites' => [
        ['site_id' => env('OH_DEAR_SITE_ID'), 'site_label' => env('APP_NAME')],
    ],
];