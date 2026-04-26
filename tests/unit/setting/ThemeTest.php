<?php

use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\exception\UserNotFoundException;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\persistence\InMemoryUserPreferenceRepository;
use lms\feature\setting\ThemeDispatcher;
use lms\feature\setting\ThemeVariant;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use PHPUnit\Framework\TestCase;
use lms\feature\setting\ThemeQuery;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;

final class ThemeTest extends TestCase
{
    public function testUserShouldBeAble_ToSwitchToDarkMode()
    {
        $users = new InMemoryDriverRepository([]);
        $users->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));
        $dispatcher = new ThemeDispatcher($preferences, $users);

        $dispatcher->switch_to_dark_mode(1);

        $this->assertEquals(ThemeVariant::Dark, $preferences->get(1)->theme);
    }

    public function testUserShouldBeAble_ToSwitchToLightMode()
    {
        $users = new InMemoryDriverRepository([]);
        $users->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new DriverPreference(1, 1, ThemeVariant::Dark, LanguageVariant::Indonesia));
        $dispatcher = new ThemeDispatcher($preferences, $users);

        $dispatcher->switch_to_light_mode(1);

        $this->assertEquals(ThemeVariant::Light, $preferences->get(1)->theme);
    }

    public function testRetrieveTheme()
    {
        $users = new InMemoryDriverRepository([]);
        $users->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new DriverPreference(1, 1, ThemeVariant::Dark, LanguageVariant::Indonesia));
        $theme_query = new ThemeQuery($preferences, $users);

        $theme = $theme_query->get_current_theme(1);

        $this->assertEquals(ThemeVariant::Dark, $theme);
    }

    public function testShouldThrowException_WhenUserNotFound()
    {
        $users = new InMemoryDriverRepository([]);
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new DriverPreference(1, 1, ThemeVariant::Dark, LanguageVariant::Indonesia));
        $theme_query = new ThemeQuery($preferences, $users);

        $this->expectException(UserNotFoundException::class);
        $theme_query->get_current_theme(1);
    }

    public function testIfUserHasNoPreference_ItShouldGenerateADefaultPreference()
    {
        $users = new InMemoryCentralOfficeRepository([]);
        $users->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $theme_query = new ThemeQuery($preferences, $users);

        $theme = $theme_query->get_current_theme(1);

        $this->assertEquals(ThemeVariant::Light, $theme);
    }
}
