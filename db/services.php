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
 * Block Assessment frequency web service external functions and service definitions.
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Define the web service functions to install.
$functions = array(
        'block_assessfreq_get_frequency' => array(
                'classname'   => 'block_assessfreq_external',
                'methodname'  => 'get_frequency',
                'classpath'   => 'block/accessfreq/externallib.php',
                'description' => 'Returns event frequency map.',
                'type'        => 'read',
                'ajax' => true
        ),
);
