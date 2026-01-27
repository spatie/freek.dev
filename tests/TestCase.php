<?php

namespace Tests;

use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private array $globalErrorHandlers = [];

    private array $globalExceptionHandlers = [];

    protected function setUp(): void
    {
        $this->globalErrorHandlers = $this->snapshotErrorHandlers();
        $this->globalExceptionHandlers = $this->snapshotExceptionHandlers();

        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreErrorHandlers();
        $this->restoreExceptionHandlers();

        (fn () => self::$app = null)->bindTo(null, HandleExceptions::class)();
    }

    private function snapshotErrorHandlers(): array
    {
        $handlers = [];

        while (($handler = set_error_handler(fn () => false)) !== null) {
            restore_error_handler();
            $handlers[] = $handler;
            restore_error_handler();
        }
        restore_error_handler();

        foreach (array_reverse($handlers) as $handler) {
            set_error_handler($handler);
        }

        return $handlers;
    }

    private function snapshotExceptionHandlers(): array
    {
        $handlers = [];

        while (($handler = set_exception_handler(fn () => null)) !== null) {
            restore_exception_handler();
            $handlers[] = $handler;
            restore_exception_handler();
        }
        restore_exception_handler();

        foreach (array_reverse($handlers) as $handler) {
            set_exception_handler($handler);
        }

        return $handlers;
    }

    private function restoreErrorHandlers(): void
    {
        while (set_error_handler(fn () => false) !== null) {
            restore_error_handler();
            restore_error_handler();
        }
        restore_error_handler();

        foreach ($this->globalErrorHandlers as $handler) {
            set_error_handler($handler);
        }
    }

    private function restoreExceptionHandlers(): void
    {
        while (set_exception_handler(fn () => null) !== null) {
            restore_exception_handler();
            restore_exception_handler();
        }
        restore_exception_handler();

        foreach ($this->globalExceptionHandlers as $handler) {
            set_exception_handler($handler);
        }
    }
}
