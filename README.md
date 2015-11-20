# CloudFlare API Client

## Install

```bash
composer require abdala/cloudflare-client
```

## Usage 

```php
<?php
$client = new CloudFlare\Client([
    'version' => '4',
    'key' => 'your key',
    'email' => 'email@domain.com'
]);
echo $client->listZones();
```

## License

MIT