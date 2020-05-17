<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Domain;

use FaaPz\PDO\Clause\Grouping;
use FaaPz\PDO\Clause\Join;
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;
use FaaPz\PDO\Clause\Conditional;

class PermissionsRepository extends Repository
{
    public function doIHavePermission(int $userId, int $permissionId): bool {
        $result = $this->database->query("SELECT rp.*
            FROM rank_permissions rp
            JOIN users u ON u.id = $userId
            WHERE 
                rp.rank_id = u.rank_id AND 
                rp.permission_id = $permissionId 
                AND rp.inactive=0")->fetchAll();

        $rows = count($result);

        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function userHasPermission(int $userId, int $permissionId): bool
    {
        $result = $this->database->query("SELECT rp.*
            FROM rank_permissions rp
            JOIN users u ON u.id = $userId
            WHERE 
                rp.rank_id = u.rank_id AND 
                rp.permission_id = $permissionId 
                AND rp.inactive=0")->fetchAll();

        $rows = count($result);

        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllPermissionsWithRank(int $rankId): array
    {
        $result = $this->database->query("SELECT 
            permissions.id, 
            permissions.`name`, 
            permissions.group_id,
            IF (
                EXISTS(
                    SELECT * FROM rank_permissions WHERE rank_id = $rankId AND permission_id = permissions.id AND inactive = 0), \"true\", \"false\") 
                    AS rank_has
            FROM permissions
            WHERE inactive= 0;")->fetchAll();

        return $result;
    }

    public function getUserRank(int $userId): int
    {
        $statement = $this->database
            ->select(array("rank_id"))
            ->from("users")
            ->where(new Conditional("id", "=", $userId));

        return $statement->execute()->fetch()["rank_id"];
    }

    public function addPermissionToRank(int $permissionId, int $rankId): void
    {
        if ($this->rankHasPermission($rankId, $permissionId)) return;

        $inactive = $this->database
            ->select(array("inactive"))
            ->from("rank_permissions")
            ->where(new Grouping("AND",
                new Conditional("permission_id", "=", $permissionId),
                new Conditional("rank_id", "=", $rankId)))
            ->execute()
            ->fetch();

        if ($inactive != null) {
            $this->database
                ->update(array("inactive" => 0))
                ->table("rank_permissions")
                ->where(new Grouping("AND",
                    new Conditional("permission_id", "=", $permissionId),
                    new Conditional("rank_id", "=", $rankId)))
                ->execute();

            return;
        }

        $statement = $this->database
            ->insert(array("rank_id" => $rankId, "permission_id" => $permissionId))
            ->into('rank_permissions');

        $statement->execute();
    }

    public function removeAllPermissions(int $rankId): void
    {
        $statement = $this->database
            ->update(array("inactive" => 1))
            ->table("rank_permissions")
            ->where(new Conditional("rank_id", "=", $rankId));

        $statement->execute();
    }

    public function getRankPermissionIds(int $rankId): array
    {
        $statement = $this->database
            ->select(array('permission_id'))
            ->from('rank_permissions')
            ->where(new Grouping("AND",
                new Conditional("rank_id", "=", $rankId),
                new Conditional("inactive", "=", 0)));

        return $statement->execute()->fetchAll();
    }

    public function getAllPermissions(): array
    {
        $statement = $this->database
            ->select(array("permissions.id", "permissions.name", "permissions.group_id"))
            ->from('permissions');

        return $statement->execute()->fetchAll();
    }

    public function getAllPermissionGroups(): array
    {
        $statement = $this->database
            ->select(array("id", "name"))
            ->from("permission_groups");

        return $statement->execute()->fetchAll();
    }

    public function getAllRanks(): array
    {
        $statement = $this->database
            ->select(array("id", "name"))
            ->from("ranks");

        return $statement->execute()->fetchAll();
    }

    public function createNewRank(string $name): int
    {
        $statement = $this->database
            ->insert(array("name" => $name))
            ->into('ranks');

        return intval($statement->execute());
    }

    public function deleteRank(int $rankId): void
    {
        $statement = $this->database
            ->update(array("inactive" => 1))
            ->table('ranks')
            ->where(new Conditional("rank_id", "=", $rankId));

        $statement->execute();
    }

    public function updateRank(int $rankId, array $data): void
    {
        $statement = $this->database
            ->update($data)
            ->table('ranks')
            ->where(new Conditional("id", "=", $rankId));

        $statement->execute();
    }

    public function rankHasPermission(int $rankId, int $permissionId): bool
    {
        $permissions = $this->getRankPermissionIds($rankId);

        for ($i = 0; $i < sizeof($permissions); $i++) {
            if ($permissions[$i]["permission_id"] == $permissionId) {
                return true;
            }
        }

        return false;
    }

    public function getPermissionId(string $route): int
    {
        $statement = $this->database
            ->select(array("id"))
            ->from("permissions")
            ->where(new Conditional("route", "=", $route));

        return $statement->execute()->fetch()["id"];
    }

    public function getRankId(int $id): int
    {
        $statement = $this->database
            ->select(array("rank_id"))
            ->from("users")
            ->where(new Conditional("id", "=", $id));

        return $statement->execute()->fetch()["rank_id"];
    }

}