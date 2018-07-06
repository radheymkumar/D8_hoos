<?php

namespace Drupal\hooks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

	public function autocomplete_path(Request $request) {
		
		$input = $request->query->get('q');
		$matches = ['Value 1', 'Value 2', 'Value 3'];
				
		return new JsonResponse($matches);
	}

	public function myWebService() {
		$request = \Drupal::request();
	    $output['a'] = $request->get('a');
	    $output['b'] = $request->get('b');
	    $output['result'] = $output['a'] * $output['b'];
	    return new JsonResponse($output);
	}
}