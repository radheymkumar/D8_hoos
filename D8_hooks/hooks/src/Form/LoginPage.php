<?php

namespace Drupal\hooks\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Form\UserLoginForm;

/**
* 
*/
class LoginPage extends UserLoginForm
{
	
	public function buildForm( array $form, FormStateInterface $form_state) {
		$form = parent::buildForm($form, $form_state);
		$form['first_name'] = [
			'#type' => 'textfield',
			'#title' => t('First Name'),
			'#default_value' => '',
		];

		return $form;
	}
}