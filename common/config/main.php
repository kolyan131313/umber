<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'   => 'en-En',
    'components' => [
        'cache'     => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'       => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'formatter' => [
            'dateFormat'        => 'MMM d, Y',
            'decimalSeparator'  => ',',
            'thousandSeparator' => ' ',
            'currencyCode'      => 'USD',
        ],
    ],
];
