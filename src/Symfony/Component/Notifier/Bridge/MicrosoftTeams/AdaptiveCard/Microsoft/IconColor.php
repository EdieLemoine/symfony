<?php

declare(strict_types=1);

namespace Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Microsoft;

enum IconColor: string
{
    case Dark = 'dark';
    case Light = 'light';
    case Accent = 'accent';
    case Good = 'good';
    case Warning = 'warning';
    case Attention = 'attention';
}
