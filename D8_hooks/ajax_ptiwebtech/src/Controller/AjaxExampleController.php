<?php

namespace Drupal\ajax_ptiwebtech\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\BeforeCommand;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Ajax\ReplaceCommand;
/**
* 
*/
class AjaxExampleController extends ControllerBase
{
	
	function content() {
		$build['info'] = [
			'#markup' => $this->t('The link below has been rendered as an element with the #ajax property, so if
				javascript is enabled'),
		];
		$build['ajax_link'] = [
			'#type' => 'details',
			'#title' => t('Ajax Link'),
			'#open' => TRUE,
		];
		$build['ajax_link']['link'] = [
			'#type' => 'link',
			'#title' => t('Click Me'),
			'#attributes' => ['class' => ['use-ajax']],
			'#url' => Url::fromRoute('ajax_ptiwebtech.ajaxexamplecontroller2'),
		];

		$build['ajax_link']['destination'] = [
	      	'#type' => 'container',
	      	'#attributes' => ['id' => ['ajax-example-destination-div']],
	    ];
		return $build;
	}

	function content2() {
		/*$build['info'] = [
			'#markup' => $this->t('The link below has been rendered as an element with the #ajax property, so if
				javascript is enabled'),
		];*/
		$message = t('Please enter your full name');
		$output = $this->t('The link below has been rendered as an element with the #ajax property, so if javascript is enabled');
		$output2 = $this->t('The link below has been rendered ');
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#ajax-example-destination-div', $output));
		$ajax_response->addCommand(new BeforeCommand('.use-ajax', $output));
		$ajax_response->addCommand(new AlertCommand($message));
		$ajax_response->addCommand(new ReplaceCommand('#ajax-example-destination-div', $output2));
		return $ajax_response;
	}		
}