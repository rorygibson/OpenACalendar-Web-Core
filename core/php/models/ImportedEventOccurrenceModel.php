<?php

namespace models;



/**
 *
 * @package Core
 * @link http://ican.openacalendar.org/ OpenACalendar Open Source Software
 * @license http://ican.openacalendar.org/license.html 3-clause BSD
 * @copyright (c) 2013-2014, JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class ImportedEventOccurrenceModel extends \models\ImportedEventModel {

	public function setFromImportedEventModel(ImportedEventModel $importedEventModel) {
		$this->id = $importedEventModel->id;
		$this->import_url_id = $importedEventModel->import_url_id;
		$this->import_id = $importedEventModel->import_id;
		$this->title = $importedEventModel->title;
		$this->description = $importedEventModel->description;
		$this->start_at = $importedEventModel->start_at;
		$this->end_at = $importedEventModel->end_at;
		$this->timezone = $importedEventModel->timezone;
		$this->is_deleted = $importedEventModel->is_deleted;
		$this->url = $importedEventModel->url;
		$this->ticket_url = $importedEventModel->ticket_url;
		$this->ics_rrule_1 = $importedEventModel->ics_rrule_1;
	}

}

