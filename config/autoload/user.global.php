<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\\DBAL\\Driver\\PDOMySql\\Driver',
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'generate_proxies' => false,
                'metadata_cache' => 'apc',
                'query_cache' => 'apc',
                'result_cache' => 'apc',
            ),
        ),
        'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => __DIR__ . '/../../data/migrations',
                'name' => 'ORM Default Migrations',
                'namespace' => 'GoodyearCalendarMigrations',
                'table' => 'doctrine_migration_versions',
            ),
        ),
    ),
    'zfcuser' => array(
        'user_entity_class'         => 'EscoUser\Entity\User',
        'enable_default_entities'   => false,
        'enable_registration'       => false,
        'auth_adapters' => array(
            100 => 'ZfcUser\Authentication\Adapter\Db',
        ),
        'user_login_widget_view_template' => 'zfc-user/user/login',
        'enable_user_state'               => true,
        'default_user_state'              => 0,
        'allowed_login_states'            => array(1),
        'login_redirect_route'            => 'home',
        'logout_redirect_route'           => 'home',
    ),
    'service_manager' => array(
        'aliases' => array(
            'zfcuser_doctrine_em'                       => 'doctrine.entitymanager.orm_default',
            'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
        ),
    ),
    'zfc_rbac' => [
        /**
         * Key that is used to fetch the identity provider
         *
         * Please note that when an identity is found, it MUST implements the ZfcRbac\Identity\IdentityProviderInterface
         * interface, otherwise it will throw an exception.
         */
//         'identity_provider' => 'zfcuser_auth_service',

        /**
         * Set the guest role
         *
         * This role is used by the authorization service when the authentication service returns no identity
         */
         'guest_role' => 'guest',

        /**
         * Set the guards
         *
         * You must comply with the various options of guards. The format must be of the following format:
         *
         *      'guards' => [
         *          'ZfcRbac\Guard\RouteGuard' => [
         *              // options
         *          ]
         *      ]
         */
         'guards' => [
             'ZfcRbac\Guard\RouteGuard' => [
                'home'   => ['guest', 'user'],
                'zfcuser'   => ['guest'],
                'zfcuser/logout'   => ['user'],
                'zfcuser/login'   => ['guest'],
                 //Doctrine Module CLI
//                'doctrine_cli' => ['guest'],
            ]
         ],

        /**
         * As soon as one rule for either route or controller is specified, a guard will be automatically
         * created and will start to hook into the MVC loop.
         *
         * If the protection policy is set to DENY, then any route/controller will be denied by
         * default UNLESS it is explicitly added as a rule. On the other hand, if it is set to ALLOW, then
         * not specified route/controller will be implicitly approved.
         *
         * DENY is the most secure way, but it is more work for the developer
         */
         'protection_policy' => \ZfcRbac\Guard\GuardInterface::POLICY_DENY,

        /**
         * Configuration for role provider
         *
         * It must be an array that contains configuration for the role provider. The provider config
         * must follow the following format:
         *
         *      'ZfcRbac\Role\InMemoryRoleProvider' => [
         *          'role1' => [
         *              'children'    => ['children1', 'children2'], // OPTIONAL
         *              'permissions' => ['edit', 'read'] // OPTIONAL
         *          ]
         *      ]
         *
         * Supported options depend of the role provider, so please refer to the official documentation
         */
        'role_provider' => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager'     => 'doctrine.entitymanager.orm_default',
                'class_name'         => 'EscoUser\Entity\Role',
                'role_name_property' => 'name'
            ]
        ],

        /**
         * Configure the unauthorized strategy. It is used to render a template whenever a user is unauthorized
         */
        'unauthorized_strategy' => [
            /**
             * Set the template name to render
             */
//             'template' => 'error/403'
        ],

        /**
         * Configure the redirect strategy. It is used to redirect the user to another route when a user is
         * unauthorized
         */
        'redirect_strategy' => [
            /**
             * Set the route to redirect when user is connected (of course, it must exist!)
             */
            'redirect_to_route_connected' => 'home',

            /**
             * Set the route to redirect when user is disconnected (of course, it must exist!)
             */
             'redirect_to_route_disconnected' => 'zfcuser/login',

            /**
             * If a user is unauthorized and redirected to another route (login, for instance), should we
             * append the previous URI (the one that was unauthorized) in the query params?
             */
             'append_previous_uri' => true,

            /**
             * If append_previous_uri option is set to true, this option set the query key to use when
             * the previous uri is appended
             */
             'previous_uri_query_key' => 'redirectTo'
        ],

        /**
         * Various plugin managers for guards and role providers. Each of them must follow a common
         * plugin manager config format, and can be used to create your custom objects
         */
        // 'guard_manager'               => [],
        // 'role_provider_manager'       => []
    ],
);
