---
name: volt-development
description: >-
  Develops single-file Livewire components with Volt. Activates when creating Volt components,
  converting Livewire to Volt, working with @volt directive, functional or class-based Volt APIs;
  or when the user mentions Volt, single-file components, functional Livewire, or inline component
  logic in Blade files.
---

# Volt Development

## When to Apply

Activate this skill when:

- Creating Volt single-file components
- Converting traditional Livewire components to Volt
- Testing Volt components

## Documentation

Use `search-docs` for detailed Volt patterns and documentation.

## Basic Usage

Create components with `php artisan make:volt [name] [--test] [--pest]`.

Important: Check existing Volt components to determine if they use functional or class-based style before creating new ones.

### Functional Components

<code-snippet name="Volt Functional Component" lang="php">

@@volt
<?php
use function Livewire\Volt\{state, computed};

state(['count' => 0]);

$increment = fn () => $this->count++;
$double = computed(fn () => $this->count * 2);
?>

<div>
    <h1>Count: @{{ $count }} (Double: @{{ $this->double }})</h1>
    <button wire:click="increment">+</button>
</div>
@@endvolt

</code-snippet>

### Class-Based Components

<code-snippet name="Volt Class-based Component" lang="php">

use Livewire\Volt\Component;

new class extends Component {
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }
} ?>

<div>
    <h1>@{{ $count }}</h1>
    <button wire:click="increment">+</button>
</div>

</code-snippet>

## Testing

Tests go in existing Volt test directory or `tests/Feature/Volt`:

<code-snippet name="Volt Test Example" lang="php">

use Livewire\Volt\Volt;

test('counter increments', function () {
    Volt::test('counter')
        ->assertSee('Count: 0')
        ->call('increment')
        ->assertSee('Count: 1');
});

</code-snippet>

## Verification

1. Check existing components for functional vs class-based style
2. Test component with `Volt::test()`

## Common Pitfalls

- Not checking existing style (functional vs class-based) before creating
- Forgetting `@volt` directive wrapper
- Missing `--test` or `--pest` flag when tests are needed