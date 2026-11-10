<?php

namespace Tests;

use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    /** @param array<string, mixed> $arguments */
    public function callPostTool(string $name, array $arguments = []): TestResponse
    {
        return $this->postJson('/mcp/posts', [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'tools/call',
            'params' => ['name' => $name, 'arguments' => $arguments],
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        HandleExceptions::flushState($this);
    }
}
