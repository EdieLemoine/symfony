<?php

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams;

use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\AdaptiveCard;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;

final class MicrosoftTeamsWebhookOptions implements MessageOptionsInterface
{
    private array $attachments = [];

    public function __construct(
        array                    $adaptiveCards = [],
        private readonly ?string $recipientId = null,
    ) {
        foreach ($adaptiveCards as $item) {
            $this->adaptiveCard($item);
        }
    }

    public function adaptiveCard(AdaptiveCard $adaptiveCard): MicrosoftTeamsWebhookOptions
    {
        $this->attachments[] = [
            'contentType' => 'application/vnd.microsoft.card.adaptive',
            'contentUrl'  => null,
            'content'     => $adaptiveCard->jsonSerialize(),
        ];

        return $this;
    }

    public function getRecipientId(): ?string
    {
        return $this->recipientId;
    }

    public function toArray(): array
    {
        return ['attachments' => $this->attachments];
    }
}

