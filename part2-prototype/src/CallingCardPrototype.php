<?php

declare(strict_types=1);

/**
 * Prototype.
 *
 * Draws every part of the card that stays the same for every student
 * (canvas, card shape, accent bar, business name, position, divider,
 * phone, address, website) exactly once, in the constructor. After
 * that, cloning this object gives an independent copy of that already-
 * drawn image, so each student card is produced by cloning + drawing
 * two lines (name and email) instead of redrawing the whole card.
 */
class CallingCardPrototype
{
    private int $width = 1000;
    private int $height = 600;

    private \GdImage $image;

    private int $black;

    public function __construct(
        private readonly string $businessName,
        private readonly string $position,
        private readonly string $phone,
        private readonly string $address,
        private readonly string $website,
    ) {
        $this->image = imagecreatetruecolor($this->width, $this->height);

        $background = imagecolorallocate($this->image, 245, 247, 250);
        $white      = imagecolorallocate($this->image, 255, 255, 255);
        $this->black = imagecolorallocate($this->image, 30, 30, 30);
        $gray       = imagecolorallocate($this->image, 100, 100, 100);
        $blue       = imagecolorallocate($this->image, 40, 100, 200);

        imagefill($this->image, 0, 0, $background);
        imagefilledrectangle($this->image, 50, 50, 950, 550, $white);
        imagefilledrectangle($this->image, 50, 50, 75, 550, $blue);

        imagestring($this->image, 5, 120, 100, strtoupper($this->businessName), $blue);
        imagestring($this->image, 4, 120, 210, $this->position, $blue);
        imageline($this->image, 120, 260, 880, 260, $gray);

        imagestring($this->image, 4, 120, 365, 'Phone: ' . $this->phone, $this->black);
        imagestring($this->image, 4, 120, 420, 'Address: ' . $this->address, $this->black);
        imagestring($this->image, 3, 120, 485, $this->website, $gray);
    }

    /**
     * Deep-copies the underlying GD image so the clone can be drawn on
     * without touching the original prototype (or any other clone).
     * GdImage itself can't be cloned directly, so a fresh canvas is
     * created and the prototype's pixels are copied onto it.
     */
    public function __clone(): void
    {
        $copy = imagecreatetruecolor($this->width, $this->height);
        imagecopy($copy, $this->image, 0, 0, 0, 0, $this->width, $this->height);
        $this->image = $copy;
    }

    /**
     * Fills in the student-specific parts (name and email) on this
     * instance. Meant to be called on a clone, not on the master
     * prototype itself.
     */
    public function renderStudent(string $firstName, string $lastName): static
    {
        $name = "$firstName $lastName";
        $email = strtolower("{$lastName}.{$firstName}@auf.edu.ph");

        imagestring($this->image, 5, 120, 170, $name, $this->black);
        imagestring($this->image, 4, 120, 310, 'Email: ' . $email, $this->black);

        return $this;
    }

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
