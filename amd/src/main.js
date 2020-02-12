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
 * Javascript to initialise the myoverview block.
 *
 * @package    block_assessfreq
 * @copyright  2020 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['core/ajax'], function(ajax) {

    /**
     * Module level variables.
     */
    var Main = {};
    var today = new Date();
    var eventArray = [];
    var stringArray = [];

    /**
     * Check how many days in a month code.
     * from https://dzone.com/articles/determining-number-days-month.
     */
    function daysInMonth(month, year) {
        return 32 - new Date(year, month, 32).getDate();
    }

    function createTables(month, num) {
        // Setup some elements we can reuse.
        var table = document.createElement("table");
        var thead = document.createElement("thead");
        var tbody = document.createElement("tbody");
        var monthRow = document.createElement("tr");
        var dayrow = document.createElement("tr");
        var monthHeader = document.createElement("th");

        var day0Header = document.createElement("th");
        var day1Header = document.createElement("th");
        var day2Header = document.createElement("th");
        var day3Header = document.createElement("th");
        var day4Header = document.createElement("th");
        var day5Header = document.createElement("th");
        var day6Header = document.createElement("th");

    }

    /**
     * Generate calendar markup for the month.
     */
    function generateCalendar(month, year, containerdiv) {

        let firstDay = (new Date(year, month)).getDay();  // Get the starting day of the month.
        var tbl = containerdiv.getElementsByTagName("tbody")[0];
        var monthEvents = eventArray[year][(month + 1)];  // We add one due to month diferences between PHP and JS.

        // Clearing all previous cells.
        tbl.innerHTML = "";

        // Creating all cells.
        let date = 1;

        for (let i = 0; i < 6; i++) {
            // Creates a table row.
            let row = document.createElement("tr");

            // Creating individual cells, filing them up with data.
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    var cell = document.createElement("td");
                    var cellText = document.createTextNode("");
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                }
                else if (date > daysInMonth(month, year)) {
                    break;
                }

                else {
                    cell = document.createElement("td");
                    cellText = document.createTextNode(date);
                    if ((typeof monthEvents !== "undefined") && (monthEvents.hasOwnProperty(date))) {
                        var heatClass = "heat-" + monthEvents[date]['heat'];
                        cell.classList.add(heatClass);
                    }
                    if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                        cell.classList.add("bg-info");
                    } // Color today's date.
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                    date++;
                }

            }

            tbl.appendChild(row); // Appending each row into calendar body.
        }

    }

    /**
     * Initialise all of the modules for the assessment frequency block.
     *
     * @param {object} root The root element for the assessment frequency block.
     */
    Main.init = function(root) {
        // Make ajax call to get all the strings we'll need.
        // This is more efficient than making an ajax call per string.
        ajax.call([{
            methodname: 'block_assessfreq_get_strings',
            args: {},
        }])[0].done(function(response) {
            stringArray = JSON.parse(response);
        }).fail(function(response) {
            // TODO: add an alert here like you did for the async backup stuff.
            window.console.log(response);
        });

        // Get the containers that will hold the months.
        var calendarContainer = root;
        var containerdivs = calendarContainer.children;

        // Start with current month and year.
        var month = today.getMonth();
        var year = today.getFullYear();

        // Create the table shell.
        createTables(month, 4);

        // Get the events to use in the mapping.
        ajax.call([{
            methodname: 'block_assessfreq_get_frequency',
            args: {},
        }])[0].done(function(response) {
            eventArray = JSON.parse(response);
            // Generate calendar on response.
            for (let i = 0; i < containerdivs.length; i++) {
                generateCalendar(month, year, containerdivs[i]);
                month++;
            }
        }).fail(function(response) {
            // TODO: add an alert here like you did for the async backup stuff.
            window.console.log(response);
        });

    };

    return Main;
});
