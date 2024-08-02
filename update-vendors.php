<?php

$filePath = __DIR__ . '/vendor/easycorp/easyadmin-bundle/src/Orm/EntityRepository.php';

$content = file_get_contents($filePath);

$content = str_replace('private function addOrderClause', 'protected function addOrderClause', $content);
$content = str_replace('final class EntityRepository', 'class EntityRepository', $content);

file_put_contents($filePath, $content);

echo "Vendor class updated successfully.\n";
