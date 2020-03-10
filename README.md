[![Latest Stable Version](https://poser.pugx.org/sanmai/later/v/stable)](https://packagist.org/packages/sanmai/later)
[![Build Status](https://travis-ci.org/sanmai/later.svg?branch=master)](https://travis-ci.org/sanmai/later)
![CI](https://github.com/sanmai/later/workflows/CI/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/sanmai/later/badge.svg?branch=master)](https://coveralls.io/github/sanmai/later?branch=master)
[![Mutation testing badge](https://badge.stryker-mutator.io/github.com/sanmai/later/master)](https://infection.github.io/)
[![Type Coverage](https://shepherd.dev/github/sanmai/later/coverage.svg)](https://shepherd.dev/github/sanmai/later)

This rigorously tested fully-typed library just works. It neither defines nor throws any exceptions.

# Install

    composer require sanmai/later

The latest version requires PHP 7.1 or greater.

# Use 

To use this pattern you need a generator, yielding a single item of type you want to produce lazily. For example:

```php
$deepThoughtMaker = function () {
    $deepThought = new DeepThought();
    $deepThought->solveTheQuestion();

    yield $deepThought;
})
```

Now you pass it to `later()`:

```php
$deferredMaker = later($deepThoughtMaker);
```

And when you want to use it, you call `get()` and use it:

```php
$deferredMaker->get()->getAnswer(); // 42
$deferredMaker->get()->getAnswer(); // same 42
```

The generator guarantees it will be executed only once.

# Discussion

The library is completely typed. 

To exploit this capability it is recommended to add a convenience method, returning the object itself:

```php
class DeepThought
{
    public function solveTheQuestion(): void
    {
        // Takes 7½ million years to compute
    }

    public function getAnswer(): int
    {
        return 42;
    }

    /**
     * Convenience method. Can be called just get(), getThis(), or anything you'd like.
     */
    public function getSupercomputer(): self
    {
        return $this;
    }
}
```

Then, in a consumer, declare a variable holding this object as union `DeepThought|Deferred<DeepThought>`: 

```php
final class HyperIntelligentMice
{
    /** @var DeepThought|Deferred<DeepThought> */
    private $supercomputer;

    public function __construct(DeepThought $deepThought)
    {
        $this->supercomputer = later(static function () use ($deepThought): iterable {
            $deepThought->solveTheQuestion();

            yield $deepThought;
        });
    }

    public function getAnswer(): int
    {
        return $this->supercomputer->getSupercomputer()->getAnswer();
    }
}
```

In this case a static analyzer will understand what is called and what is returned. 
