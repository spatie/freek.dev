# Pure conversion experiment

The **entire** freek.dev test suite converted from Pest to [Pure](https://github.com/),
an experimental PHP testing framework that is not built on PHPUnit. It exists to
answer one question: are the tests faster?

## What was converted

All 164 tests (162 passing, 2 skipped), the same as the Pest suite. The test
bodies are unchanged: HTTP tests still call `get('/archive')->assertOk()`, tests
still use `$this->`, Mockery, facade fakes, `assertDatabaseHas`, and so on.
The conversion is mechanical, only the imports differ (`use function Pure\...`
and `use function Pure\Laravel\...` in place of the Pest equivalents). The
shared setup lives in `pure.php` at the project root.

## How it works

Pure drives discovery, scheduling, parallelism and reporting. Each test's `$this`
is bound to a real Laravel `TestCase` (with `RefreshDatabase`), so every Laravel
testing affordance keeps working unchanged. Workers are forked from a warm parent
process, and each parallel worker gets its own database (`freekdev_test_test_{n}`).

## How to run

```bash
# from the freek.dev root, no flags needed (workers default to your CPU count)
php /path/to/pure/bin/pure
```

`--workers=1` runs serially, `--filter=archive` runs a subset, `--format=json`
writes machine-readable output to `.pure/results.json`, `--inventory` lists every
test and its fixtures.

## Result (full suite, 164 tests, best of 3, wall clock)

|          | Pest   | Pure   | speedup |
| -------- | ------ | ------ | ------- |
| serial   | 7.25 s | 5.76 s | ~1.3x   |
| parallel | 3.92 s | 1.86 s | ~2.1x   |

Pure is faster in both modes. The parallel win comes from forking workers from a
warm parent process, where Pest (via ParaTest) spawns fresh PHP processes that
each re-bootstrap Laravel.

## Caveats

- Both run on MySQL with `RefreshDatabase` (migrate once per worker, then a
  transaction per test), so this compares the runners on equal database footing.
- The shared `beforeEach` in `pure.php` omits the `ray()->newScreen()` debug call
  from the project's `Pest.php`.
- Pure is an experiment. This directory mirrors the real suite; the originals
  under `tests/Feature`, `tests/Unit` are untouched.
