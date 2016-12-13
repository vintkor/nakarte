<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "На карте", // set false to total remove
            'description'  => 'Изменить это в config/seotools.php', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ["Изменить это в config/seotools.php"],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => "Изменить это в config/seotools.php",
            'bing'      => "Изменить это в config/seotools.php",
            'alexa'     => "Изменить это в config/seotools.php",
            'pinterest' => null,
            'yandex'    => "Изменить это в config/seotools.php",
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Over 9000 Thousand!', // set false to total remove
            'description' => 'For those who helped create the Genki Dama', // set false to total remove
            'url'         => false, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
