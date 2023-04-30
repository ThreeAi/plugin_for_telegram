<?php
$functions = array(
    'get_user_by_field_tg' => array(
        'classname' => 'get_user_by_field_tg_external', 
        'description' => 'Get user by custom or optional field',
        'type' => 'read',
        'ajax' => true,
        'classpath' => 'mod/telegram_get_user/externallib.php',
    )
);

$services = array(
    'telegram_get_user' => array(
        'function' => array ('get_user_by_field_tg'),
        'restrictedusers' => 0,
        'enabled' => 1,
    )
)

?>
