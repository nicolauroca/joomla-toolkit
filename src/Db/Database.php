<?php
/**
 * @package     lib_nicode_joomla_toolkit
 * @copyright   Copyright (C) 2026 Nicolau Roca
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       1.0.0
 */
declare(strict_types=1);

// No direct access
defined('_JEXEC') or die;

namespace Nicode\Joomla\Toolkit\Db;

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;
use Joomla\Database\ParameterType;
use Joomla\Database\Query\QueryInterface;

/**
 * Small DB helper facade.
 *
 * Notes:
 * - Prefer QueryInterface + bound parameters where possible.
 * - Methods throw on DB errors; catch at the call site if you want to enqueue messages/log.
 */
final class Database
{
    private function __construct()
    {
    }

    public static function db(): DatabaseInterface
    {
        /** @var DatabaseInterface $db */
        $db = Factory::getContainer()->get(DatabaseInterface::class);
        return $db;
    }

    /**
     * Set a query and (optionally) bind parameters.
     *
     * @param QueryInterface|string $query
     * @param array<string, array{0:mixed,1:int|null}|mixed> $params
     */
    public static function set(QueryInterface|string $query, array $params = []): DatabaseInterface
    {
        $db = self::db();
        $db->setQuery($query);

        if ($params !== []) {
            self::bind($db, $params);
        }

        return $db;
    }

    /**
     * Bind parameters to the current query.
     *
     * Supported formats:
     *  - ['id' => [123, ParameterType::INTEGER]]
     *  - ['name' => ['foo', ParameterType::STRING]]
     *  - ['raw' => 'value']   (defaults to STRING)
     *
     * @param array<string, array{0:mixed,1:int|null}|mixed> $params
     */
    public static function bind(DatabaseInterface $db, array $params): void
    {
        foreach ($params as $key => $spec) {
            $value = $spec;
            $type  = ParameterType::STRING;

            if (is_array($spec)) {
                $value = $spec[0] ?? null;
                $type  = $spec[1] ?? ParameterType::STRING;
            }

            // Joomla expects named placeholders without ":" in bind() keys.
            $db->bind($key, $value, $type);
        }
    }

    /**
     * Execute a SELECT and return the first column of the first row.
     */
    public static function result(QueryInterface|string $query, array $params = []): mixed
    {
        $db = self::set($query, $params);
        return $db->loadResult();
    }

    /**
     * Execute a SELECT and return an object (or null).
     */
    public static function object(QueryInterface|string $query, array $params = []): ?object
    {
        $db = self::set($query, $params);
        $obj = $db->loadObject();
        return $obj ?: null;
    }

    /**
     * Execute a SELECT and return a list of objects.
     *
     * @return array<int, object>
     */
    public static function objectList(QueryInterface|string $query, array $params = []): array
    {
        $db = self::set($query, $params);
        return $db->loadObjectList() ?: [];
    }

    /**
     * Execute a SELECT and return a list of associative arrays.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function assocList(QueryInterface|string $query, array $params = []): array
    {
        $db = self::set($query, $params);
        return $db->loadAssocList() ?: [];
    }

    /**
     * Execute a non-SELECT query (INSERT/UPDATE/DELETE).
     */
    public static function execute(QueryInterface|string $query, array $params = []): void
    {
        $db = self::set($query, $params);
        $db->execute();
    }

    /**
     * Execute a non-SELECT query and return affected rows.
     */
    public static function affect(QueryInterface|string $query, array $params = []): int
    {
        $db = self::set($query, $params);
        $db->execute();
        return (int) $db->getAffectedRows();
    }

    /**
     * Last insert id (auto increment) on the same connection.
     */
    public static function lastInsertId(): ?int
    {
        $id = self::db()->insertid();
        return $id === null ? null : (int) $id;
    }
}
