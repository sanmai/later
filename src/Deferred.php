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

/**
 * Deferred: a wrapper object.
 *
 * @template T
 *
 * @psalm-suppress PropertyNotSetInConstructor
 *
 * @internal
 */
final class Deferred implements Interfaces\Deferred
{
    /**
     * @var ?iterable<T>
     */
    private $input;

    /**
     * @var T
     */
    private $output;

    /**
     * @param iterable<T> $input
     */
    public function __construct(iterable $input)
    {
        $this->input = $input;
    }

    /**
     * @return T
     */
    public function get()
    {
        if (null === $this->input) {
            return $this->output;
        }

        foreach ($this->input as $output) {
            $this->output = $output;

            break;
        }

        $this->input = null;

        return $this->output;
    }

    /**
     * @deprecated
     *
     * @param mixed[] $arguments
     *
     * @return T
     */
    public function __call(string $name = '', array $arguments = [])
    {
        return $this->get();
    }
}
