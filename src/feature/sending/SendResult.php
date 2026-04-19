<?php

namespace lms\feature\sending;

enum SendResult
{
    case LocomotiveNotFound;
    case DestinationNotFound;
    case Success;
    case DestinationAndLocomotiveNotFound;
}
