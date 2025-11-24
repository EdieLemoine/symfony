<?php

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Microsoft;

enum IconSize: string
{
    case XXSmall = 'xxSmall';
    case XSmall = 'xSmall';
    case Small = 'small';
    case Medium = 'medium';
    case Large = 'large';
    case XLarge = 'xLarge';
    case XXLarge = 'xxLarge';
}
