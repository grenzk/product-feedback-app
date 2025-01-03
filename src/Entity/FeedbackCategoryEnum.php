<?php

namespace App\Entity;

enum FeedbackCategoryEnum: string
{
    case FEATURE = 'Feature';
    case UI = 'UI';
    case UX = 'UX';
    case ENHANCEMENT = 'Enhancement';
    case BUG = 'Bug';
}
