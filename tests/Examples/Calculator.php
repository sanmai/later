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

namespace Tests\Later\Examples;

use Later\Interfaces\Deferred;
use function Later\lazy;

/**
 * An object which used to do a lot all at once.
 */
final class Calculator
{
    /** @var Deferred<int> */
    private $lazyDependency;

    public function __construct(int $number)
    {
        $this->lazyDependency = lazy(
            $this->makeDependency($number)
        );
    }

    /** @return iterable<int> */
    private function makeDependency(int $number)
    {
        $factorial = 1;

        for ($i = 1; $i <= $number; ++$i) {
            \usleep(100);
            $factorial = $factorial * $i;
        }

        yield $factorial;
    }

    public function __toString()
    {
        return (string) $this->lazyDependency->get();
    }
}
