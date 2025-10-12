<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver; // 👈 Import GD driver

class OptimizeImages extends Command
{
    protected $signature = 'optimize:images';
    protected $description = 'Recursively compress all images in public/images';

    public function handle()
    {
        $basePath = public_path('images');

        if (!File::exists($basePath)) {
            $this->error("❌ Folder public/images not found.");
            return;
        }

$imageManager = new ImageManager(new Driver());

        $allFiles = File::allFiles($basePath);

        foreach ($allFiles as $file) {
            $path = $file->getPathname();
            $extension = strtolower($file->getExtension());

            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                try {
                    $image = $imageManager->read($path);

                    // Resize to max width 1024 (preserve aspect ratio)
                    if ($image->width() > 1024) {
                        $image = $image->scale(width: 1024);
                    }

                    // Convert and compress
                    if (in_array($extension, ['jpg', 'jpeg'])) {
                        $image = $image->toJpeg(quality: 70);
                    } elseif ($extension === 'png') {
                        $image = $image->toPng(); // PNG compression is automatic
                    }

                    // Save over original
                    $image->save($path);

                    $this->info("✔ Optimized: $path");

                } catch (\Exception $e) {
                    $this->error("Failed: $path ({$e->getMessage()})");
                }
            }
        }

        $this->info("✅ All images in public/images and subfolders have been optimized.");
    }
}
