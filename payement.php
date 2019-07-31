<?php

    require 'vendor/autoload.php';
    $ids = require('paypal.php');

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            $ids['id'],
            $ids['secret']
        )

    );

    $payement = new \PayPal\Api\Payement();
    $payement->create($apiContext);

    var_dump($payement);