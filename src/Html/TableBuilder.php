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

namespace Nicode\Joomla\Toolkit\Html;

use Nicode\Joomla\Toolkit\Html\Esc;

/**
 * Build an HTML table from an associative array list (e.g. DB loadAssocList()).
 *
 * By default this returns only markup. Load CSS via the library asset:
 *   Assets::register($wa); $wa->useStyle('lib_nicode_joomla_toolkit.table');
 */
final class TableBuilder
{
    /**
     * @param array<int, array<string, mixed>>|null $data
     * @param array{
     *   highlighted?: array<int, string>,
     *   headers?: array<string, string>,
     *   id?: string|null,
     *   class?: string,
     *   caption?: string|null,
     *   emptyHtml?: string
     * } $opts
     */
    public static function render(?array $data, array $opts = []): string
    {
        $emptyHtml = (string)($opts['emptyHtml'] ?? '<p class="text-muted mb-0">No hay datos para mostrar.</p>');

        if (empty($data)) {
            return $emptyHtml;
        }

        $firstRow = reset($data);
        if (!is_array($firstRow) || $firstRow === []) {
            return $emptyHtml;
        }

        $headers = array_keys($firstRow);
        $highlighted = array_values($opts['highlighted'] ?? []);
        $headerAliases = $opts['headers'] ?? [];

        $tableId = $opts['id'] ?? null;
        $tableClass = (string)($opts['class'] ?? 'table table-bordered table-hover table-sm align-middle');
        $caption = $opts['caption'] ?? null;

        $tableIdAttr = ($tableId !== null && $tableId !== '') ? ' id="' . Esc::attr($tableId) . '"' : '';

        $html  = '<div class="nx-table-wrap mb-3">';
        if ($caption !== null && $caption !== '') {
            $html .= '<div class="nx-table-caption px-3 pt-3 pb-0"><h6 class="mb-2 fw-semibold">'
                  . Esc::html($caption)
                  . '</h6></div>';
        }

        $html .= '<div class="table-responsive nx-table-scroll">';
        $html .= '<table' . $tableIdAttr . ' class="' . Esc::attr($tableClass) . '">';

        // THEAD
        $html .= '<thead class="sticky-top nx-table-head"><tr>';
        foreach ($headers as $header) {
            $text = $headerAliases[$header] ?? $header;

            $clases = ['small', 'text-nowrap', 'text-uppercase', 'fw-semibold'];
            if (in_array($header, $highlighted, true)) {
                $clases[] = 'nx-highlight';
            }

            $html .= '<th scope="col" class="' . Esc::attr(implode(' ', $clases)) . '">'
                  . Esc::html((string) $text)
                  . '</th>';
        }
        $html .= '</tr></thead>';

        // TBODY
        $html .= '<tbody>';
        foreach ($data as $row) {
            if (!is_array($row)) {
                continue;
            }

            $html .= '<tr>';
            foreach ($headers as $key) {
                $value = $row[$key] ?? '';

                $clases = ['small', 'text-truncate'];
                if (in_array($key, $highlighted, true)) {
                    $clases[] = 'nx-highlight';
                }
                if (is_numeric($value)) {
                    $clases[] = 'text-end';
                }

                $content = self::cellToString($value);
                $esc = Esc::html($content);

                $html .= '<td class="' . Esc::attr(implode(' ', $clases)) . '" title="' . Esc::attr($content) . '">'
                      . $esc
                      . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table></div></div>';

        return $html;
    }

    private static function cellToString(mixed $value): string
    {
        if (is_scalar($value) || $value === null) {
            return (string) $value;
        }

        return (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
