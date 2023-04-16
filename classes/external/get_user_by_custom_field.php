<?php
require_once (&CFG-> libdir . "/classes/external/get_user_by_custom_field.php")
namespace local_plugin_for_telegram\external;

use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;

class get_user_by_custom_field extends \core_external\external_api {

    // /**
    //  * Returns description of method parameters
    //  * @return external_function_parameters
    //  */
    // public static function execute_parameters() {
    //     return new external_function_parameters([
    //         'value' => new external_value(PARAM_TEXT, 'value of field')
    //     ]);
    // }

    // /**
    //  * Create groups
    //  * @param value $value of field
    //  * @return value id user by value
    //  */
    // public static function execute($value) {
    //     global $CFG, $DB, $USER;
    //     require_once("$CFG->dirroot/user/lib.php");

    //     $params = self::validate_parameters(self::get_users_by_field_parameters(), 'value' => $value);
        
    //     // Retrieve the users.
    //     $users = $DB->get_records_list('user', $field, $cleanedvalues, 'id');

    //     $context = context_system::instance();
    //     self::validate_context($context);

    //     // Finally retrieve each users information.
    //     $returnedusers = array();
    //     foreach ($users as $user) {
    //         $userdetails = user_get_user_details_courses($user);

    //         // Return the user only if the searched field is returned.
    //         // Otherwise it means that the $USER was not allowed to search the returned user.
    //         if (!empty($userdetails) and !empty($userdetails[$field])) {
    //             $returnedusers[] = $userdetails;
    //         }
    //     }

    //     return $returnedusers;
    // }
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since Moodle 2.4
     */
    public static function get_user_by_custom_field_parameters() {
        return new external_function_parameters(
            array(
                'field' => new external_value(PARAM_ALPHA, 'the search field can be
                    \'id\' or \'idnumber\' or \'username\' or \'email\' or \'skype\''),
                'values' => new external_multiple_structure(
                        new external_value(PARAM_RAW, 'the value to match'))
            )
        );
    }

    /**
     * Get user information for a unique field.
     *
     * @throws coding_exception
     * @throws invalid_parameter_exception
     * @param string $field
     * @param array $values
     * @return array An array of arrays containg user profiles.
     * @since Moodle 2.4
     */
    public static function get_user_by_custom_field($field, $values) {
        global $CFG, $USER, $DB;
        require_once($CFG->dirroot . "/user/lib.php");

        $params = self::validate_parameters(self::get_user_by_custom_field(),
                array('field' => $field, 'values' => $values));

        // This array will keep all the users that are allowed to be searched,
        // according to the current user's privileges.
        $cleanedvalues = array();

        switch ($field) {
            case 'id':
                $paramtype = core_user::get_property_type('id');
                break;
            case 'idnumber':
                $paramtype = core_user::get_property_type('idnumber');
                break;
            case 'username':
                $paramtype = core_user::get_property_type('username');
                break;
            case 'email':
                $paramtype = core_user::get_property_type('email');
                break;
            case 'skype':
                $paramtype = core_user::get_property_type('skype');
                break;
            default:
                throw new coding_exception('invalid field parameter',
                        'The search field \'' . $field . '\' is not supported, look at the web service documentation');
        }

        // Clean the values.
        foreach ($values as $value) {
            $cleanedvalue = clean_param($value, $paramtype);
            if ( $value != $cleanedvalue) {
                throw new invalid_parameter_exception('The field \'' . $field .
                        '\' value is invalid: ' . $value . '(cleaned value: '.$cleanedvalue.')');
            }
            $cleanedvalues[] = $cleanedvalue;
        }

        // Retrieve the users.
        $users = $DB->get_records_list('user', $field, $cleanedvalues, 'id');

        $context = context_system::instance();
        self::validate_context($context);

        // Finally retrieve each users information.
        $returnedusers = array();
        foreach ($users as $user) {
            $userdetails = user_get_user_details_courses($user);

            // Return the user only if the searched field is returned.
            // Otherwise it means that the $USER was not allowed to search the returned user.
            if (!empty($userdetails) and !empty($userdetails[$field])) {
                $returnedusers[] = $userdetails;
            }
        }

        return $returnedusers;
    }

    /**
     * Returns description of method result value
     *
     * @return external_multiple_structure
     * @since Moodle 2.4
     */
    public static function get_user_by_custom_field_returns() {
        return new external_multiple_structure(self::user_description());
    }
}
