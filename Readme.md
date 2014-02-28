# Catalol API client

### Example

```php
$client = new \Catalol\Client(new \Buzz\Browser(), 'catalol.test', 'af783c9323de');
$product = $client->getEbayProduct(360871121943);

$product->getName();
$product->getSeller();
$product->getPrice();
```
