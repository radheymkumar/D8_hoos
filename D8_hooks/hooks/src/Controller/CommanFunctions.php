<?php

namespace Drupal\hooks\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
* 
*/
class CommanFunctions extends ControllerBase
{
	
	static function stateLists() {
		$states = [];
		$states = [
			'RJ' => t('Rajasthan'),
			'MP' => t('Madhay Pradesh'),
			'UP' => t('Utter Pradesh'),
			'HP' => t('Himachal Pradesh'),
			'PB' => t('Panjab'),
			'HR' => t('Hariyana'),
			'MH' => t('Maharastra'),
		];

		return $states;
	}

	static function getContentType() {

		$contentTypes = \Drupal::service('entity.manager')->getStorage('node_type')->loadMultiple();
		$contentTypesList = [];
		foreach ($contentTypes as $contentType) {
    		$contentTypesList[$contentType->id()] = $contentType->label();
		}
		return $contentTypesList;
	}	
}