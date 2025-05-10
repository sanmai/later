<?php

/**
 * Copyright 2020 Alexey Kopytko <alexey@kopytko.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace Later;

use Throwable;
use Override;

/**
 * Deferred: a wrapper object.
 *
 * @template T
 * @mixin T
 *
 * @template-implements Interfaces\Deferred<T>
 *
 * @internal
 * @final
 */
class Deferred implements Interfaces\Deferred
{
    /**
     * @var ?iterable<T>
     */
    private ?iterable $input;

    /**
     * @var T
     */
    private $output;

    private ?Throwable $error;

    /**
     * @param iterable<T> $input
     */
    public function __construct(iterable $input)
    {
        $this->input = $input;
        $this->error = null;
    }

    /**
     * @return T
     */
    #[Override]
    public function get()
    {
        if (null !== $this->error) {
            throw $this->error;
        }

        if (null === $this->input) {
            return $this->output;
        }

        try {
            foreach ($this->input as $output) {
                $this->output = $output;

                break;
            }
        } catch (Throwable $e) {
            $this->error = $e;

            throw $e;
        } finally {
            $this->input = null;
        }

        return $this->output;
    }

    /**
     * Forwards the call to the resolved object; PHP throws \Error if the method is missing.
     * MixedMethodCall is suppressed because Psalm cannot infer methods on the generic type.
     *
     * @param array<mixed> $args Forwarded variadic arguments.
     * @psalm-suppress MixedMethodCall
     */
    public function __call(string $name, array $args): mixed
    {
        return $this->get()->{$name}(...$args);
    }

    public function __get(string $name): mixed
    {
        return $this->get()->$name;
    }
}
