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
 * Immediate: a wrapper object.
 *
 * @template T
 *
 * @template-implements Interfaces\Deferred<T>
 *
 * @internal
 * @final
 */
class Immediate implements Interfaces\Deferred
{
    /**
     * @var T
     */
    private $output;

    /**
     * @param T $input
     */
    public function __construct($input)
    {
        $this->output = $input;
    }

    /**
     * @return T
     */
    public function get()
    {
        return $this->output;
    }
}
