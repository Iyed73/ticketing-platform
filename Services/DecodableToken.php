<?php
function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function generate_token($payload, $secret = 'secret')
{
    $payload_encoded = base64url_encode(json_encode($payload));
    $signature = hash_hmac('SHA256', $payload_encoded, $secret, true);
    $signature_encoded = base64url_encode($signature);
    $token = "$payload_encoded.$signature_encoded";
    return $token;
}

function decode_token($token, $secret = 'secret')
{
    list($payload_encoded, $signature_encoded) = explode('.', $token);

    // Decode the payload
    $payload = json_decode(base64url_decode($payload_encoded), true);

    // Verify the signature
    $signature = base64url_decode($signature_encoded);
    $expected_signature = hash_hmac('SHA256', $payload_encoded, $secret, true);

    if ($signature !== $expected_signature) {
        throw new Exception('Signature verification failed');
    }

    return $payload;
}
