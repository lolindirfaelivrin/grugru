<?php
declare(strict_types=1);

namespace Core\Enum;

enum ChiaviRiservateSession: string
{
    case UltimoAccesso = 'GRUGRU__sess_ultimo_accesso__';
    case CsrfToken = 'GRUGRU__sess_csrf_token__';
    case Autenticato = 'GRUGRU__sess_autenticato__';

    case ChiaveFlash = 'GRUGRU_fl_ash_chia_token__';

    public static function isRiservata(string $chiave): bool
    {
        return \in_array($chiave, array_column(self::cases(), 'value'), true);
    }
}