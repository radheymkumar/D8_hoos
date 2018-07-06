<?php
//	https://arrea-systems.com/autocomplete_search_items
namespace Drupal\hooks\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* 
*/
class AutocompleteForm extends FormBase
{
	
	public function getFormId() {
		return 'Autocomplete_Form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$form = [];
		$form['name'] = [
			'#type' => 'textfield',
			'#id' => t('product-search-form'),
			'#title' => $this->t('User Name'),
			'#size' => 50,
			'#autocomplete_route_name' => 'hooks.autocomplete_path',
			'#attributes' => ['placeholder' => t('Enter User id or name')],
			'#description' => t("eg - ['Value 1', 'Value 2', 'Value 3']"),
			//'#attached' => ['library' => ['hooks/hook.autocomplete']],
		];
		
		$form['list_items'] = [
			'#type' => 'item',
			'#markup' => "<div id='product-search-result'></div>",
		];

		$form['actions']['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Submit'),
			//'#submit' => ['::submit_handler'],
		];
		$form['actions']['reset'] = [
			'#type' => 'button',
			'#value' => $this->t('Reset'),
			'#validate' => array(),
			'#attributes' => ['onclick' => 'this.form.reset(); return false;'],
		];
		$form['actions']['reset_link'] = [
		   '#type' => 'markup',
		   '#markup' => '<a href="#">' .t('Link') . '<a/>',
		];

		return $form;
	}

	public function validateForm( array &$form, FormStateInterface $form_state) {

	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		drupal_set_message($form_state->getValue('name'));
	}

	function submit_handler(array &$form, FormStateInterface $form_state) {

	}
}