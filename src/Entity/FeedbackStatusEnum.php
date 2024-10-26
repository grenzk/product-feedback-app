<?php

namespace App\Entity;

enum FeedbackStatusEnum: string
{
  case SUGGESTION = 'suggestion';
  case PLANNED = 'planned';
  case IN_PROGRESS = 'in-progress';
  case LIVE = 'live';
}
