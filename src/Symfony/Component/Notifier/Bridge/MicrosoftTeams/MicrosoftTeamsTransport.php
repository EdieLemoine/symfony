<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams;

use JsonException;
use Symfony\Component\Notifier\Exception\TransportException;
use Symfony\Component\Notifier\Exception\UnsupportedMessageTypeException;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\Notifier\Transport\AbstractTransport;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Edouard Lescot <edouard.lescot@gmail.com>
 * @author Oskar Stark <oskarstark@googlemail.com>
 */
final class MicrosoftTeamsTransport extends AbstractTransport
{
    private const DSN_PREFIX = 'microsoftteams';

    public function __construct(
        private string $path,
        private array  $options = [],
        ?HttpClientInterface $client = null,
        ?EventDispatcherInterface $dispatcher = null,
    ) {
        parent::__construct($client, $dispatcher);
    }

    public function __toString(): string
    {
        return sprintf('%s://%s%s%s', self::DSN_PREFIX, $this->getEndpoint(), $this->path, $this->createQueryString());
    }

    public function supports(MessageInterface $message): bool
    {
        return $message instanceof ChatMessage
            && (null === $message->getOptions()
                || $message->getOptions() instanceof MicrosoftTeamsOptions
                || $message->getOptions() instanceof MicrosoftTeamsWebhookOptions);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function doSend(MessageInterface $message): SentMessage
    {
        if (!$message instanceof ChatMessage) {
            throw new UnsupportedMessageTypeException(__CLASS__, ChatMessage::class, $message);
        }

        $options = $message->getOptions();

        if ($options instanceof MicrosoftTeamsOptions) {
            return $this->sendLegacyMessage($message, $options);
        }

        return $this->sendMessage($message, $options);
    }

    private function createQueryString(): string
    {
        if (empty($this->options)) {
            return '';
        }

        return '?' . http_build_query($this->options);
    }

    /**
     * @see https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/connectors-using#post-a-message-to-the-webhook-using-curl
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function sendLegacyMessage(ChatMessage $message, ?MessageOptionsInterface $options): SentMessage
    {
        $json = $options?->toArray() ?? [];
        $json['codeSnippet'] ??= $message->getSubject();

        $path = $message->getRecipientId() ?? $this->path;
        $endpoint = sprintf('https://%s%s', $this->getEndpoint(), $path);
        $response = $this->client->request('POST', $endpoint, ['json' => $json]);

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new TransportException('Could not reach the remote MicrosoftTeams server.', $response, 0, $e);
        }

        $requestId = $response->getHeaders(false)['request-id'][0] ?? null;

        if ($options instanceof MicrosoftTeamsOptions && null === $requestId) {
            $originalContent = $message->getSubject();

            throw new TransportException(
                sprintf('Unable to post the Microsoft Teams message: "%s" (request-id not found).', $originalContent),
                $response,
            );
        }

        if (200 !== $statusCode) {
            $errorMessage = $response->getContent(false);
            $originalContent = $message->getSubject();

            throw new TransportException(
                sprintf(
                    'Unable to post the Microsoft Teams message: "%s" (%s: "%s").',
                    $originalContent,
                    $requestId ?? 'none',
                    $errorMessage,
                ), $response,
            );
        }

        $responseMessage = new SentMessage($message, (string)$this);
        $responseMessage->setMessageId($requestId);

        return $responseMessage;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    private function sendMessage(ChatMessage $message, ?MessageOptionsInterface $options): SentMessage
    {
        $json = $options?->toArray() ?? [];
        $endpoint = str_replace(self::DSN_PREFIX, 'https', (string)$this);

        try {
            $response = $this->client->request('POST', $endpoint, ['json' => $json]);
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new TransportException('Could not reach the remote MicrosoftTeams server.', $response ?? null, 0, $e);
        }

        if (202 !== $statusCode) {
            $errorResponse = $response->getContent(false);
            $originalContent = $message->getSubject();
            $decoded = json_decode($errorResponse, true, 512, JSON_THROW_ON_ERROR);
            $error = $decoded['error'] ?? null;

            if ($error) {
                $errorText = json_encode($error, JSON_THROW_ON_ERROR);
            } else {
                $errorText = $errorResponse;
            }

            throw new TransportException(
                sprintf(
                    'Failed to post Microsoft Teams message: "%s". Response code: %s. Error: %s',
                    $originalContent,
                    $statusCode,
                    $errorText,
                ), $response,
            );
        }

        $responseMessage = new SentMessage($message, (string)$this);
        $responseMessage->setMessageId((string)$statusCode);

        return $responseMessage;
    }
}
