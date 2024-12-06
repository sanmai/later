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

/**
 * Deferred: a wrapper object.
 *
 * @template T
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
}
