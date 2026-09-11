<?php

declare(strict_types=1);

/**
 * Builder interface.
 *
 * Declares every construction step needed to put a calling card
 * together, plus getCard() to retrieve the finished product.
 * Every method returns $this so steps can be chained.
 */
interface CallingCardBuilder
{
    public function reset(): static;

    public function buildCanvas(): static;

    public function buildCardBase(): static;

    public function buildAccentBar(): static;

    public function buildBusinessName(string $businessName): static;

    public function buildPersonName(string $firstName, string $lastName): static;

    public function buildPosition(string $position): static;

    public function buildDivider(): static;

    public function buildContactInfo(string $email, string $phone, string $address): static;

    public function buildWebsite(string $website): static;

    public function getCard(): CallingCard;
}
