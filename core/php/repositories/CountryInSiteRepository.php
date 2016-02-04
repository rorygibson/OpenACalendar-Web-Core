<?php


namespace repositories;

use models\CountryModel;
use models\SiteModel;
use models\UserAccountModel;
use Silex\Application;

/**
 *
 * @package Core
 * @link http://ican.openacalendar.org/ OpenACalendar Open Source Software
 * @license http://ican.openacalendar.org/license.html 3-clause BSD
 * @copyright (c) JMB Technology Limited, http://jmbtechnology.co.uk/
 * @author James Baster <james@jarofgreen.co.uk>
 */
class CountryInSiteRepository {



    /** @var Application */
    private  $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

	public function addCountryToSite(CountryModel $country, SiteModel $site, UserAccountModel $user) {
		$stat = $this->app['db']->prepare("SELECT * FROM country_in_site_information WHERE site_id =:site_id AND country_id =:country_id");
		$stat->execute(array( 'country_id'=>$country->getId(), 'site_id'=>$site->getId() ));		
		if ($stat->rowCount() == 1) {
			$stat = $this->app['db']->prepare("UPDATE country_in_site_information SET is_in='1' WHERE site_id =:site_id AND country_id =:country_id");
			$stat->execute(array( 'country_id'=>$country->getId(), 'site_id'=>$site->getId() ));		
		} else {
			$stat = $this->app['db']->prepare("INSERT INTO country_in_site_information (site_id,country_id,is_in,is_previously_in,created_at) VALUES (:site_id,:country_id,'1','1',:created_at)");
			$stat->execute(array( 'country_id'=>$country->getId(), 'site_id'=>$site->getId(), 'created_at'=>$this->app['timesource']->getFormattedForDataBase() ));
		}
		
	}

	public function removeCountryFromSite(CountryModel $country, SiteModel $site, UserAccountModel $user) {
		$stat = $this->app['db']->prepare("UPDATE country_in_site_information SET is_in='0' WHERE site_id =:site_id AND country_id =:country_id");
		$stat->execute(array( 'country_id'=>$country->getId(), 'site_id'=>$site->getId() ));		
	}
	
	public function isCountryInSite(CountryModel $country, SiteModel $site) {
		$stat = $this->app['db']->prepare("SELECT * FROM country_in_site_information WHERE site_id =:site_id AND country_id =:country_id AND is_in= '1'");
		$stat->execute(array( 'country_id'=>$country->getId(), 'site_id'=>$site->getId() ));		
		return ($stat->rowCount() == 1);
	}
	
	
}

