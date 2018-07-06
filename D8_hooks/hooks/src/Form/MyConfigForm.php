<?php

namespace Drupal\hooks\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\ConfigFormBase;

/**
* 
*/
class MyConfigForm extends ConfigFormBase
{
	protected function getEditableConfigNames() {
		return [
			'hooks.settings',
		];
	}
	public function getFormId() {
		return 'MyConfigForm_form';
	}

	public function buildForm( array $form, FormStateInterface $form_state) {
		$config = $this->config('hooks.settings');
		$form['fieldset'] = [
			'#type' => 'fieldset',
			'#title' => t('Site details'),
		];
		$form['fieldset']['site_name'] = [
			'#type' => 'textfield',
			'#title' => t('Site name'),
			'#default_value' => $config->get('site_name'),
		];
		$form['fieldset']['site_slogan'] = [
			'#type' => 'textfield',
			'#title' => t('Slogan'),
			'#default_value' => $config->get('site_slogan'),
			'#description' => t(' How this is used depends on your site\'s theme.'),
		];
		$form['fieldset']['site_email'] = [
			'#type' => 'textfield',
			'#title' => t('Email'),
			'#default_value' => $config->get('site_email'),
			'#description' => t(' The From address in automated emails sent during registration and new password requests, and other notifications. (Use an address ending in your site\'s domain to help prevent this email being flagged as spam.) '),
		];

		$form['actions']['submit1'] = [
			'#type' => 'submit',
			'#value' => t('Submit'),
			'#submit' => array([$this, 'hooks_config_form_submit']),
			'#weight' => 10,
		];
		$form['actions']['submit2'] = [
			'#type' => 'submit',
			'#value' => t('Submit 2'),
			'#submit' => array('::newSubmitHandler'),
			'#weight' => 11,
		];
		return parent::buildForm($form, $form_state);
	}

	public function validateForm(array &$form, FormStateInterface $form_state) {
		//parent::validateForm($form, $form_state);
		$values = $form_state->getValues();
		// site_name
		if(!preg_match('/^[a-zA-Z0-9\s]+$/', $values['site_name'])) {
			$form_state->setErrorByName('site_name', t('Must character only Alpha and number.'));
		}
		if(!preg_match('/^[a-z\_]+$/', $values['site_slogan'])) {
			$form_state->setErrorByName('site_slogan', t('Must character space use Underscore (_).'));
		}
		if(!valid_email_address($values['site_email'])) {
			$form_state->setErrorByName('site_email', t('Must be valid email address'));	
		}
		//dsm($values);
	}

	public function submitForm( array &$form, FormStateInterface $form_state) {
		parent::submitForm($form, $form_state);

		$this->config('hooks.settings')
			->set('site_name', $form_state->getValue('site_name'))
			->set('site_slogan', $form_state->getValue('site_slogan'))
			->set('site_email', $form_state->getValue('site_email'))
			->save();
	}

	function hooks_config_form_submit(array &$form, FormStateInterface $form_state) {
		global $base_url;
		drupal_set_message($base_url);

		$this->config('hooks.settings')
			->set('site_name', $form_state->getValue('site_name'))
			->set('site_slogan', $form_state->getValue('site_slogan'))
			->set('site_email', $form_state->getValue('site_email'))
			->save();
	}

	function newSubmitHandler( array &$form, FormStateInterface $form_state) {
		drupal_set_message('newSubmitHandler 2');

		$this->config('hooks.settings')
			->set('site_name', $form_state->getValue('site_name'))
			->set('site_slogan', $form_state->getValue('site_slogan'))
			->set('site_email', $form_state->getValue('site_email'))
			->save();	 
	}
}