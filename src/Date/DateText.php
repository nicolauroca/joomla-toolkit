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

namespace Nicode\Joomla\Toolkit\Date;

use DateTime;
use InvalidArgumentException;

/**
 * Date text helpers.
 */
final class DateText
{
    private function __construct()
    {
    }

    /**
     * Spanish human-readable date range:
     * - del 3 al 6 de febrero de 2026
     * - del 28 de febrero al 2 de marzo de 2026
     * - del 30 de diciembre de 2025 al 2 de enero de 2026
     *
     * Input dates must be parseable by DateTime (e.g. YYYY-MM-DD).
     */
    public static function rangoFechasTexto(string $inicio, string $fin): string
    {
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
        ];

        try {
            $d1 = new DateTime($inicio);
            $d2 = new DateTime($fin);
        } catch (\Throwable $e) {
            throw new InvalidArgumentException('Fecha inválida para rangoFechasTexto()', 0, $e);
        }

        $dia1  = (int) $d1->format('j');
        $dia2  = (int) $d2->format('j');
        $mes1  = (int) $d1->format('n');
        $mes2  = (int) $d2->format('n');
        $anyo1 = (int) $d1->format('Y');
        $anyo2 = (int) $d2->format('Y');

        if ($anyo1 === $anyo2 && $mes1 === $mes2) {
            return sprintf('del %d al %d de %s de %d', $dia1, $dia2, $meses[$mes1], $anyo1);
        }

        if ($anyo1 === $anyo2) {
            return sprintf('del %d de %s al %d de %s de %d', $dia1, $meses[$mes1], $dia2, $meses[$mes2], $anyo1);
        }

        return sprintf('del %d de %s de %d al %d de %s de %d', $dia1, $meses[$mes1], $anyo1, $dia2, $meses[$mes2], $anyo2);
    }
}
