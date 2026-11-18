<?php

namespace App\Support;

class Photo
{
    public static function find(string $kind, string $slug): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $rel = "images/{$kind}/{$slug}.{$ext}";
            if (file_exists(public_path($rel))) {
                return asset($rel);
            }
        }

        return null;
    }
}
