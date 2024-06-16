<?php

declare(strict_types=1);

namespace App\Enum;

enum PromotionStatus: string
{
    case None = 'None';
    case Basic = 'Basic';
    case Pro = 'Pro';
}
