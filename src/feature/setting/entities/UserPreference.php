<?php

namespace lms\feature\setting\entities;

use lms\feature\setting\ThemeVariant;
use lms\feature\setting\LanguageVariant;

class UserPreference
{
    public int $id;
    public int $user_id;
    public ThemeVariant $theme;
    public LanguageVariant $language;

    public function __construct(
        int $id,
        int $user_id,
        ThemeVariant $theme,
        LanguageVariant $language
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->theme = $theme ?? ThemeVariant::Light;
        $this->language = $language ?? LanguageVariant::Indonesia;
    }
}
