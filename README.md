# Webhook notifications channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/webhook.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/webhook)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/webhook/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/webhook)
[![StyleCI](https://styleci.io/repos/65685866/shield)](https://styleci.io/repos/65685866)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/9015691f-130d-4fca-8710-72a010abc684.svg?style=flat-square)](https://insight.sensiolabs.com/projects/9015691f-130d-4fca-8710-72a010abc684)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/webhook.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/webhook)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/webhook/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/webhook/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/webhook.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/webhook)

This package makes it easy to send webhooks using the Laravel notification system.

## Compatibility

| Laravel version                                                        | PHP version        | Package version |
|------------------------------------------------------------------------|--------------------|-----------------|
| ^6.0 &#124; ^7.0 &#124; ^8.0 &#124; ^9.0 &#124; ^10.0                  | ^7.2.5 &#124; ^8.0 | ^2.4            |
| ^6.0 &#124; ^7.0 &#124; ^8.0 &#124; ^9.0                               | ^7.2.5 &#124; ^8.0 | ^2.3            |
| ^6.0 &#124; ^7.0 &#124; ^8.0                                           | ^7.2.5 &#124; ^8.0 | ^2.2            |
| ^6.0 &#124; ^7.0 &#124; ^8.0                                           | ^7.2.5             | ^2.1            |
| ~5.5 &#124; ~6.0 &#124; ~7.0                                           | &gt;=7.2.5         | ^2.0            |
| ~5.5 &#124; ~6.0                                                       | &gt;=7.0           | ^1.3            |
| 5.1.* &#124; 5.2.* &#124; 5.3.* &#124; 5.4.* &#124; 5.5.* &#124; 5.6.* | &gt;=5.6.4         | ^1.2            |
| 5.1.* &#124; 5.2.* &#124; 5.3.* &#124; 5.4.* &#124; 5.5.*              | &gt;=5.6.4         | ^1.1            |
| 5.1.* &#124; 5.2.* &#124; 5.3.* &#124; 5.4.*                           | &gt;=5.6.4         | ^1.0.2          |
| 5.1.* &#124; 5.2.* &#124; 5.3.*                                        | &gt;=5.6.4         | ^1.0.0          |

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

This method needs to return the URL where the notification Webhook will receive a POST request.

```php
public function routeNotificationForWebhook()
{
    return 'http://requestb.in/1234x';
}
```

### Available methods

- `data('')`: Accepts a JSON-encodable value for the Webhook body.
- `query('')`: Accepts an associative array of query string values to add to the request.
- `userAgent('')`: Accepts a string value for the Webhook user agent.
- `header($name, $value)`: Sets additional headers to send with the POST Webhook.
- `verify()`: Enable the SSL certificate verification or provide the path to a CA bundle

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email atymicq@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
