<?php

namespace App\Entity;

enum FeedbackStatusEnum: string
{
    case SUGGESTION = 'Suggestion';
    case PLANNED = 'Planned';
    case IN_PROGRESS = 'In-Progress';
    case LIVE = 'Live';
}
