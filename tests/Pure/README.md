# Pure conversion experiment

This directory contains a subset of freek.dev's test suite converted from Pest to
[Pure](https://github.com/), an experimental PHP testing framework that is not
built on PHPUnit. It exists to answer one question: are the tests faster?

## What was converted

The 8 convertible test files (32 tests). These are the tests that do not rely on
HTTP testing helpers (`get()`, `actingAs()`), which Pure does not yet support.
The conversion is mechanical: the test bodies are byte-for-byte identical, only
the imports changed (`use function Pure\{test, it, expect}`) plus a single
`freekDevLaravel()` call that boots the app and wraps each test in a rolled-back
transaction (the equivalent of `uses(TestCase, RefreshDatabase)` in `Pest.php`).

## How it runs

Pure boots the real Laravel application from `bootstrap/app.php`, gives each
parallel worker its own already-migrated database (`freekdev_test_test_{n}`), and
wraps every test in a transaction. Workers are forked from a warm parent process.

```bash
# from the freek.dev root, pointing at the Pure binary in its workspace
php /path/to/pure/bin/pure \
    --path=$(pwd) \
    --dir=tests/Pure \
    --bootstrap=tests/Pure/_bootstrap.php
```

Add `--workers=1` to run serially, `--format=json` for machine-readable output.

## Result (identical 32 tests, best of 3, wall clock)

|          | Pest   | Pure   |
| -------- | ------ | ------ |
| serial   | 1.12 s | 0.72 s |
| parallel | 1.96 s | 0.40 s |

Pure is faster in both modes. The parallel gap is the interesting part: Pest
(via ParaTest) spawns fresh PHP processes that each re-bootstrap Laravel, so for
a small suite of fast tests that overhead makes the parallel run slower than
serial. Pure forks workers from an already-warm parent, so parallelism stays
cheap and wins.

## Caveats

- 32-test subset, not the full suite. HTTP/`$this`/Mockery-heavy tests were not
  converted (Pure does not yet have those affordances).
- Both reboot the Laravel app per test and use MySQL with transaction rollback,
  so this is an apples-to-apples comparison of the runners, not the database.
- The Pure conversion omits the `ray()->newScreen()` debug call from the
  project's `Pest.php` `beforeEach`.
