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

use Later\Deferred;

/**
 * @covers \Later\Deferred
 *
 * @internal
 */
final class DeferredTest extends TestCase
{
    public function testGetFromArray(): void
    {
        $later = new Deferred([
            42,
        ]);

        $this->assertDeferredSame(42, $later);
        $this->assertDeferredSame(42, $later);
    }

    public function testOnlyFirst(): void
    {
        $later = new Deferred([
            42,
            null,
        ]);

        $this->assertDeferredSame(42, $later);
        $this->assertDeferredSame(42, $later);
    }

    public function testOnlyOnce(): void
    {
        $later = new Deferred($this->makeAnswer());

        $this->assertDeferredSame(42, $later);
        $this->assertDeferredSame(42, $later);
    }

    /**
     * @return iterable<int>
     */
    private function makeAnswer(): iterable
    {
        yield 40 + 2;

        $this->fail('Dead code should never be executed');
    }

    public function testGetFromEmptyReturnNull(bool $false = false): void
    {
        $later = new Deferred($this->yieldsNothing($false));

        $this->assertDeferredSame(null, $later);
        $this->assertDeferredSame(null, $later);
    }

    /**
     * @return iterable<int>
     */
    private function yieldsNothing(bool $false = false): iterable
    {
        if ($false) {
            yield 1;
        }
    }
}
