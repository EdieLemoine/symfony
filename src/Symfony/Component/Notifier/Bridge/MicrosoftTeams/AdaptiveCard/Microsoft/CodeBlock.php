<?php

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Microsoft;

use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\BlockElementHeight;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Element;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ElementInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\FallbackOption;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\HorizontalAlignment;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ItemInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Spacing;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ToggleableItemInterface;

final class CodeBlock extends Element implements ItemInterface, ElementInterface, ToggleableItemInterface
{
    private const TYPE = 'CodeBlock';

    public function __construct(
        public string                               $codeSnippet,
        public ?string                              $language = null,
        public ?HorizontalAlignment                 $horizontalAlignment = null,
        public ElementInterface|FallbackOption|null $fallback = null,
        public ?BlockElementHeight                  $height = null,
        public ?bool                                $separator = null,
        public ?Spacing                             $spacing = null,
    ) {
    }

    public static function make(
        string                               $codeSnippet,
        ?string                              $language = null,
        ?HorizontalAlignment                 $horizontalAlignment = null,
        ElementInterface|FallbackOption|null $fallback = null,
        ?BlockElementHeight                  $height = null,
        ?bool                                $separator = null,
        ?Spacing                             $spacing = null,
    ): self {
        return new self(
            $codeSnippet,
            $language,
            $horizontalAlignment,
            $fallback,
            $height,
            $separator,
            $spacing,
        );
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            array_filter([
                'type'                => self::TYPE,
                'language'            => $this->language,
                'codeSnippet'         => $this->codeSnippet,
                'horizontalAlignment' => $this->horizontalAlignment,
            ], static fn(mixed $value): bool => null !== $value),
        );
    }
}

