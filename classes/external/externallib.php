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
        $users = $DB->get_records_list('user', 'skype', [$username_tg], 'id');
        if (!empty($users)) {
            $user = reset($users); 
            return $user->id;
        } else {
            return null;
        }
    }
    public static function get_user_by_field_tg_returns() {
        return new external_value(PARAM_RAW);
    }
}