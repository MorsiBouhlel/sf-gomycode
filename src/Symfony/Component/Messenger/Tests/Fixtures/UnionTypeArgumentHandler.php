<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Messenger\Tests\Fixtures;

class UnionTypeArgumentHandler
{
    public function __invoke(ChildDummyMessage|DummyMessage $message): void
    {
    }
}
