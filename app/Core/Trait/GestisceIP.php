<?php
declare(strict_types=1);

namespace Core\Trait;

trait GestisceIP
{

    /**
     * Recupera l'indirizzo IP del client.
     * Controlla vari header nel caso in cui l'utente si trovi dietro un proxy (es. Cloudflare, Nginx).
     *
     * @return string|null Ritorna l'IP valido o null se non trovato.
     */
    private function ottieniIP(): ?string
    {
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                // X-Forwarded-For può restituire una lista di IP (es: "client_ip, proxy_ip1, proxy_ip2")
                $ipList = explode(',', $_SERVER[$header]);

                foreach ($ipList as $ip) {
                    $ip = trim($ip);

                    // Valida che sia un IP formalmente corretto
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Anonimizza un indirizzo IP per conformità GDPR.
     * - IPv4: azzera l'ultimo ottetto (es. 192.168.1.130 -> 192.168.1.0)
     * - IPv6: mantiene solo i primi 64 bit (es. 2001:db8:85a3:8d3:1319:8a2e:370:7348 -> 2001:db8:85a3:8d3::)
     *
     * @param string $ip L'indirizzo IP da anonimizzare.
     * @return string L'indirizzo IP anonimizzato.
     */
    private function ipAnonimizzato(string $ip): string
    {
        // Gestione IPv4
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return preg_replace('/(?<=\.)[^.]*$/', '0', $ip);
        }

        // Gestione IPv6
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $packed = inet_pton($ip);
            if ($packed === false) {
                return $ip; // Fallback se l'IP non è formattato correttamente
            }

            // Maschera i primi 8 byte (/64) e azzera i restanti 8 byte
            $masked = substr($packed, 0, 8) . str_repeat(chr(0), 8);
            return inet_ntop($masked);
        }

        // Ritorna l'IP originale se non è né IPv4 né IPv6 valido
        return $ip;
    }
}