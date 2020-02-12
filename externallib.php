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
 *
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
     * Returns event frequency map.
     *
     */
    public static function get_strings() {

        $stringarr = array(
            'sun' => get_string('sun', 'calendar'),
            'mon' => get_string('mon', 'calendar'),
            'tue' => get_string('tue', 'calendar'),
            'wed' => get_string('wed', 'calendar'),
            'thu' => get_string('thu', 'calendar'),
            'fri' => get_string('fri', 'calendar'),
            'sat' => get_string('sat', 'calendar'),
        );

        return json_encode($stringarr);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_strings_returns() {
        return new external_value(PARAM_RAW, 'Event JSON');
    }
}