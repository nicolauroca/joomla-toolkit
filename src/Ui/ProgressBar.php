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

namespace Nicode\Joomla\Toolkit\Ui;

use Nicode\Joomla\Toolkit\Html\Esc;

/**
 * Accessible progress bar.
 *
 * Recommended: load CSS via WebAssetManager:
 *   Assets::register($wa); $wa->useStyle('lib_nicode_joomla_toolkit.progress');
 */
final class ProgressBar
{
    /**
     * @param array{
     *   showValue?: bool,
     *   striped?: bool,
     *   animated?: bool,
     *   rounded?: bool,
     *   srOnly?: bool,
     *   id?: string|null
     * } $opts
     */
    public static function render(string $text = 'Progreso', float $percentage = 0.0, array $opts = []): string
    {
        if (!is_finite($percentage)) {
            $percentage = 0.0;
        }
        $percentage = max(0.0, min(100.0, $percentage));

        $showValue = (bool)($opts['showValue'] ?? false);
        $striped   = (bool)($opts['striped'] ?? false);
        $animated  = (bool)($opts['animated'] ?? false);
        $rounded   = (bool)($opts['rounded'] ?? true);
        $srOnly    = (bool)($opts['srOnly'] ?? false);

        $pctLabel = rtrim(rtrim(number_format($percentage, 2, '.', ''), '0'), '.');
        if ($pctLabel === '') {
            $pctLabel = '0';
        }

        $id = $opts['id'] ?? null;
        if ($id === null || $id === '') {
            // deterministic-ish unique id per request
            static $seq = 0;
            $seq++;
            $id = 'nxpb-' . $seq;
        }

        $clsTrack = ['nxpb-track'];
        $clsFill  = ['nxpb-fill'];

        if ($rounded) { $clsTrack[] = 'nxpb-rounded'; $clsFill[] = 'nxpb-rounded'; }
        if ($striped) { $clsFill[] = 'nxpb-striped'; }
        if ($striped && $animated) { $clsFill[] = 'nxpb-animated'; }

        $labelCls = $srOnly ? 'nxpb-label nxpb-sr-only' : 'nxpb-label';

        $label = Esc::html($text) . ($showValue ? ' — ' . Esc::html($pctLabel) . '%' : '');

        return
            '<div id="' . Esc::attr($id) . '" class="nxpb-wrap">' .
                '<div class="' . Esc::attr($labelCls) . '" id="' . Esc::attr($id) . '-label">' . $label . '</div>' .
                '<div class="' . Esc::attr(implode(' ', $clsTrack)) . '" role="progressbar" aria-labelledby="' . Esc::attr($id) . '-label" aria-valuemin="0" aria-valuemax="100" aria-valuenow="' . Esc::attr($pctLabel) . '">' .
                    '<div class="' . Esc::attr(implode(' ', $clsFill)) . '" style="width:' . Esc::attr((string)$percentage) . '%;"></div>' .
                '</div>' .
            '</div>';
    }
}
