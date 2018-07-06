<?php
 
namespace Drupal\block_ptiwebtech\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
	* @Block(
*		id = "example_uppercase",
*		admin_label = @Translation("Example: PtiwebtechMarkupBlock")
*	)
 */
class PtiwebtechMarkupBlock extends BlockBase
{
	
	public function blockForm($form , FormStateInterface $form_state) {
		
		//$form = parent::blockForm($form, $form_state);
		$config = $this->getConfiguration();
		$form['str_text'] = [
			'#type' => 'textarea',
			'#title' => t('Block Content'),
			'#description' => t('This text will appear in the example block.'),
			'#default_value' => isset($config['str_text']) ? $config['str_text'] : '',
		];

		return $form;
	}

	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->setConfigurationValue('str_text', $form_state->getValue('str_text'));
	}

	public function build() {

		$config = $this->getConfiguration();
		$blockMsg = isset($config['str_text']) ? $config['str_text'] : '';
		
		return [
		'#markup' => $this->t($blockMsg),
		];

		/*$form = \Drupal::formBuilder()->getForm('Drupal\ajax_ptiwebtech\Form\AjaxExampleForm');
    	return $form;*/

	}


}