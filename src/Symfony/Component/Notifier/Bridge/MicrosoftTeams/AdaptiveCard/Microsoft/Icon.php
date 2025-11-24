<?php

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Microsoft;

use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Element;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ElementInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ItemInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ToggleableItemInterface;

final class Icon extends Element implements ItemInterface, ElementInterface, ToggleableItemInterface
{
    private const TYPE = 'Icon';

    public function __construct(
        public string     $name,
        public ?IconSize  $size = null,
        public ?string    $style = null,
        public ?IconColor $color = null,
    ) {
    }

    public static function make(string $name, ?string $size = null, ?string $style = null, ?string $color = null): self
    {
        return new self($name, $size, $style, $color);
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            array_filter([
                'type'  => self::TYPE,
                'name'  => $this->name,
                'size'  => $this->size?->value,
                'style' => $this->style,
                'color' => $this->color?->value,
            ], static fn(mixed $value): bool => null !== $value),
        );
    }
}
