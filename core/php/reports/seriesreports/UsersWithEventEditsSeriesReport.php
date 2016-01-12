<?php




namespace reports\seriesreports;

use BaseSeriesReport;
use ReportDataItem;
use Silex\Application;


/**
 *
 * @package Core
 * @link http://ican.openacalendar.org/ OpenACalendar Open Source Software
 * @license http://ican.openacalendar.org/license.html 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class UsersWithEventEditsSeriesReport extends BaseSeriesReport {


	function __construct(Application $app)
	{
        parent::__construct($app);
		$this->hasFilterTime = true;
	}

	public function getExtensionID() { return 'org.openacalendar'; }

	public function getReportID() { return 'UsersWithEventEdits'; }

	public function getReportTitle() { return 'Users With Event Edits'; }

	public function run() {

		$where = array();
		$params = array();

		if ($this->filterTimeStart) {
			$where[] = " event_history.created_at >= :start_at ";
			$params['start_at'] = $this->filterTimeStart->format("Y-m-d H:i:s");
		}


		if ($this->filterTimeEnd) {
			$where[] = " event_history.created_at <= :end_at ";
			$params['end_at'] = $this->filterTimeEnd->format("Y-m-d H:i:s");
		}

		$sql = "SELECT event_history.user_account_id, COUNT('event_history.user_id') AS count , MAX(user_account_information.username) AS username".
			" FROM event_history ".
			" JOIN user_account_information ON user_account_information.id = event_history.user_account_id ".
			($where ? " WHERE " . implode(" AND ",$where) : "").
			" GROUP BY event_history.user_account_id ".
			" ORDER BY COUNT('event_history.user_account_id') DESC";
		$stat = $this->app['db']->prepare($sql);
		$stat->execute($params);
		$this->data = array();
		while($data = $stat->fetch()) {
			$this->data[$data['user_account_id']] = new ReportDataItem($data['count'], $data['user_account_id'], $data['username'],'/sysadmin/user/'.$data['user_account_id'].'/');
		}

	}


}


