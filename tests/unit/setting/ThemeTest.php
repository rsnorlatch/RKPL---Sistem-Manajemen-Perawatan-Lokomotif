<?php

use lms\feature\setting\entities\CentralOfficePreference;
use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\entities\MaintainerPreference;
use lms\feature\setting\persistence\InMemoryUserPreferenceRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\setting\ThemeToggleHandler;
use lms\feature\setting\ThemeVariant;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;
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

    public function testTogglingThemeToMaintainersPreference_ShouldToggleTheme()
    {
        $user = new InMemoryDriverRepository([]);
        $user->insert(1, "", "", "");

        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new DriverPreference(1, 1, ThemeVariant::Light));

        $handler = new ThemeToggleHandler($preferences, $user);
        $handler->handle(1);

        $this->assertEquals(ThemeVariant::Dark, $preferences->get(1)->theme);
    }

    public function testTogglingThemeTwice_ShouldNotChangeTheTheme()
    {
        $user = new InMemoryMaintainerRepository([]);
        $user->insert(1, "", "", "");

        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new MaintainerPreference(1, 1, ThemeVariant::Light));

        $handler = new ThemeToggleHandler($preferences, $user);
        $handler->handle(1);
        $handler->handle(1);

        $this->assertEquals(ThemeVariant::Light, $preferences->get(1)->theme);
    }

    public function testTogglingThemeThreeTimes_ShouldChangeToDarkMode()
    {
        $user = new InMemoryCentralOfficeRepository([]);
        $user->insert(1, "", "", "");

        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new CentralOfficePreference(1, 1, ThemeVariant::Light));

        $handler = new ThemeToggleHandler($preferences, $user);
        $handler->handle(1);
        $handler->handle(1);
        $handler->handle(1);

        $this->assertEquals(ThemeVariant::Dark, $preferences->get(1)->theme);
    }
}
