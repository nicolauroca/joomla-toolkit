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

namespace Nicode\Joomla\Toolkit\Util;

/**
 * Array utilities.
 */
final class Arr
{
    private function __construct()
    {
    }

    /**
     * Filter a list of arrays by a key/value match (strict comparison).
     *
     * @param array<int, array<string, mixed>> $array
     * @return array<int, array<string, mixed>>
     */
    public static function filterByKeyValue(array $array, string $key, mixed $keyValue): array
    {
        return array_values(array_filter(
            $array,
            static function ($row) use ($key, $keyValue): bool {
                return is_array($row) && array_key_exists($key, $row) && $row[$key] === $keyValue;
            }
        ));
    }
}
