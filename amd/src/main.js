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
 * @package    block_myoverview
 * @copyright  2018 Bas Brands <bas@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {

    /**
     * Module level variables.
     */
    var Main = {};
    var today = new Date();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();

    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    /**
     * Check how many days in a month code
     * from https://dzone.com/articles/determining-number-days-month.
     */
    function daysInMonth(month, year) {
        return 32 - new Date(year, month, 32).getDate();
    }

    /**
     * Generate calendar markup for the month.
     */
    function generateCalendar(month, year) {

        let firstDay = (new Date(year, month)).getDay();  // Get the starting day of the month.

        tbl = document.getElementById("calendar-body"); // Body of the calendar.

        // Clearing all previous cells.
        tbl.innerHTML = "";

        // Filing data about month and in the page via DOM.
        monthAndYear.innerHTML = months[month] + " " + year;
        selectYear.value = year;
        selectMonth.value = month;

        // Creating all cells.
        let date = 1;
        for (let i = 0; i < 6; i++) {
            // Creates a table row.
            let row = document.createElement("tr");

            // Creating individual cells, filing them up with data.
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    cell = document.createElement("td");
                    cellText = document.createTextNode("");
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                }
                else if (date > daysInMonth(month, year)) {
                    break;
                }

                else {
                    cell = document.createElement("td");
                    cellText = document.createTextNode(date);
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
     * Initialise all of the modules for the overview block.
     *
     * @param {object} root The root element for the overview block.
     */
    Main.init = function(root) {
        root = $(root);

        window.console.log(root);
    };

    return Main;
});
