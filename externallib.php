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
        return;
    }

    /**
     * Returns event frequency map.
     *
     */
    public static function get_frequency() {

        // Execute API call.
        $frequency = new \block_assessfreq\frequency();
        $freqarr = $frequency->get_frequency_array();

        // Turn this into a nested array, so that the ordering can survive JSON-encoding.
        // (Because a PHP associative array becomes a JSON object, and according to the
        // specification, the order of the keys in a JS/JSON object is not meant to be
        // meaningful, while the order of the elements in a JS/JSON array is.)
        $output = [];
        foreach ($steps as $class => $namestr) {
            $output[] = [
                'class' => $class,
                'name' => $namestr
            ];
        }
        return $freqarr;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_frequency() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'class' => new external_value(PARAM_TEXT, 'Event identifier'),
                    'name' => new external_value(PARAM_TEXT, 'Event Name'),
                )
                )
            );
    }
}