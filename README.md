# Webhook notifications channel for Laravel 5.8

This package makes it easy to send webhooks using the Laravel 5.8 notification system.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/webhook
```

Afterwards, you might want to run `php artisan vendor:publish` afterwards, and configure the base options used by the client internally, as defined [Here](http://docs.guzzlephp.org/en/stable/request-options.html). Most notably, in the original version of this package, SSL was disabled by default. While enabling is a sensible option, if your implemenation does not work with SSL enabled, you may disable it here. Other usecases include defining a default URL, if you're hitting only one webservice with notifications.

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [WebhookChannel::class];
    }

    public function toWebhook($notifiable)
    {
        return WebhookMessage::create()
            ->data([
               'payload' => [
                   'webhook' => 'data'
               ]
            ])
            ->userAgent("Custom-User-Agent")
            ->header('X-Custom', 'Custom-Header');
    }
}
```

In order to let your Notification know which URL should receive the Webhook data, add the `routeNotificationForWebhook` method to your Notifiable model.

This method needs to return a single URL, or an array of URLS, where the notification Webhook will receive a POST request.

```php
public function routeNotificationForWebhook()
{
    return 'http://requestb.in/1234x';
}
```

### Available methods

- `data('')`: Accepts a JSON-encodable value for the Webhook body.
- `userAgent('')`: Accepts a string value for the Webhook user agent.
- `header($name, $value)`: Sets additional headers to send with the POST Webhook.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email m.pociot@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [Niels Mokkenstorm](https://github.com/nmokkenstorm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
