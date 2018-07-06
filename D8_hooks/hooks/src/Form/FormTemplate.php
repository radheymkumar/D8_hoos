<?php

namespace Drupal\hooks\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hooks\Controller\CommanFunctions;

/**
* 
*/
class FormTemplate extends FormBase
{
	
	public function getFormId() {
		return 'formtemplate_form';
	}

	public function buildForm( array $form, FormStateInterface $form_state) {
		$form = [];
		$form['name'] = [
			'#type' => 'textfield',
			'#title' => t('Name'),
		];
		$form['state'] = [
			'#type' => 'select',
			'#title' => t('City'),
			'#options' => CommanFunctions::stateLists()
		];
		$form['content_type_list'] = [
			'#type' => 'select',
			'#title' => t('Content Type'),
			'#options' => CommanFunctions::getContentType()
		];
		$form['actions']['submit'] = [
			'#type' => 'submit',
			'#value' => t('Submit'),
		];
		$form['actions']['clear'] = [
			'#type' => 'submit',
			'#value' => t('Reset'),
			'#submit' => ['::_reset_formtemplate_form'],
		];

		$form['#theme'] = 'form_template';
		
		return $form;
	}

	public function validateFrom( array &$form, FormStateInterface $form_state) {

	}

	public function submitForm( array &$form, FormStateInterface $form_state) {
		dsm($form_state->getValues());
	}

	public function _reset_formtemplate_form(array &$form, FormStateInterface $form_state) {
		drupal_set_message('Clear Reset');
	}
}