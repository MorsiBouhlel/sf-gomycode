<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Bridge\FreeMobile\Tests;

use Symfony\Component\Notifier\Bridge\FreeMobile\FreeMobileTransport;
use Symfony\Component\Notifier\Exception\InvalidArgumentException;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Test\TransportTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class FreeMobileTransportTest extends TransportTestCase
{
    public function createTransport(HttpClientInterface $client = null): FreeMobileTransport
    {
        return new FreeMobileTransport('login', 'pass', '0611223344', $client ?? $this->createMock(HttpClientInterface::class));
    }

    public function toStringProvider(): iterable
    {
        yield ['freemobile://smsapi.free-mobile.fr/sendmsg?phone=0611223344', $this->createTransport()];
    }

    public function supportedMessagesProvider(): iterable
    {
        yield [new SmsMessage('0611223344', 'Hello!')];
        yield [new SmsMessage('+33611223344', 'Hello!')];
    }

    public function unsupportedMessagesProvider(): iterable
    {
        yield [new SmsMessage('0699887766', 'Hello!')]; // because this phone number is not configured on the transport!
        yield [new ChatMessage('Hello!')];
        yield [$this->createMock(MessageInterface::class)];
    }

    public function testSmsMessageWithFrom()
    {
        $transport = $this->createTransport();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "Symfony\Component\Notifier\Bridge\FreeMobile\FreeMobileTransport" transport does not support "from" in "Symfony\Component\Notifier\Message\SmsMessage".');

        $transport->send(new SmsMessage('+33611223344', 'test', 'foo'));
    }
}
