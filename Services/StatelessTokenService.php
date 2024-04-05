<?php

/**
 * This is an attempt at implementing a stateless token service like the JWT token. 
 * In real world applications, it is recommended to use a library like Firebase JWT or Symfony JWT.
 */

class JwtService {

    public function encode($payload, $secretKey) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return $jwt;
    }

    public function decode($jwt, $secretKey) {
        $payload = $this->getPayload($jwt);
        if (!$this->validateSignature($jwt, $secretKey)) {
            throw new Exception();
        }
        return $payload;
    }

    public function getPayload($jwt) {
        $arr = explode('.', $jwt);
        if(count($arr) !== 3) {
            return null;
        }
        list($_headerEnc, $payloadEnc, $_signatureEnc) = $arr;
        return json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payloadEnc)), true);
    }

    public function getSignature($jwt) {
        $arr = explode('.', $jwt);
        if(count($arr) !== 3) {
            return null;
        }
        list($_headerEnc, $_payloadEnc, $signatureEnc) = $arr;
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $signatureEnc));
    }

    public function getHeader($jwt) {
        $arr = explode('.', $jwt);
        if(count($arr) !== 3) {
            return null;
        }
        list($headerEnc, $_payloadEnc, $_signatureEnc) = $arr;
        return json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $headerEnc)), true);
    }

    public function validateSignature($jwt, $secretKey) {
        list($headerEnc, $payloadEnc, $_signatureEnc) = explode('.', $jwt);
        $signature = $this->getSignature($jwt);
        $valid = hash_hmac('sha256', $headerEnc . "." . $payloadEnc, $secretKey, true);
        return $signature === $valid;
    }
}

