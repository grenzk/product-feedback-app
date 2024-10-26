<?php

namespace App\Entity;

enum FeedbackCategoryEnum: string
{
  case FEATURE = 'feature';
  case UI = 'ui';
  case UX = 'ux';
  case ENHANCEMENT = 'enhancement';
  case BUG = 'bug';
}
