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
 * An object which is need of a result of expensive calculation.
 */
final class HyperIntelligentMice
{
    /** @var Deferred<DeepThought> */
    private $supercomputer;

    public function __construct(DeepThought $deepThought)
    {
        $this->supercomputer = lazy(self::updateDeepThought($deepThought));
    }

    /** @return iterable<DeepThought> */
    private static function updateDeepThought(DeepThought $deepThought): iterable
    {
        $deepThought->solveTheQuestion();

        yield $deepThought;
    }

    public function getAnswer(): int
    {
        return $this->supercomputer->get()->getAnswer();
    }
}
