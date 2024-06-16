<?php

declare(strict_types=1);

namespace App\Enum;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

/**
 * A list of possible conditions for the item.
 *
 * @see https://schema.org/OfferItemCondition
 */
#[ApiResource(
    shortName: 'PromotionStatus',
    operations: [
        new GetCollection(provider: PromotionStatus::class . '::getCases'),
        new Get(provider: PromotionStatus::class . '::getCase'),
    ],
)]

enum PromotionStatus: string
{
    case None = 'None';
    case Basic = 'Basic';
    case Pro = 'Pro';
}
