<?php
return [
    'Recaptcha' => [
        // Register API keys at https://www.google.com/recaptcha/admin
        'siteKey' => 'goodkey',
        'secret' => 'goodsecret',
        // reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
        'defaultLang' => 'en',
        // either light or dark
        'defaultTheme' => 'light',
        // either image or audio
        'defaultType' => 'image',
    ]
];
