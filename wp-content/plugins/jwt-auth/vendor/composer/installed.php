<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => 'usefulteam/jwt-auth',
        'dev' => true,
    ),
    'versions' => array(
        'firebase/php-jwt' => array(
            'pretty_version' => 'v6.3.0',
            'version' => '6.3.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../firebase/php-jwt',
            'aliases' => array(),
            'reference' => '018dfc4e1da92ad8a1b90adc4893f476a3b41cb8',
            'dev_requirement' => false,
        ),
        'usefulteam/jwt-auth' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
    ),
);
