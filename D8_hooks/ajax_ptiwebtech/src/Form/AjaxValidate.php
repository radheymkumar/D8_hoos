<?php
namespace Drupal\ajax_ptiwebtech\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
/**
* 
*/
class AjaxValidate extends FormBase
{
	
	function getFormId(){
		return 'AjaxValidate_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		$form['user_full_name'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Full Name'),
			'#required' => TRUE,
			'#suffix' => '<span class="ui-state-error-text user-full-name"></span>',
		];
		$form['user_email'] = [
			'#type' => 'email',
			'#title' => $this->t('Email'),
			//'#required' => TRUE,
			'#suffix' => '<span class="ui-state-error-text user-email"></span>',
		];
		$form['user_number'] = [
			'#type' => 'tel',
			'#title' => t('Phone Number'),
			'#attributes' => ['class' => ['form-control']],
			'#suffix' => '<span class="ui-state-error-text user-number"></span>',
		];
		$form['user_state'] = [
			'#type' => 'select',
			'#title' => t('State'),
			//'#required' => TRUE,
			'#options' => [
				'Alabama' => t('Alabama'),
	            'Alaska' => t('Alaska'),
	            'Arizona' => t('Arizona'),
	            'Arkansas' => t('Arkansas')
	        ],
	        '#attributes' => ['class' => ['form-control']],
	        '#suffix' => '<span class="ui-state-error-text user-state"></span>',
		];
		$form['product_url'] = array(
	        '#type' => 'url',
	        '#title' => t('Product URL'),
	        //'#required' => TRUE,
	        '#attributes'   =>array('class' => array('form-control')),
	        '#suffix' => '<span class="ui-state-error-text product-url"></span>'
	    );
	    $form['user_message'] = array(
	        '#type' => 'textarea',
	        '#title' => t('Message to the factory on what part you are looking for information on'),
	        //'#required' => TRUE,
	        '#suffix' => '<span class="ui-state-error-text user-message"></span>'
	    );
	    $form['actions']['#type'] = 'actions';
	    $form['actions']['submit'] = [
	    	'#type' => 'submit',
	    	'#value' => $this->t('Submit'),
	    	'#button_type' => 'primary',
	    	'#attributes' => ['class' => ['btn btn-info use-ajax-submit']],	//	//use-ajax-submit
	    	'#ajax' => [
	    		'callback' => '::respondToAjax',
	    		'event' => 'click',
	    		'progress' => [
	    			'type' => 'throbber',
	    			'message' => 'Sending...',
	    		],
	    	],
	    ];

		return $form;
	}

	function submitForm(array &$form, FormStateInterface $form_state) {
		drupal_set_messag('YY');
	}

	function respondToAjax(array &$form, FormStateInterface $form_state) {
		
		$response = new AjaxResponse;
		$full_name = $form_state->getValue('full_name');
		if(empty($full_name)) {
			$css = ['border' => '1px solid red'];
			$message = t('Please enter your full name');
			$response->addCommand(new CssCommand('#edit-user-full-name', $css));
			$response->addCommand(new HtmlCommand('.user-full-name', $message));
		} 
		return $response;
	}
}