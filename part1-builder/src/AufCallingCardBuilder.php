<?php

declare(strict_types=1);

/**
 * Concrete Builder.
 *
 * Knows how to draw an AUF-styled calling card using the GD library.
 * Each build*() method only adds one visual piece to the canvas, and
 * getCard() hands back the finished CallingCard product.
 */
class AufCallingCardBuilder implements CallingCardBuilder
{
    private int $width = 1000;
    private int $height = 600;

    private \GdImage $image;

    private int $background;
    private int $white;
    private int $black;
    private int $gray;
    private int $blue;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): static
    {
        $this->image = imagecreatetruecolor($this->width, $this->height);

        $this->background = imagecolorallocate($this->image, 245, 247, 250);
        $this->white      = imagecolorallocate($this->image, 255, 255, 255);
        $this->black      = imagecolorallocate($this->image, 30, 30, 30);
        $this->gray       = imagecolorallocate($this->image, 100, 100, 100);
        $this->blue       = imagecolorallocate($this->image, 40, 100, 200);

        return $this;
    }

    public function buildCanvas(): static
    {
        imagefill($this->image, 0, 0, $this->background);

        return $this;
    }

    public function buildCardBase(): static
    {
        imagefilledrectangle($this->image, 50, 50, 950, 550, $this->white);

        return $this;
    }

    public function buildAccentBar(): static
    {
        imagefilledrectangle($this->image, 50, 50, 75, 550, $this->blue);

        return $this;
    }

    public function buildBusinessName(string $businessName): static
    {
        imagestring($this->image, 5, 120, 100, strtoupper($businessName), $this->blue);

        return $this;
    }

    public function buildPersonName(string $firstName, string $lastName): static
    {
        imagestring($this->image, 5, 120, 170, "$firstName $lastName", $this->black);

        return $this;
    }

    public function buildPosition(string $position): static
    {
        imagestring($this->image, 4, 120, 210, $position, $this->blue);

        return $this;
    }

    public function buildDivider(): static
    {
        imageline($this->image, 120, 260, 880, 260, $this->gray);

        return $this;
    }

    public function buildContactInfo(string $email, string $phone, string $address): static
    {
        imagestring($this->image, 4, 120, 310, 'Email: ' . $email, $this->black);
        imagestring($this->image, 4, 120, 365, 'Phone: ' . $phone, $this->black);
        imagestring($this->image, 4, 120, 420, 'Address: ' . $address, $this->black);

        return $this;
    }

    public function buildWebsite(string $website): static
    {
        imagestring($this->image, 3, 120, 485, $website, $this->gray);

        return $this;
    }

    public function getCard(): CallingCard
    {
        $card = new CallingCard($this->image);
        $this->reset();

        return $card;
    }
}
