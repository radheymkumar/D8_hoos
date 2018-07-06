<?php

namespace Drupal\form_api_ptiwebtech\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
/**
* 
*/
class AjaxAddMores extends FormBase
{
	
	public function getFormId() {
		return 'ajaxmore_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		die;
		$form['name_fieldset'] = [
			'#type' => 'fieldset',
			'#title' => t('People Comming'),
			'#prefix' => '<div id="name-wrapper-fieldset">',
			'#suffix' => '</div>',
		];	

		return $form;
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {

	}
}