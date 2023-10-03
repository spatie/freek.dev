<?php

namespace App\Enums;

enum LinkStatus: string
{
    case Submitted = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
