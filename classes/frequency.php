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
 * Frequency class.
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */

namespace block_assessfreq;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/calendar/lib.php');

/**
 * Frequency class.
 *
 * This class handles data processing to get assessment frequency data
 * used in generating the heat map display for the plugin.
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */
class frequency {

    /**
     * Get the raw events for the current user.
     *
     * @return array $events An array of the raw events.
     */
    private function get_events() : array {

        $vault = \core_calendar\local\event\container::get_event_vault();

        // TODO: Get events has a limit of 20 by default need to work around this.
        // TODO: need to filter to a particular user.
        $events = $vault->get_events();

        // get_times
        return $events;

    }

    /**
     * Generate a frequency array of the events.
z     *;
     * @return array $freqarray The array of even frequencies.
     */
    public function get_frequency_array() : array {
        $freqarray = array();

        // Get the raw events.
        $events = $this->get_events();

        // Iterate through the events, building the frequency array.
        foreach ($events as $event) {
            $eventtimes = $event->get_times();
            $endtime = $eventtimes->get_end_time();
            $year = $endtime->format('Y');
            $month = $endtime->format('n');
            $day = $endtime->format('j');

            // Construct the multidimensional array.
            if (empty($freqarray[$year][$month][$day])) {
                $freqarray[$year][$month][$day] = 1;
            } else {
                $freqarray[$year][$month][$day]++;
            }
        }

        return $freqarray;
    }
}
