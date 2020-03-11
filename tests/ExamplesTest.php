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

use PHPUnit\Framework\TestCase;
use Tests\Later\Examples\Calculator;
use Tests\Later\Examples\DeepThought;
use Tests\Later\Examples\HyperIntelligentMice;

/**
 * @coversNothing
 */
final class ExamplesTest extends TestCase
{
    public function testExample(): void
    {
        $deepThought = new DeepThought();

        $mice = new HyperIntelligentMice($deepThought);

        $this->assertSame(42, $mice->getAnswer());
        $this->assertSame(42, $mice->getAnswer());
    }

    public function testMockCalledNever(): void
    {
        $deepThought = $this->createMock(DeepThought::class);

        $deepThought
            ->expects($this->never())
            ->method('solveTheQuestion')
        ;

        new HyperIntelligentMice($deepThought);
    }

    public function testMockCalledOnce(): void
    {
        $deepThought = $this->createMock(DeepThought::class);

        $deepThought
            ->expects($this->once())
            ->method('solveTheQuestion')
        ;

        $deepThought
            ->expects($this->exactly(2))
            ->method('getAnswer')
            ->willReturn(42)
        ;

        $mice = new HyperIntelligentMice($deepThought);

        $this->assertSame(42, $mice->getAnswer());
        $this->assertSame(42, $mice->getAnswer());
    }

    public function testCalculator(): void
    {
        $start = microtime(true);
        $calculator = new Calculator(10);
        $initTime = microtime(true) - $start;

        $start = microtime(true);
        $result = (string) $calculator;
        $calcTime = microtime(true) - $start;

        $this->assertStringStartsWith('3628800', $result);

        $this->assertGreaterThan($initTime, $calcTime);

        $start = microtime(true);
        $result = (string) $calculator;
        $nextCalcTime = microtime(true) - $start;

        $this->assertLessThan($calcTime, $nextCalcTime);
    }
}
