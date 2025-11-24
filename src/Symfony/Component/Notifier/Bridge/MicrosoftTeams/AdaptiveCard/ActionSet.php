<?php

/**
 * This is a generated file, do not modify this by hand.
 */

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard;

use JsonSerializable;

/**
 * Displays a set of actions.
 *
 * @since 1.2
 */
final class ActionSet extends Element implements JsonSerializable, ItemInterface, ElementInterface,
                                                 ToggleableItemInterface
{
    /**
     * Must be `ActionSet`
     *
     * @since 1.2
     */
    private const TYPE = 'ActionSet';

    /**
     * Create a "ActionSet" instance in a single call
     *
     * @param  ActionInterface[] $actions
     */
    public function __construct(
        /**
         * The array of `Action` elements to show.
         *
         * @since 1.2
         */
        public array                         $actions,
        ElementInterface|FallbackOption|null $fallback = null,
        ?BlockElementHeight                  $height = null,
        ?bool                                $separator = null,
        ?Spacing                             $spacing = null,
    ) {
        $this->fallback  = $fallback;
        $this->height    = $height;
        $this->separator = $separator;
        $this->spacing   = $spacing;
    }

    /**
     * Make a "ActionSet" instance in a single call
     *
     * @psalm-api
     *
     * @param  ActionInterface[] $actions
     */
    public static function make(
        array                                $actions,
        ElementInterface|FallbackOption|null $fallback = null,
        ?BlockElementHeight                  $height = null,
        ?bool                                $separator = null,
        ?Spacing                             $spacing = null,
    ): self {
        return new self(
            $actions,
            $fallback,
            $height,
            $separator,
            $spacing,
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
                'type'    => self::TYPE,
                'actions' => $this->actions,
            ],
                /** @psalm-suppress RedundantConditionGivenDocblockType */
                fn(mixed $value): bool => $value !== null),
        );
    }
}
