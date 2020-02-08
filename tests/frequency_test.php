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
 * This file contains the class that handles testing of the block assess frequency class.
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/calendar/tests/helpers.php');

use block_assessfreq\frequency;

/**
 * This file contains the class that handles testing of the block assess frequency class.
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */
class frequency_testcase extends advanced_testcase {

    /**
     * Test getting the rawevents.
     */
    public function test_get_events() {
        $this->resetAfterTest();
        //$this->setUser();

        $user = $this->getDataGenerator()->create_user();
        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();

        $this->resetAfterTest(true);
        $this->setAdminuser();
        $this->getDataGenerator()->enrol_user($user->id, $course1->id);
        $this->getDataGenerator()->enrol_user($user->id, $course2->id);

        for ($i = 1; $i < 2; $i++) {
            create_event([
                'name' => sprintf('Event %d', $i),
                'eventtype' => 'user',
                'userid' => $user->id,
                'timesort' => $i,
                'type' => CALENDAR_EVENT_TYPE_ACTION,
                'courseid' => $course1->id,
            ]);
        }

//         for ($i = 6; $i < 12; $i++) {
//             create_event([
//                 'name' => sprintf('Event %d', $i),
//                 'eventtype' => 'user',
//                 'userid' => $user->id,
//                 'timesort' => $i,
//                 'type' => CALENDAR_EVENT_TYPE_ACTION,
//                 'courseid' => $course2->id,
//             ]);
//         }

        $frequency = new frequency();

        // We're testing a private method, so we need to setup reflector magic.
        $method = new ReflectionMethod('\block_assessfreq\frequency', 'get_events');
        $method->setAccessible(true); // Allow accessing of private method.
        $result = $method->invoke($frequency);

        error_log(print_r($result, true));
    }
}
