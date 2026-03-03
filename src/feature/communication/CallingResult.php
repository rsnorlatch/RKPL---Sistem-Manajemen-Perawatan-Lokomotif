<?php

namespace lms\feature\communication;

enum CallingResult
{
    case Success;
    case LocomotiveNotFound;
    case CallNotFound;
}