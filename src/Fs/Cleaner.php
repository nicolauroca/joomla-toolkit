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

namespace Nicode\Joomla\Toolkit\Fs;

use DirectoryIterator;
use InvalidArgumentException;
use RuntimeException;

/**
 * Filesystem helpers.
 */
final class Cleaner
{
    private function __construct()
    {
    }

    /**
     * Delete files older than N hours in a directory (non-recursive).
     *
     * @throws InvalidArgumentException
     */
    public static function deleteOldFiles(string $directory, int $hours): int
    {
        if ($hours < 0) {
            throw new InvalidArgumentException('hours must be >= 0');
        }
        if (!is_dir($directory)) {
            throw new InvalidArgumentException("Not a directory: {$directory}");
        }

        $timeLimit = time() - ($hours * 3600);
        $deleted = 0;

        foreach (new DirectoryIterator($directory) as $fileInfo) {
            if ($fileInfo->isDot() || !$fileInfo->isFile()) {
                continue;
            }

            $path = $fileInfo->getPathname();
            $mtime = $fileInfo->getMTime();

            if ($mtime < $timeLimit) {
                if (!@unlink($path)) {
                    // Don't stop the whole cleanup; bubble up only if needed.
                    throw new RuntimeException("Unable to delete file: {$path}");
                }
                $deleted++;
            }
        }

        return $deleted;
    }
}
