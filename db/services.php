<?php
$functions = array(
    'get_user_by_field_tg' => array(
        'classname' => 'get_user_by_field_tg_external', 
        'description' => 'Get user by custom or optional field',
        'type' => 'read',
        'ajax' => true,
        'classpath' => 'local/plugin_for_telegram/externallib.php',
    )
);

$services = array(
    'plugin_for_telegram' => array(
        'function' => array ('get_user_by_field_tg'),
        'restrictedusers' => 0,
        'enabled' => 1,
    )
)

?>
