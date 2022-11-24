<?php

declare(strict_types=1);

namespace App;

use App\DB;

class Todo
{
    const MAX_TITLE_LENGTH = 100;

    public static function add(string $title): void
    {
        $stmt = (new DB())->conn()->prepare(
            "insert into todos(title) value (:title)"
        );
        $stmt->execute([":title" => trim($title)]);
    }

    /** @param array<int> $ids */
    public static function remove(array $ids): void
    {
        $stmt = (new DB())->conn()->prepare(
            "delete from todos where id = :id;"
        );
        foreach ($ids as $id) {
            $stmt->execute([":id" => $id]);
        }
    }

    /** @return array<array<string, string>> */
    public static function getReversedAll(): array
    {
        $stmt = conn()->prepare(
            "select * from todos order by id desc;"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function titleLengthIsVailed(string $title): bool
    {
        return self::MAX_TITLE_LENGTH < mb_strlen(trim($title));
    }

    public static function titleIsNotEmpty(string $title): bool
    {
        return trim($title) === "";
    }
}
