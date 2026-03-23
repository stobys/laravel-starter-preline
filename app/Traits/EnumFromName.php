<?php

namespace App\Traits;

trait EnumFromName {

    public static function tryFromName(string $name): ?static
    {
        /** @var ?array<non-empty-string, static> */
        static $cache;

        $cache ??= array_column(static::cases(), null, 'name');

        return $cache[$name] ?? null;
    }

    public static function fromName(string $name): static
    {
        /** @var static */
        return static::tryFromName($name);
    }
}
