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
 * @template T
 *
 * @param callable():(iterable<T>) $generator
 *
 * @return Interfaces\Deferred<T>
 */
function later(callable $generator): Interfaces\Deferred
{
    return new Deferred($generator());
}

/**
 * @template T
 *
 * @param iterable<T> $iterableOrGenerator
 *
 * @return Interfaces\Deferred<T>
 */
function lazy(iterable $iterableOrGenerator): Interfaces\Deferred
{
    return new Deferred($iterableOrGenerator);
}

/**
 * @template T
 *
 * @param T $input
 *
 * @return Interfaces\Deferred<T>
 */
function now($input): Interfaces\Deferred
{
    return new Immediate($input);
}
