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

namespace Tests\Later;

use function Later\lazy;

/**
 * @covers \Later\lazy
 *
 * @internal
 */
final class LazyTest extends TestCase
{
    public function testGetFromGenerator(): void
    {
        $later = lazy((static function (): iterable {
            yield 42;
        })());

        $this->assertDeferredSame(42, $later);
        $this->assertDeferredSame(42, $later);
    }

    public function testGetFromArray(): void
    {
        $later = lazy([
            42,
        ]);

        $this->assertDeferredSame(42, $later);
        $this->assertDeferredSame(42, $later);
    }
}
