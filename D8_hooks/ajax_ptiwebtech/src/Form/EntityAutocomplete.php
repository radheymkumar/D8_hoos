<?php
namespace Drupal\ajax_ptiwebtech\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
/**
* 
*/
class EntityAutocomplete extends FormBase
{
	
	function getFormId(){
		return 'entityautocomplete_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		$form['info'] = [
			'#markup' => $this->t('This is EntityAutocomplete Ajax'),
		];

		$form['users'] = [
			// A type of entity_autocomplete lets Drupal know it should autocomplete entities.
			'#type' => 'entity_autocomplete',
			// Specifying #tags as TRUE allows for multiple selections, separated by commas.
			'#tags' => TRUE,
			// We can specify entity types to autocomplete.
			'#target_type' => 'user',
			'#title' => t('Choose a user. Separate with commas.'),
		];
		$form['terms'] = [
			'#type' => 'entity_autocomplete',
			'#target_type' => 'taxonomy_term',
			'#selection_settings' => [
				'include_anonymous' => FALSE,
				'target_bundles' => ['category','tags'],	
			],
			'#title' => t('Choose a Terms. Separate with commas.'),
		];
		$form['nodes'] = [
			'#type' => 'entity_autocomplete',
			'#target_type' => 'node',
			'#tags' => TRUE,
			'#selection_settings' => [
				'target_bundles' => ['page','article'],
			],
			'#title' => t('Choose a Nodes. Separate with commas.'),
		];

		// https://drupal.stackexchange.com/questions/200038/adding-autocomplete-for-text-field
		// https://www.lucius.digital/en/blog/drupal-module-conditional-redirect-released-on-drupal-org
		/*$form['my_autocomplete_search'] = [
			'#type' => 'entity_autocomplete',
		    '#title' => t('My Entity'),
		    '#default_value' => '',
		    '#autocomplete_path' => 'entity-autocomplete/myentity',
		];*/

		$form['actions'] = [
	      	'#type' => 'actions',
	    ];
	    $form['actions']['submit'] = [
	    	'#type' => 'submit',
	    	'#value' => $this->t('Submit'),
	    ];
	   /* $form['actions']['submit2'] = [
	    	'#type' => 'submit',
	    	'#value' => $this->t('Reset'),
	    ];
	    $form['actions']['submit3'] = [
	    	'#type' => 'submit',
	    	'#value' => $this->t('Preview'),
	    ];*/

		return $form;
	}

	function validateForm(array &$form, FormStateInterface $form_state) {
		$state_users = $form_state->getValue('users');
		if(empty($state_users)) {
			$form_state->setErrorByName('users', $this->t('There were no users seleted.'));
		}
	}

	function submitForm(array &$form, FormStateInterface $form_state) {
		$state_users = $form_state->getValue('users');
		/*echo "<pre>";
		foreach ($state_users as $state_user) {
			$uid = $state_user['target_id'];
			 $users[]  = \Drupal::entityManager()->getStorage('user')->load($uid);
		}*/
			print_r($state_users);
		die;
	}
}