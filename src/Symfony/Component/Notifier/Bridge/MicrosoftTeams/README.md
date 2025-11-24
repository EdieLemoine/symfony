Microsoft Teams Notifier
========================

Provides [Microsoft Teams](https://www.microsoft.com/en/microsoft-365/microsoft-teams/free) integration through Incoming Webhook for Symfony Notifier.


Adaptive Cards
------

For use with Microsoft Teams webhooks. See [Microsoft Teams documentation](https://learn.microsoft.com/en-us/connectors/teams/?tabs=text1,dotnet#when-a-teams-webhook-request-is-received) for more information.

### DSN

```
MICROSOFT_TEAMS_DSN=microsoftteams://your-webhook-url
```

Where
`your-webhook-url` is the full URL of your Incoming Webhook in Microsoft Teams, without the
`https://` prefix. E.g.:

> microsoftteams://default098f6bcd4621d373cade4e832627b4.f6.environment.api.powerplatform.com:443/powerautomate/automations/direct/workflows/098f6bcd4621d373cade4e832627b4f6/triggers/manual/paths/invoke?api-version=1&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=xxXx0-XXX0_XxX0x_xxXXxXxXxxxxXXXXXxXXxx0xXX

### Building an Adaptive Card Message

To create a Microsoft Teams message, use `MicrosoftTeamsWebhookOptions` and pass one or more `AdaptiveCard` instances as options:

```php
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\AdaptiveCard;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\TextBlock;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\FactSet;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\AdaptiveCard\Fact;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\MicrosoftTeamsWebhookOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

$options = new MicrosoftTeamsWebhookOptions([
  new AdaptiveCard(body: [
      new TextBlock(text: 'Hello world!'),
      new FactSet([
          new Fact(title: 'Fact 1', value: 'Value 1'),
          new Fact(title: 'Fact 2', value: 'Value 2'),
      ])
  ])
]);

$this->chatter->send(
    (new ChatMessage('')) // subject is required but ignored when using Adaptive Cards
        ->transport('microsoftteams')
        ->options($options)
);
```

Check the source code in the [`AdaptiveCard` namespace](./AdaptiveCard) for all the available card elements

> Tip: use the [Adaptive Card Designer](https://adaptivecards.microsoft.com/designer.html) to design and preview your cards.

Legacy connectors
------

> Note: This connector uses the legacy MessageCard format, which is being phased out in favor of Adaptive Cards. For more information, read this [Microsoft announcement](https://devblogs.microsoft.com/microsoft365dev/retirement-of-office-365-connectors-within-microsoft-teams/).

### DSN

```
MICROSOFT_TEAMS_DSN=microsoftteams://default/PATH
```

where:
 - `PATH` has the following format: `webhookb2/{uuid}@{uuid}/IncomingWebhook/{id}/{uuid}`

### Adding text to a Message

With a Microsoft Teams, you can use the `ChatMessage` class::

```php
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\MicrosoftTeamsTransport;
use Symfony\Component\Notifier\Message\ChatMessage;

$chatMessage = (new ChatMessage('Contribute To Symfony'))->transport('microsoftteams');
$chatter->send($chatMessage);
```

### Adding Interactions to a Message

With a Microsoft Teams Message, you can use the `MicrosoftTeamsOptions` class
to add [MessageCard options](https://docs.microsoft.com/en-us/outlook/actionable-messages/message-card-reference).

```php
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\Action\ActionCard;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\Action\HttpPostAction;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\Action\Input\DateInput;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\Action\Input\TextInput;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\MicrosoftTeamsOptions;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\MicrosoftTeamsTransport;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\Section\Field\Fact;
use Symfony\Component\Notifier\Bridge\MicrosoftTeams\Section\Section;
use Symfony\Component\Notifier\Message\ChatMessage;

$chatMessage = new ChatMessage('');

// Action elements
$input = new TextInput();
$input->id('input_title');
$input->isMultiline(true)->maxLength(5)->title('In a few words, why would you like to participate?');

$inputDate = new DateInput();
$inputDate->title('Proposed date')->id('input_date');

// Create Microsoft Teams MessageCard
$microsoftTeamsOptions = (new MicrosoftTeamsOptions())
    ->title('Symfony Online Meeting')
    ->text('Symfony Online Meeting are the events where the best developers meet to share experiences...')
    ->summary('Summary')
    ->themeColor('#F4D35E')
    ->section((new Section())
        ->title('Talk about Symfony 5.3 - would you like to join? Please give a shout!')
        ->fact((new Fact())
            ->name('Presenter')
            ->value('Fabien Potencier')
        )
        ->fact((new Fact())
            ->name('Speaker')
            ->value('Patricia Smith')
        )
        ->fact((new Fact())
            ->name('Duration')
            ->value('90 min')
        )
        ->fact((new Fact())
            ->name('Date')
            ->value('TBA')
        )
    )
    ->action((new ActionCard())
        ->name('ActionCard')
        ->input($input)
        ->input($inputDate)
        ->action((new HttpPostAction())
            ->name('Add comment')
            ->target('http://target')
        )
    )
;

// Add the custom options to the chat message and send the message
$chatMessage->options($microsoftTeamsOptions);
$chatter->send($chatMessage);
```

Resources
---------

 * [Contributing](https://symfony.com/doc/current/contributing/index.html)
 * [Report issues](https://github.com/symfony/symfony/issues) and
   [send Pull Requests](https://github.com/symfony/symfony/pulls)
   in the [main Symfony repository](https://github.com/symfony/symfony)
