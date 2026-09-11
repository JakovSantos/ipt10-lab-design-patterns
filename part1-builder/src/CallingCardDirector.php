<?php

declare(strict_types=1);

/**
 * Director.
 *
 * Knows the correct order to call the builder's steps in to produce a
 * standard AUF calling card. The client just hands it a builder and a
 * bag of student data; it doesn't need to know the drawing order itself.
 */
class CallingCardDirector
{
    public function buildStandardCard(CallingCardBuilder $builder, array $data): CallingCard
    {
        $builder->reset()
            ->buildCanvas()
            ->buildCardBase()
            ->buildAccentBar()
            ->buildBusinessName($data['businessName'])
            ->buildPersonName($data['firstName'], $data['lastName'])
            ->buildPosition($data['position'])
            ->buildDivider()
            ->buildContactInfo($data['email'], $data['phone'], $data['address'])
            ->buildWebsite($data['website']);

        return $builder->getCard();
    }
}
