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

namespace Nicode\Joomla\Toolkit;

use Joomla\CMS\WebAsset\WebAssetManager;

/**
 * WebAssetManager integration helpers.
 */
final class Assets
{
    private const REGISTRY_FILE = 'media/lib_nicode_joomla_toolkit/joomla.asset.json';

    private function __construct()
    {
    }

    /**
     * Register the library web assets (CSS/JS) with Joomla's WebAssetManager.
     *
     * Joomla loads assets from templates/components automatically only in some cases.
     * Calling this is safe (idempotent).
     *
     * @see https://docs.joomla.org/J4.x:Web_Assets
     */
    public static function register(WebAssetManager $wa): void
    {
        $wa->getRegistry()->addRegistryFile(self::REGISTRY_FILE);
    }
}
