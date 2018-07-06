<?php
namespace Drupal\ajax_ptiwebtech\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* 
*/
class Simplest extends FormBase
{
	
	function getFormId() {
		return 'Simplest_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		$form['choose'] = [
			'#type' => 'select',
			'#title' => $this->t('Choose This'),
			'#options' => [
				'' => '--Select--',
				'one' => 'one',
		        'two' => 'two',
		        'three' => 'three',
        	],
        	'#ajax' => [
        		'callback' => '::prompt',
        		'wrapper' => 'replace-textfield',
        	],
		];

		$form['text_area_fieldset'] = [
			'#type' => 'container',
			'#attributes' => ['id' => ['replace-textfield']],
		];
		$form['text_area_fieldset']['myfields'] = [
			'#type' => 'textfield',
			'#title' => t('My Fields'),
		];

		$value = $form_state->getValue('choose');
		if(!$value !== NULL) {
			$form['text_area_fieldset']['myfields']['#title'] = 'My Fields ' . $value;
			$form['text_area_fieldset']['myfields']['#description'] = $this->t("Say why your choose @value",['@value' => $value]);
			$form['text_area_fieldset']['myfields']['#value'] = $value;
		}
		/*echo "<Pre>";
		print_r();
		echo "</Pre>";*/

		$form['action']['submit'] = [	
			'#type' => 'submit',
			'#value' => t('Submit'),
			'#ajax' => [
				'callback' => '::promptCallback',
				'wrapper' => 'replace-submit',
			],
		];
		$form['container2'] = [
			'#type' => 'container',
			'#attributes' => ['id'=>['replace-submit']],
		];

		if($value == 'three') {
			$form['container2']['box'] = [
				'#type' => 'markup',
				'#markup' => '<h1>Initial markup for box</h1>',
			];
		}
		return $form;
	}

	function submitForm( array &$form, FormStateInterface $form_state) {

	}

	function prompt($form, FormStateInterface $form_state) {
		return $form['text_area_fieldset'];
	}

	function promptCallback(array &$form, FormStateInterface $form_state) {
		$ele =  $form['container2'];
		$ele['box']['#markup'] = "Click Submit $form_state->getValue('choose') : ({ $form_state->getValue('op')}): " . date('c');
		return $ele;
	}
}