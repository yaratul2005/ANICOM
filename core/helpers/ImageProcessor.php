<?php
namespace Core\Helpers;

class ImageProcessor
{
    /**
     * Process an uploaded image, resize/convert to WebP
     */
    public static function process($file, $destinationDir, $filename = null)
    {
        if (!isset($file['tmp_name']) || !file_exists($file['tmp_name'])) {
            return false;
        }

        $info = getimagesize($file['tmp_name']);
        if (!$info) return false;

        $mime = $info['mime'];
        $extension = 'jpg';
        
        // Favor Webp heavily for SEO/Speed
        if (function_exists('imagewebp')) {
            $extension = 'webp';
        }

        $filename = $filename ? $filename . '.' . $extension : uniqid('prod_') . '.' . $extension;
        $destPath = rtrim($destinationDir, '/') . '/' . $filename;

        // Try GD Pipeline (Shared Hosting Standard)
        if (extension_loaded('gd')) {
            switch ($mime) {
                case 'image/jpeg': $img = imagecreatefromjpeg($file['tmp_name']); break;
                case 'image/png': $img = imagecreatefrompng($file['tmp_name']); break;
                case 'image/gif': $img = imagecreatefromgif($file['tmp_name']); break;
                case 'image/webp': $img = imagecreatefromwebp($file['tmp_name']); break;
                default: return false;
            }

            // Max dimensions 1200px
            $width = imagesx($img);
            $height = imagesy($img);
            if ($width > 1200) {
                $newWidth = 1200;
                $newHeight = (int)($height * (1200 / $width));
                $resized = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($img);
                $img = $resized;
            }

            if ($extension === 'webp') {
                imagewebp($img, $destPath, 85);
            } else {
                imagejpeg($img, $destPath, 85);
            }
            imagedestroy($img);
            return $filename;
        }
        
        // Native fallback wrapper
        $origExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fallbackName = uniqid() . '.' . $origExt;
        if (move_uploaded_file($file['tmp_name'], rtrim($destinationDir, '/') . '/' . $fallbackName)) {
            return $fallbackName;
        }

        return false;
    }
}
