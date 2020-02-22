<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Block assessfreq trigger Web Service
 * calendarContainer, spinner
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . "/externallib.php");

/**
 * Block assessfreq trigger Web Service
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_assessfreq_external extends external_api {


    /**
     * Returns description of method parameters.
     * @return void
     */
    public static function get_frequency_parameters() {
        return new external_function_parameters(
            array(
                //if I had any parameters, they would be described here. But I don't have any, so this array is empty.
            )
        );
    }

    /**
     * Returns event frequency map.
     *
     */
    public static function get_frequency() {
        \core\session\manager::write_close(); // Close session early this is a read op.

        // Execute API call.
        $frequency = new \block_assessfreq\frequency();
        $freqarr = $frequency->get_frequency_array();

        return json_encode($freqarr);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_frequency_returns() {
        return new external_value(PARAM_RAW, 'Event JSON');
    }

    /**
     * Returns description of method parameters.
     * @return void
     */
    public static function get_strings_parameters() {
        return new external_function_parameters(
            array(
                //if I had any parameters, they would be described here. But I don't have any, so this array is empty.
            )
        );
    }

    /**
     * Returns strings used in heat map display.
     * Sending an array of all the required strings
     * is much more efficent that making an AJAX call
     * per string.
     *
     */
    public static function get_strings() {
        \core\session\manager::write_close(); // Close session early this is a read op.

        $stringarr = array(
            'days' => array(
                '0' => get_string('sun', 'calendar'),
                '1' => get_string('mon', 'calendar'),
                '2' => get_string('tue', 'calendar'),
                '3' => get_string('wed', 'calendar'),
                '4' => get_string('thu', 'calendar'),
                '5' => get_string('fri', 'calendar'),
                '6' => get_string('sat', 'calendar'),
            ),
            'months' => array(
                '0' => get_string('jan', 'block_assessfreq'),
                '1' => get_string('feb', 'block_assessfreq'),
                '2' => get_string('mar', 'block_assessfreq'),
                '3' => get_string('apr', 'block_assessfreq'),
                '4' => get_string('may', 'block_assessfreq'),
                '5' => get_string('jun', 'block_assessfreq'),
                '6' => get_string('jul', 'block_assessfreq'),
                '7' => get_string('aug', 'block_assessfreq'),
                '8' => get_string('sep', 'block_assessfreq'),
                '9' => get_string('oct', 'block_assessfreq'),
                '10' => get_string('nov', 'block_assessfreq'),
                '11' => get_string('dec', 'block_assessfreq'),
            )
        );

        return json_encode($stringarr);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_strings_returns() {
        return new external_value(PARAM_RAW, 'Language string JSON');
    }
}