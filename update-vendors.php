<?php

$filePath = __DIR__ . '/vendor/easycorp/easyadmin-bundle/src/Orm/EntityRepository.php';

$content = file_get_contents($filePath);

// Use a regular expression to replace 'private function' with 'protected function'
$modifiedContent = preg_replace('/private function addOrderClause/', 'protected function addOrderClause', $content);
$modifiedContent = preg_replace('/final class EntityRepository/', 'class EntityRepository', $content);

file_put_contents($filePath, $modifiedContent);

echo "Vendor class updated successfully.\n";
