<?php

namespace lms\feature\setting\entities;

use lms\feature\setting\ThemeVariant;

class UserPreference
{
    public int $id;
    public int $user_id;
    public ThemeVariant $theme;

    public function __construct(int $id, int $user_id, ThemeVariant $theme = ThemeVariant::Light)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->theme = $theme;
    }
}
