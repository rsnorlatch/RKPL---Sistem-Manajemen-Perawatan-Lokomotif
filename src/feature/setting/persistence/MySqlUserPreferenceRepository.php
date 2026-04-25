<?php

namespace lms\feature\setting\persistence;

use Exception;
use lms\feature\setting\entities\CentralOfficePreference;
use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\entities\UserPreference;


use lms\feature\setting\entities\IUserPreferenceRepository;
use lms\feature\setting\entities\MaintainerPreference;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\ThemeVariant;
use mysqli;


enum RolePreference: string
{
    case Driver = "driver_preference";
    case Maintainer = "maintainer_preference";
    case CentralOffice = "central_office_preference";
}

class MySqlUserPreferenceRepository implements IUserPreferenceRepository
{
    private mysqli $db;
    private RolePreference $preference_role;

    public function __construct(mysqli $db, RolePreference $preference_role)
    {
        $this->db = $db;
        $this->preference_role = $preference_role;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->preference_role->value}");
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        return $row["count"];
    }

    public function insert(UserPreference $preference): void
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->preference_role->value} (id, user_id, theme, language) VALUES (?, ?, ?, ?)");

        // this operation exists because you cannot pass enum's value directly as it is a readonly values 
        // while the bind param requires a non-readonly values
        $theme_string = "" . $preference->theme->value;
        $language_string = "" . $preference->language->value;
        $stmt->bind_param("iiss", $preference->id, $preference->user_id, $theme_string, $language_string);
        $stmt->execute();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->preference_role->value} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        if (!$row) {
            return null;
        }

        switch ($this->preference_role) {
            case RolePreference::Driver:
                return new DriverPreference(
                    $row["id"],
                    $row["user_id"],
                    $row["theme"] == "Light" ? ThemeVariant::Light : ThemeVariant::Dark,
                    $row["language"] == "Indonesia" ? LanguageVariant::Indonesia : LanguageVariant::English
                );
                break;

            case RolePreference::Maintainer:
                return new MaintainerPreference(
                    $row["id"],
                    $row["user_id"],
                    $row["theme"] == "Light" ? ThemeVariant::Light : ThemeVariant::Dark,
                    $row["language"] == "Indonesia" ? LanguageVariant::Indonesia : LanguageVariant::English
                );
                break;
            case RolePreference::CentralOffice:
                return new CentralOfficePreference(
                    $row["id"],
                    $row["user_id"],
                    $row["theme"] == "Light" ? ThemeVariant::Light : ThemeVariant::Dark,
                    $row["language"] == "Indonesia" ? LanguageVariant::Indonesia : LanguageVariant::English
                );
                break;
        }
    }

    public function getAll(): array
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->preference_role->value}");
        $stmt->execute();

        $result = $stmt->get_result();

        $preference = [];
        while ($row = $result->fetch_assoc()) {
            $theme = $row["theme"] == "Light" ? ThemeVariant::Light : ThemeVariant::Dark;
            $language = $row["language"] == "Indonesia" ? LanguageVariant::Indonesia : LanguageVariant::English;
            $preference[] =
                $this->preference_role == RolePreference::Driver ? new DriverPreference($row["id"], $row["user_id"], $theme, $language)
                : ($this->preference_role == RolePreference::Maintainer ? new MaintainerPreference($row["id"], $row["user_id"], $theme, $language)
                    : new CentralOfficePreference($row["id"], $row["user_id"], $theme, $language));
        }

        return $preference;
    }

    public function update(UserPreference $preference): void
    {
        if (!$this->get($preference->id))
            throw new Exception("tried to update preference that doesn't exists");

        $stmt = $this->db->prepare("
            UPDATE {$this->preference_role->value} SET
                user_id = ?,
                theme = ?,
                language = ?

            WHERE id = ?
            ");


        $theme = $preference->theme->value . "";
        $language = $preference->language->value . "";
        $stmt->bind_param("issi", $preference->user_id, $theme, $language, $preference->id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->preference_role->value} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
