<?php

namespace Drupal\email_ptiwebtech\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
/**
* 
*/
class MailForms extends FormBase
{
	
	function getFormId() {
		return 'MailForms_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		$form['email'] = [
			'#type' => 'textfield',
			'#title' => t('Email Address'),
			'#attributes' => ['id' => ['field-email-address']],
			'#required' => TRUE,
		];
		$form['message'] = [
			'#type' => 'textarea',
			'#title' => t("Email Message"),
			'#required' => TRUE,
		];
		$form['submit'] = [
			'#type' => 'submit',
			'#value' => t('Send Mail'),
		];

		return $form;
	}

	function validateForm(array &$form, FormStateInterface $form_state) {
		if(!valid_email_address($form_state->getValue('email'))) {
			$form_state->setErrorByName('email', $this->t('That email-address is not valid,'));
		}
	}
	function submitForm(array &$form, FormStateInterface $form_state ){
		$values = $form_state->getValues();
		$module = 'email_ptiwebtech';
		$key = "sentMail";

		$mailManager = \Drupal::service('plugin.manager.mail');
		$to = $values['email'];
		$from = $this->config('system.site')->get('mail');
		
		$params = $values;

		$language = \Drupal::languageManager()->getCurrentLanguage()->getId();

		$send_now = TRUE;

		$result = $mailManager->mail($module, $key, $to, $language, $params, NULL, $send_now);
		if($result['result'] == TRUE) {
			drupal_set_message(t('Your message has been sent.'));
		} else {
			drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
		}
		
	}
}