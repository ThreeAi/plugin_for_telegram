<?php
require_once($CFG->libdir . "/externallib.php");
class get_user_by_field_tg_external extends external_api {

    public static function get_user_by_field_tg_parameters() {
        return new external_function_parameters(
            array(
                'username_tg' => new external_value(PARAM_RAW, 'the value to match'),
            )
            );
    }

    public static function get_user_by_field_tg($username_tg) {
        global $DB;
        $users = array();
        $users = $DB->get_records_list('user', 'WHERE skype = ?', $username_tg, 'id');
        if (!empty($users)) {
            $user = reset($users); 
            return self::user_returns($user);
        } else {
            return null;
        }
    }


    public static function get_user_by_field_tg_returns() {
        return new external_multiple_structure(self::user_returns($user));
    }
    
    private static function user_returns($user) {
        $user_fields = array(
            'id' => new external_value(PARAM_INT, 'User ID'),
            'username' => new external_value(PARAM_TEXT, 'Username'),
            'email' => new external_value(PARAM_TEXT, 'Email'),
            'firstname' => new external_value(PARAM_TEXT, 'First name'),
            'lastname' => new external_value(PARAM_TEXT, 'Last name'),
            'fullname' => new external_value(PARAM_TEXT, 'Full name'),
            'skype' => new external_value(PARAM_TEXT, 'Skype'),
        );

        return new external_single_structure($user_fields);
    }
}