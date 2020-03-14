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
use PHPUnit\Framework\TestCase;

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

        $this->assertSame(42, $later->get());
        $this->assertSame(42, $later->get());
    }

    public function testGetAnswerFromArray(): void
    {
        $later = new Deferred([
            42,
        ]);

        $this->assertSame(42, $later->getAnswer());
        $this->assertSame(42, $later->getAnswer());
    }

    public function testOnlyFirst(): void
    {
        $later = new Deferred([
            42,
            null,
        ]);

        $this->assertSame(42, $later->get());
        $this->assertSame(42, $later->get());
    }

    public function testOnlyOnce(): void
    {
        $later = new Deferred($this->makeAnswer());

        $this->assertSame(42, $later->get());
        $this->assertSame(42, $later->get());
    }

    /**
     * @return iterable<int>
     */
    private function makeAnswer(): iterable
    {
        yield 40 + 2;

        $this->fail('Dead code should never be executed');
    }
}
