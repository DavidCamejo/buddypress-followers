<?php
namespace BuddyPress\Followers\API;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Response;
use WP_Error;

class Followers extends WP_REST_Controller {
    protected $namespace = 'buddypress/v1';
    protected $rest_base = 'follow';
    
    public function register_routes() {
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_items'],
                'permission_callback' => [$this, 'get_items_permissions_check'],
                'args'                => $this->get_collection_params(),
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'create_item'],
                'permission_callback' => [$this, 'create_item_permissions_check'],
                'args'                => $this->get_endpoint_args_for_item_schema(WP_REST_Server::CREATABLE),
            ],
            'schema' => [$this, 'get_item_schema'],
        ]);
        
        register_rest_route($this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', [
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [$this, 'delete_item'],
                'permission_callback' => [$this, 'delete_item_permissions_check'],
                'args'                => [
                    'force' => [
                        'type'        => 'boolean',
                        'default'     => false,
                        'description' => __('Required to be true, as resource does not support trashing.'),
                    ],
                ],
            ],
            'schema' => [$this, 'get_item_schema'],
        ]);
    }
    
    // ... implementación de los métodos del controlador
}