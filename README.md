# Fix install

```php
<?php
// \vendor\doctrine\doctrine-bundle\DependencyInjection\DoctrineExtension.php:873
// Replace
protected function getMappingResourceConfigDirectory(): string
// With
protected function getMappingResourceConfigDirectory(?string $bundleDir = null): string
?>
```

