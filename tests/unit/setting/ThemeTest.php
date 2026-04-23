<?php

use lms\feature\setting\entities\UserPreference;
use lms\feature\setting\persistence\InMemoryUserPreferenceRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\setting\ThemeToggleHandler;
use lms\feature\setting\ThemeVariant;
use PHPUnit\Framework\TestCase;

final class ThemeTest extends TestCase
{
    public function testTogglingThemeToAUserWithoutPreferenceShouldThrowError()
    {
        $this->expectException(Error::class);

        $preferences = new InMemoryUserPreferenceRepository([]);
        $drivers = new InMemoryDriverRepository([]);
        $drivers->insert(1, "", "", "");

        $handler = new ThemeToggleHandler($preferences, $drivers);
        $handler->handle(1);
    }

    public function testItShouldGiveTheCurrentlyActiveTheme()
    {
        $drivers = new InMemoryDriverRepository([]);
        $driver_id = $drivers->count() + 1;
        $drivers->insert($driver_id, "user",  "email", "password");

        $preferences = new InMemoryUserPreferenceRepository([
            new UserPreference(1, $driver_id, ThemeVariant::Light)
        ]);
        $drivers->insert(1, "", "", "");


        $this->assertNotNull($preferences->get(1)->theme);
    }

    public function testUserShouldBeAbleToEnableDarkTheme()
    {
        $drivers = new InMemoryDriverRepository([]);
        $driver_id = $drivers->count() + 1;
        $drivers->insert($driver_id, "user",  "email", "password");

        $preferences = new InMemoryUserPreferenceRepository([
            new UserPreference(1, $driver_id, ThemeVariant::Light)
        ]);

        $handler = new ThemeToggleHandler($preferences, $drivers);
        $handler->handle(1);


        $this->assertEquals(ThemeVariant::Dark, $preferences->get(1)->theme);
    }

    public function testUserSHouldBeAbleToDisableDarkTheme()
    {
        $drivers = new InMemoryDriverRepository([]);
        $driver_id = $drivers->count() + 1;
        $drivers->insert($driver_id, "user",  "email", "password");

        $preferences = new InMemoryUserPreferenceRepository([
            new UserPreference(1, $driver_id, ThemeVariant::Light)
        ]);

        $handler = new ThemeToggleHandler($preferences, $drivers);
        $handler->handle(1);
        $handler->handle(1);


        $this->assertEquals(ThemeVariant::Light, $preferences->get(1)->theme);
    }
}
