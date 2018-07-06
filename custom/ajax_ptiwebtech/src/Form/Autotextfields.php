<?php

namespace Drupal\ajax_ptiwebtech\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
/**
* 
*/
class Autotextfields extends FormBase
{
	
	public function getFormId() {
		return 'autotextfields_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {

		$form['description'] = [
			'#type' => 'item',
			'#markup' => $this->t('This form demonstrates changing the status of form elements through AJAX requests.'),
		];
		$form['ask_first_name'] = [
			'#type' => 'checkbox',
			'#title' => $this->t('Ask me my first name'),
			'#ajax' => [
				'callback' => '::textfieldCallback',
				'wrapper' => 'textfield-container',
				'effect' => 'fade',
			],
		];
		$form['ask_last_name'] = [
			'#type' => 'checkbox',
			'#title' => $this->t('Ask me my last name'),
			'#ajax' => [
				'callback' => '::textfieldCallback',
				'wrapper' => 'textfield-container',
				'effect' => 'fade',
			],
		];
		$form['textfields_container'] = [
			'#type' => 'container',
			'#attributes' => ['id' => 'textfield-container'],
		];
		$form['textfields_container']['textfields'] = [
	    	'#type' => 'fieldset',
	      	'#title' => $this->t("Generated text fields for first and last name"),
	      	'#description' => t('This is where we put automatically generated textfields'),
	    ];

	    if($form_state->getValue('ask_first_name', NULL) === 1) {
	    	$form['textfields_container']['textfields']['first_name'] = [
	    		'#type' => 'textfield',
	    		'#title' => t('First Name'),
	    		'#required' => TRUE,
	    	];
	    }
	    if($form_state->getValue('ask_last_name', NULL) === 1) {
	    	$form['textfields_container']['textfields']['last_name'] = [
	    		'#type' => 'textfield',
	    		'#title' => t('Last Name'),
	    		'#required' => TRUE,
	    	];
	    }

	    $form['textfields_container']['submit'] = [
	    	'#type' => 'submit',
	    	'#value' => $this->t('Click Me'),
	    ];

		return $form;
	}

	function submitForm(array &$form, FormStateInterface $form_state) {
	  drupal_set_message($this->t('Ajax form submit Fist Name - @first_name , Last Name - @last_name', ['@first_name' => $form_state->getValue('first_name'), '@last_name' => $form_state->getValue('last_name')]));

	}

	function textfieldCallback(array $form, FormStateInterface $form_state) {
		return $form['textfields_container'];

	}
}