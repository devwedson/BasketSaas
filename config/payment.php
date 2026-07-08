<?php

return [
    'inscription_enabled' => env('PAYMENT_INSCRIPTION_ENABLED', true),
    'inscription_amount' => (float) env('PAYMENT_INSCRIPTION_AMOUNT', 150),
    'inscription_description' => env('PAYMENT_INSCRIPTION_DESCRIPTION', 'Inscrição — Comissão Técnica'),
    'preference_expiration_hours' => (int) env('PAYMENT_PREFERENCE_EXPIRATION_HOURS', 48),
];