<?php

declare(strict_types=1);

/**
 * Product.
 *
 * This is the finished object that a builder assembles piece by piece.
 * It only knows how to hold the finished GD image and save it to disk;
 * it has no idea how that image was drawn.
 */
class CallingCard
{
    private \GdImage $image;

    public function __construct(\GdImage $image)
    {
        $this->image = $image;
    }

    public function getImage(): \GdImage
    {
        return $this->image;
    }

    /**
     * Saves the card as a PNG inside $outputDirectory and returns the
     * generated file path.
     */
    public function save(string $outputDirectory): string
    {
        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }

        $filename = $outputDirectory . '/calling-card-' . uniqid() . '.png';

        if (!imagepng($this->image, $filename)) {
            throw new \RuntimeException("Could not save image to $filename");
        }

        return $filename;
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }
}
