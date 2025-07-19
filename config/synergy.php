<?php

return [
    // Full WSDL endpoint for the Synergy Wholesale API
    'api_url' => env('SYNERGY_API_URL', 'https://api.synergywholesale.com/server.php?wsdl'),

    'reseller_id' => env('SYNERGY_RESELLER_ID', ''),
    'api_key' => env('SYNERGY_API_KEY', ''),
];
