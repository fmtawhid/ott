<?php
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

if (!file_exists($link)) {
    symlink($target, $link);
    echo "Storage link created!";
} else {
    echo "Link already exists!";
}
