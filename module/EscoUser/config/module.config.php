<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/EscoUser/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'EscoUser\Entity' => 'zfcuser_entity'
                ),
            ),
        ),
    ),
);
