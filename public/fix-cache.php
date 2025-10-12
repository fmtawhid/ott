<?php

// Run only once, then delete this file for security reasons!

echo "<pre>";

passthru('php artisan config:clear');
passthru('php artisan cache:clear');
passthru('php artisan route:clear');
passthru('php artisan view:clear');

echo "✅ All cache cleared and storage link created.\n";

echo "</pre>";
