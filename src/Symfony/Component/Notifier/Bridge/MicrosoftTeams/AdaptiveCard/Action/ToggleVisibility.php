<?php

/**
 * This is a generated file, do not modify this by hand.
 */

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Action;

use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Action;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ActionInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ActionMode;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ActionStyle;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Default\Action\JsonSerializable;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\FallbackOption;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ISelectActionInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ItemInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\TargetElement;

/**
 * An action that toggles the visibility of associated card elements.
 *
 * @since 1.2
 */
final class ToggleVisibility extends Action implements JsonSerializable, ActionInterface, ItemInterface,
                                                       ISelectActionInterface
{
    /**
     * Must be `Action.ToggleVisibility`
     *
     * @since 1.2
     */
    private const TYPE = 'Action.ToggleVisibility';

    /**
     * Create a "ToggleVisibility" instance in a single call
     *
     * @param  TargetElement[] $targetElements
     */
    public function __construct(
        /**
         * The array of TargetElements. It is not recommended to include Input elements
         * with validation under Action.Toggle due to confusion that can arise from invalid
         * inputs that are not currently visible. See
         * https://docs.microsoft.com/en-us/adaptive-cards/authoring-cards/input-validation
         * for more information.
         *
         * @since 1.2
         */
        public array                        $targetElements,
        ?string                             $title = null,
        ?string                             $iconUrl = null,
        ?string                             $id = null,
        ?ActionStyle                        $style = null,
        ActionInterface|FallbackOption|null $fallback = null,
        ?string                             $tooltip = null,
        ?bool                               $isEnabled = null,
        ?ActionMode                         $mode = null,
    ) {
        $this->title     = $title;
        $this->iconUrl   = $iconUrl;
        $this->id        = $id;
        $this->style     = $style;
        $this->fallback  = $fallback;
        $this->tooltip   = $tooltip;
        $this->isEnabled = $isEnabled;
        $this->mode      = $mode;
    }

    /**
     * Make a "ToggleVisibility" instance in a single call
     *
     * @psalm-api
     *
     * @param  TargetElement[] $targetElements
     */
    public static function make(
        array                               $targetElements,
        ?string                             $title = null,
        ?string                             $iconUrl = null,
        ?string                             $id = null,
        ?ActionStyle                        $style = null,
        ActionInterface|FallbackOption|null $fallback = null,
        ?string                             $tooltip = null,
        ?bool                               $isEnabled = null,
        ?ActionMode                         $mode = null,
    ): self {
        return new self(
            $targetElements,
            $title,
            $iconUrl,
            $id,
            $style,
            $fallback,
            $tooltip,
            $isEnabled,
            $mode,
        );
    }

    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            array_filter([
                'type'           => self::TYPE,
                'targetElements' => $this->targetElements,
            ],
                /** @psalm-suppress RedundantConditionGivenDocblockType */
                fn(mixed $value): bool => $value !== null),
        );
    }
}
