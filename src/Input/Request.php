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

namespace Nicode\Joomla\Toolkit\Input;

use Joomla\CMS\Factory;

/**
 * Request helpers (GET/POST/REQUEST).
 */
final class Request
{
    private function __construct()
    {
    }

    public static function hasGet(string $name): bool
    {
        $input = Factory::getApplication()->getInput();
        return $input->get->get($name, null, 'RAW') !== null;
    }

    public static function get(string $name, string $filter = 'STRING', mixed $default = null): mixed
    {
        $input = Factory::getApplication()->getInput();
        $val = $input->get->get($name, null, $filter);
        return $val !== null ? $val : $default;
    }

    public static function hasPost(string $name): bool
    {
        $input = Factory::getApplication()->getInput();
        return $input->post->get($name, null, 'RAW') !== null;
    }

    public static function post(string $name, string $filter = 'STRING', mixed $default = null): mixed
    {
        $input = Factory::getApplication()->getInput();
        $val = $input->post->get($name, null, $filter);
        return $val !== null ? $val : $default;
    }

    public static function request(string $name, string $filter = 'STRING', mixed $default = null): mixed
    {
        $input = Factory::getApplication()->getInput();
        $val = $input->get($name, null, $filter);
        return $val !== null ? $val : $default;
    }
}
