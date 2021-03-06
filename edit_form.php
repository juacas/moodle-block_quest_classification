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
 * Form for editing quest_classification block instances.
 *
 * @package   block_quest_classification
 * @copyright 2013 Juan Pablo de Castro
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

/**
 * Definition of the Block form
 * @author Juan Pablo de Castro and many others.
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright  2007-13 Eduvalab University of Valladolid http://www.eduvalab.uva.es
 */
class block_quest_classification_edit_form extends block_edit_form {

    /**
     * The configuration form of this block.
     * 
     * @param MoodleQuickForm $mform the form being built.
     */
    protected function specific_definition($mform) {
        global $DB;

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        if (!$this->block->get_owning_quest()) {
            $quests = $DB->get_records_menu('quest', array('course' => $this->page->course->id), '', 'id, name');
            if (empty($quests)) {
                $mform->addElement(
                    'static', 'no_quests_in_course',
                    get_string('error_emptyquestid', 'block_quest_classification'),
                    get_string('config_no_quests_in_course', 'block_quest_classification')
                );
            } else {
                foreach ($quests as $id => $name) {
                    $quests[$id] = strip_tags(format_string($name));
                }
                $mform->addElement(
                    'select', 'config_questid', get_string('config_select_quest', 'block_quest_classification'), $quests
                );
            }
        }

        $mform->addElement(
            'select', 'config_showbest',
            get_string('config_show_best', 'block_quest_classification'),
            array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10)
        );
        $mform->setDefault('config_showbest', 3);
        $mform->setType('config_showbest', PARAM_INT);

        $mform->addElement('selectyesno', 'config_useteams', get_string('config_use_teams', 'block_quest_classification'));
    }
}
