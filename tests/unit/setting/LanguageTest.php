<?php

use lms\feature\setting\persistence\InMemoryUserPreferenceRepository;
use PHPUnit\Framework\TestCase;
use lms\feature\setting\ChangeLanguagehandler;
use lms\feature\signup\persistence\InMemoryDriverRepository;

use Error;
use lms\feature\setting\entities\MaintainerPreference;
use lms\feature\setting\GetCurrentLanguageHandler;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\ThemeVariant;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;

final class LanguageTest extends TestCase
{
    public function testChangingLanguageForAUserWithNoPreferenceSetting_ShouldThrowException()
    {
        $preferences = new InMemoryUserPreferenceRepository([]);
        $drivers = new InMemoryDriverRepository([]);

        $handler = new ChangeLanguagehandler($preferences, $drivers);

        $this->expectException(Error::class);
        $handler->handle(1, LanguageVariant::English);
    }

    public function testChangingLanguageForAUser_ShouldUpdateTheUsersPreference()
    {
        $maintainer = new InMemoryMaintainerRepository([]);
        $maintainer->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new MaintainerPreference(1, 1, ThemeVariant::Dark, LanguageVariant::Indonesia));

        $handler = new ChangeLanguagehandler($preferences, $maintainer);
        $handler->handle(1, LanguageVariant::English);

        $this->assertEquals(LanguageVariant::English, $preferences->get(1)->language);
    }

    public function testWhenChangingLanguageFromEnglishToIndonesiaThenBackToEnglish_ThePreferencedLanguageShouldBeEnglish()
    {
        $maintainer = new InMemoryCentralOfficeRepository([]);
        $maintainer->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new MaintainerPreference(1, 1, ThemeVariant::Dark, LanguageVariant::English));

        $handler = new ChangeLanguagehandler($preferences, $maintainer);
        $handler->handle(1, LanguageVariant::Indonesia);
        $handler->handle(1, LanguageVariant::English);

        $this->assertEquals(LanguageVariant::English, $preferences->get(1)->language);
    }

    public function testGetCurrentLanguage()
    {
        $maintainer = new InMemoryMaintainerRepository([]);
        $maintainer = new InMemoryCentralOfficeRepository([]);
        $maintainer->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new MaintainerPreference(1, 1, ThemeVariant::Dark, LanguageVariant::English));

        $handler = new GetCurrentLanguageHandler($maintainer, $preferences);
        $current = $handler->handle(1);

        $this->assertEquals(LanguageVariant::English, $current);
    }

    public function testGetIndonesian()
    {

        $maintainer = new InMemoryMaintainerRepository([]);

        $maintainer = new InMemoryCentralOfficeRepository([]);
        $maintainer->insert(1, "", "", "");
        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new MaintainerPreference(1, 1, ThemeVariant::Dark, LanguageVariant::Indonesia));

        $handler = new GetCurrentLanguageHandler($maintainer, $preferences);
        $current = $handler->handle(1);

        $this->assertEquals(LanguageVariant::Indonesia, $current);
    }

    public function testGeLanguageFromCentralOffice()
    {
        $central_office = new InMemoryCentralOfficeRepository([]);
        $central_office->insert(1, "", "", "");

        $preferences = new InMemoryUserPreferenceRepository([]);
        $preferences->insert(new MaintainerPreference(1, 1, ThemeVariant::Dark, LanguageVariant::Indonesia));

        $handler = new GetCurrentLanguageHandler($central_office, $preferences);
        $current = $handler->handle(1);

        $this->assertEquals(LanguageVariant::Indonesia, $current);
    }
}
