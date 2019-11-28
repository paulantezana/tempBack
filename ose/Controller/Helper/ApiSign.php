<?php


class ApiSign
{
    private static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
    private static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    private static function sign($msg, $key, $alg = 'SHA256')
    {
        if ($alg != 'SHA256') {
            throw new DomainException('Algorithm not supported');
        }
        $signature = '';
        $success = openssl_sign($msg, $signature, $key, $alg);
        if (!$success) {
            throw new DomainException("OpenSSL unable to sign data");
        } else {
            return $signature;
        }
    }

    private static function verify($msg, $signature, $key, $alg){
        if ($alg != 'SHA256') {
            throw new DomainException('Algorithm not supported');
        }

        $success = openssl_verify($msg, $signature, $key, $alg);
        if ($success === 1) {
            return true;
        } elseif ($success === 0) {
            return false;
        }

        // returns 1 on success, 0 on failure, -1 on error.
        throw new DomainException(
            'OpenSSL error: ' . openssl_error_string()
        );
    }

    function encode($payload, $key, $alg = 'SHA256')
    {
        $segments = array();
        $segments[] = static::urlsafeB64Encode(json_encode($payload));
        $signing_input = implode('.', $segments);

        $signature = static::sign($signing_input, $key, $alg);
        $segments[] = static::urlsafeB64Encode($signature);

        return implode('.', $segments);
    }

    function decode($jwt, $key, array $allowed_algs = array())
    {
//        $timestamp = is_null(static::$timestamp) ? time() : static::$timestamp;

        if (empty($key)) {
            throw new InvalidArgumentException('Key may not be empty');
        }
        $tks = explode('.', $jwt);
        if (count($tks) != 2) {
            throw new UnexpectedValueException('Wrong number of segments');
        }
        list($bodyb64, $cryptob64) = $tks;
        if (null === $payload = json_decode(static::urlsafeB64Decode($bodyb64))) {
            throw new UnexpectedValueException('Invalid claims encoding');
        }
        if (false === ($sig = static::urlsafeB64Decode($cryptob64))) {
            throw new UnexpectedValueException('Invalid signature encoding');
        }

        // Check the signature
        if (!static::verify($bodyb64, $sig, $key, 'SHA256')) {
            throw new Exception('Signature verification failed');
        }

        // Check if the nbf if it is defined. This is the time that the
        // token can actually be used. If it's not yet that time, abort.
//        if (isset($payload->nbf) && $payload->nbf > ($timestamp + static::$leeway)) {
//            throw new BeforeValidException(
//                'Cannot handle token prior to ' . date(DateTime::ISO8601, $payload->nbf)
//            );
//        }
//
//        // Check that this token has been created before 'now'. This prevents
//        // using tokens that have been created for later use (and haven't
//        // correctly used the nbf claim).
//        if (isset($payload->iat) && $payload->iat > ($timestamp + static::$leeway)) {
//            throw new BeforeValidException(
//                'Cannot handle token prior to ' . date(DateTime::ISO8601, $payload->iat)
//            );
//        }
//
//        // Check if this token has expired.
//        if (isset($payload->exp) && ($timestamp - static::$leeway) >= $payload->exp) {
//            throw new ExpiredException('Expired token');
//        }

        return $payload;
    }
}