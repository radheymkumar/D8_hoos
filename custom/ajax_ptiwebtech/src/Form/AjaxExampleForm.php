<?php
namespace Drupal\ajax_ptiwebtech\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\CssCommand;	
//use Drupal\Core\Ajax\ChangedCommand;
use \Drupal\user\Entity\User;
/**
* 
*/
class AjaxExampleForm extends FormBase
{
	
	function getFormId() {
		return 'Ajax_Example_Form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		$form = [];
		$form['user_email'] = [
			'#type' => 'textfield',
			'#title' => t('User Email'),
			'#description' => t('Please enter in a user or email'),
			'#prefix' => '<div id="user-email-result"></div>',
			'#ajax' => [
				'callback' => '::checkUserEmailValidation',
				'effect' => 'fade',
				'event' => 'change',
				'progress' => array(
					'type' => 'throbber',
					'message' => NULL,
				),
			],
		];
		$form['input'] = [
		  '#type' => 'textfield',
		  '#title' => 'A Textfield',
		  '#description' => 'Enter a number to be validated via ajax.',
		  '#size' => '60',
		  '#maxlength' => '10',
		  '#required' => TRUE,
		  '#ajax' => [
		    'callback' => '::sayHello',
		    'event' => 'keyup',	// change keyup
		    'wrapper' => 'edit-output',
		    'progress' => [
		      'type' => 'throbber',
		      'message' => t('Verifying entry...'),
		    ],
		  ],
		];
		$form['user_email2'] = [
			'#type' => 'textfield',
			'#title' => t('User Email'),
			'#attributes' => [
				'id' => 'edit-output',
			],
		];
		$states = static::getStateList();
		$form['states'] = [
			'#title' => t('State List'),
			'#type' => 'select',
			'#options' => $states,
			'#ajax' => [
				'callback' => '::statesSelect',
				'event' => 'change',
				'wrapper' => 'edit-output',
				'progress' => [
					'type' => 'throbber',
					'message' => t('Check entry'),
				],
			],
		];

		return $form;

	}

	function submitForm( array &$form, FormStateInterface $form_state) {

	}

	function checkUserEmailValidation(array $form, FormStateInterface $form_state) {
		$ajax_response = new AjaxResponse();
		
		//get field value 
		//$email = $form_state->getValue('user_email');
		
		// check user name and email
		/*if(user_load_by_name($form_state->getValue('user_email')) || user_load_by_mail($form_state->getValue('user_email'))) {
			$email = 'User or Email  is exists';
		} else {
			$email = '<b>User or Email does not exists</b>';
		}*/

		// check user name and email  AND add css
		if(user_load_by_name($form_state->getValue('user_email')) || user_load_by_mail($form_state->getValue('user_email'))) {
			$email = 'User Found';
			$color = 'green';
		} else {
			$email = 'User Not Found';
			$color = 'red';
 		}		
 		//AJAX command for calling the jQuery html() method.
		$ajax_response->addCommand(new HtmlCommand('#user-email-result', $email ));

		//AJAX command for invoking an arbitrary(man mana) jQuery method.
		$ajax_response->addCommand(new InvokeCommand('#user-email-result', 'css', array('color', $color)));

		//An AJAX command for adding css to the page via ajax.
		$ajax_response->addCommand(new CssCommand('.page-title',['color'=>'green']));

		return $ajax_response;
	}

	public function sayHello(array &$form, FormStateInterface $form_state) : array {
	  $elem = [
	    '#type' => 'textfield',
	    '#size' => '60',
	    '#disabled' => TRUE,
	    '#value' => 'Hello, ' . $form_state->getValue('input') . '!',
	    '#attributes' => [
	      'id' => ['edit-output'],
	    ],
	  ];

	  return $elem;
	}

	public function getStateList() {
		$states = [
			'Rajasthan' => 'Rajasthan',
			'Hariyana' => 'Hariyana',
			'Delhi' => 'Delhi',
			'Panjab' => 'Panjab'
		];
		return $states;
	}

	function statesSelect( array &$form, FormStateInterface $form_state) {
		$elem = [
		    '#type' => 'textfield',
		    '#size' => '60',
		    '#disabled' => TRUE,
		    '#value' => 'Hello, ' . $form_state->getValue('states') . '!',
		    '#attributes' => [
		      'id' => ['edit-output'],
		    ],
	  	];
	  return $elem;
	}

}

