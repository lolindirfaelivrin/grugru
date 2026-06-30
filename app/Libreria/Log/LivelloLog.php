<?php

namespace Libreria\Log;

/**
 * Enum che rappresenta i livelli di log standard PSR-3 (RFC 5424).
 */
enum LivelloLog: string
{
    /** Il sistema è inutilizzabile. */
    case EMERGENCY = 'emergenza';

    /** È necessario intervenire immediatamente. */
    case ALERT = 'alert';

    /** Condizioni critiche. */
    case CRITICAL = 'critico';

    /** Condizioni di errore. */
    case ERROR = 'error';

    /** Condizioni di avviso (warning). */
    case WARNING = 'warning';

    /** Condizioni normali ma significative. */
    case NOTICE = 'notice';

    /** Messaggi informativi. */
    case INFO = 'info';

    /** Messaggi di debug. */
    case DEBUG = 'debug';
}