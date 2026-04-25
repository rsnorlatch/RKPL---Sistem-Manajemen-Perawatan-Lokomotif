<?php

use lms\feature\setting\entities\CentralOfficePreference;
use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\entities\MaintainerPreference;
use lms\feature\setting\entities\UserPreference;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\persistence\RolePreference;
use lms\feature\setting\ThemeVariant;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use PHPUnit\Framework\TestCase;


final class UserPreferenceIntegrationTest extends TestCase
{
    private MySqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }

    public function testAllCreatedPreference_ShouldBeRetrieveableFromStorage()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $drivers->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Driver);
        $preference->insert(new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));

        $my_preference = $preference->getAll();

        $this->assertEquals([new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia)], $my_preference);
    }

    public function testGettingAPreferenceThatDoesNotExists_ShouldReturnNull()
    {
        $maintainer = new MySqlMaintainerRepository($this->db);
        $maintainer->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Maintainer);

        $my_preference = $preference->get(1);

        $this->assertNull($my_preference);
    }

    public function testCreatedPreference_ShouldBeRetrieveableFromStorage()
    {
        $maintainer = new MySqlMaintainerRepository($this->db);
        $maintainer->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Maintainer);
        $preference->insert(new MaintainerPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));

        $my_preference = $preference->get(1);

        $this->assertEquals(new MaintainerPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia), $my_preference);
    }

    public function testUpdatingAPreferenceThatDoesNotExists_ShouldThrowAnException()
    {
        $central_office = new MySqlCentralOfficeRepository($this->db);
        $central_office->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::CentralOffice);

        $this->expectException(Exception::class);
        $preference->update(new CentralOfficePreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));
    }

    public function testCreatedPreference_ShouldBeUpdateableFromStorage()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $drivers->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Driver);
        $preference->insert(new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));

        $preference->update(new DriverPreference(1, 1, ThemeVariant::Dark, LanguageVariant::English));

        $this->assertEquals(new DriverPreference(1, 1, ThemeVariant::Dark, LanguageVariant::English), $preference->get(1));
    }

    public function testCreatedPreference_ShouldBeDeleteableFromStorage()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $drivers->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Driver);
        $preference->insert(new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));

        $preference->delete(1);

        $this->assertNull($preference->get(1));
    }

    public function testStorageWithOneMember_ShouldBeCountedAsOneMember()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $drivers->insert(1, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Driver);
        $preference->insert(new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));

        $this->assertEquals(1, $preference->count());
    }

    public function testStorageWithTwoMember_ShouldBeCountedAsTwo()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $drivers->insert(1, "", "", "");
        $drivers->insert(2, "", "", "");
        $preference = new MySqlUserPreferenceRepository($this->db, RolePreference::Driver);
        $preference->insert(new DriverPreference(1, 1, ThemeVariant::Light, LanguageVariant::Indonesia));
        $preference->insert(new DriverPreference(2, 2, ThemeVariant::Light, LanguageVariant::Indonesia));

        $this->assertEquals(2, $preference->count());
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
