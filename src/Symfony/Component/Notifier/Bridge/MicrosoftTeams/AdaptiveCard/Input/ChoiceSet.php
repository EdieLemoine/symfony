<?php

/**
 * This is a generated file, do not modify this by hand.
 */

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Input;

use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\BlockElementHeight;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ChoiceInputStyle;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Data\Query;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Default\Input\JsonSerializable;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ElementInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\FallbackOption;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Input;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\InputInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\InputLabelPosition;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\InputStyle;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ItemInterface;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Spacing;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\ToggleableItemInterface;

/**
 * Allows a user to input a Choice.
 *
 * @since 1.0
 */
final class ChoiceSet extends Input implements JsonSerializable, ItemInterface, ElementInterface,
                                               ToggleableItemInterface, InputInterface
{
    /**
     * Must be `Input.ChoiceSet`
     *
     * @since 1.0
     */
    private const TYPE = 'Input.ChoiceSet';

    /**
     * Create a "ChoiceSet" instance in a single call
     *
     * @param  \Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Input\Choice[]|null $choices
     */
    public function __construct(
        string                               $id,
        /**
         * `Choice` options.
         *
         * @since 1.0
         */
        public ?array                        $choices = null,
        /**
         * Allows dynamic fetching of choices from the bot to be displayed as suggestions
         * in the dropdown when the user types in the input field.
         *
         * @since 1.6
         */
        public ?Query                        $choicesData = null,
        /**
         * Allow multiple choices to be selected.
         *
         * @since 1.0
         */
        public ?bool                         $isMultiSelect = null,
        /** @since 1.0 */
        public ?ChoiceInputStyle             $style = null,
        /**
         * The initial choice (or set of choices) that should be selected. For
         * multi-select, specify a comma-separated string of values.
         *
         * @since 1.0
         */
        public ?string                       $value = null,
        /**
         * Description of the input desired. Only visible when no selection has been made,
         * the `style` is `compact` and `isMultiSelect` is `false`
         *
         * @since 1.0
         */
        public ?string                       $placeholder = null,
        /**
         * If `true`, allow text to wrap. Otherwise, text is clipped.
         *
         * @since 1.2
         */
        public ?bool                         $wrap = null,
        ?string                              $errorMessage = null,
        ?bool                                $isRequired = null,
        ?string                              $label = null,
        ?InputLabelPosition                  $labelPosition = null,
        string|int|null                      $labelWidth = null,
        ?InputStyle                          $inputStyle = null,
        ElementInterface|FallbackOption|null $fallback = null,
        ?BlockElementHeight                  $height = null,
        ?bool                                $separator = null,
        ?Spacing                             $spacing = null,
        ?bool                                $isVisible = null,
        object|array|null                    $requires = null,
    ) {
        $this->id            = $id;
        $this->errorMessage  = $errorMessage;
        $this->isRequired    = $isRequired;
        $this->label         = $label;
        $this->labelPosition = $labelPosition;
        $this->labelWidth    = $labelWidth;
        $this->inputStyle    = $inputStyle;
        $this->fallback      = $fallback;
        $this->height        = $height;
        $this->separator     = $separator;
        $this->spacing       = $spacing;
        $this->isVisible     = $isVisible;
        $this->requires      = $requires;
    }

    /**
     * Make a "ChoiceSet" instance in a single call
     *
     * @psalm-api
     *
     * @param  \Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Input\Choice[]|null $choices
     */
    public static function make(
        string                               $id,
        ?array                               $choices = null,
        ?Query                               $choicesData = null,
        ?bool                                $isMultiSelect = null,
        ?ChoiceInputStyle                    $style = null,
        ?string                              $value = null,
        ?string                              $placeholder = null,
        ?bool                                $wrap = null,
        ?string                              $errorMessage = null,
        ?bool                                $isRequired = null,
        ?string                              $label = null,
        ?InputLabelPosition                  $labelPosition = null,
        string|int|null                      $labelWidth = null,
        ?InputStyle                          $inputStyle = null,
        ElementInterface|FallbackOption|null $fallback = null,
        ?BlockElementHeight                  $height = null,
        ?bool                                $separator = null,
        ?Spacing                             $spacing = null,
        ?bool                                $isVisible = null,
        object|array|null                    $requires = null,
    ): self {
        return new self(
            $id,
            $choices,
            $choicesData,
            $isMultiSelect,
            $style,
            $value,
            $placeholder,
            $wrap,
            $errorMessage,
            $isRequired,
            $label,
            $labelPosition,
            $labelWidth,
            $inputStyle,
            $fallback,
            $height,
            $separator,
            $spacing,
            $isVisible,
            $requires,
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
                'type'          => self::TYPE,
                'choices'       => $this->choices,
                'choices.data'  => $this->choicesData,
                'isMultiSelect' => $this->isMultiSelect,
                'style'         => $this->style,
                'value'         => $this->value,
                'placeholder'   => $this->placeholder,
                'wrap'          => $this->wrap,
            ],
                /** @psalm-suppress RedundantConditionGivenDocblockType */
                fn(mixed $value): bool => $value !== null),
        );
    }
}
