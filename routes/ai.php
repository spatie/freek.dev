<?php

use App\Mcp\Servers\PostsServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/posts', PostsServer::class)
    ->middleware(['auth:sanctum', 'admin', 'throttle:60,1']);
