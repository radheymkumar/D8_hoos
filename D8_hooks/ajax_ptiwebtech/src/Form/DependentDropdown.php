<?php

namespace Drupal\ajax_ptiwebtech\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
/**
* 
*/
class DependentDropdown extends FormBase
{
	
	function getFormId() {
		return 'DependentDropdown_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		$form['info'] = [
      		'#markup' => $this->t('<p>Like other examples in this module, this form has a path that can be modified with /nojs to 	
      			simulate its behavior without JavaScript.</p>
      			<ul>
      				<li>@try_it_without_ajax</li>
      				<li>@try_it_with_ajax</li>
      				<li>@getText</li>
      			</ul>',
      	       [
        		'@try_it_without_ajax' => Link::createFromRoute($this->t('Try it without AJAX'),
        			'ajax_ptiwebtech.ajaxexampleform')->toString(),
        		'@try_it_with_ajax' => Link::createFromRoute($this->t('Try it with AJAX'),
        			'ajax_ptiwebtech.ajaxexampleform')->toString(),
        		]
      		),
    	];

    	$form['fieldset1'] = [
    		'#type' => 'fieldset',
    		'#title' => $this->t('Choose an instrument family'),
    	];

    	$instrument_family_options = static::instrument_family_dropdownload();
    	if(empty($form_state->getValue('instrument_family_dropdownload'))) {
    		$select_family = key($instrument_family_options);
    	} else {
    		$select_family = $form_state->getValue('instrument_family_dropdownload');
    	}


    	$form['fieldset1']['instrument_family_dropdownload'] = [
    		'#type' => 'select',
    		'#title' => $this->t('Instrument Type'),
    		'#options' => $instrument_family_options,
    		'#default_value' => $select_family,
    		'#ajax' => [
    			'callback' => '::instrumentDropdownCallback',
    			'wrapper' => 'instrument-fieldset-container',
    			'progress' => [
    				'type' => 'throbber',
    				'message' => t('Just checking'),
    			],
    		],

    	];
    	$form['fieldset1']['choose_family'] = [
    		'#type' => 'submit',
    		'#value' =>  $this->t('Choose'),
    		'#attributes' => ['class' => ['ajax-example-hide','ajax-example-inline'], 'id' => ['edit-choose-family','my-chooses']],
    	];


    	$form['instrument_field_container'] = [
    		'#type' => 'container',
    		'#attributes' => ['id'=>'instrument-fieldset-container'],
    	];
    	$form['instrument_field_container']['fieldset2'] = [
    		'#type' => 'fieldset',
    		'#title' => $this->t('Choose an instrument family'),
    	];
    	$form['instrument_field_container']['fieldset2']['instrument_dropdown'] = [
    		'#type' => 'select',
    		'#title' => $this->t('Instrument instrument_dropdown'),
    		'#options' => static::getSecondDropdownOptions($select_family),

    	];
		return $form;
	}

	function submitForm(array &$form, FormStateInterface $form_state) {

	}

	function instrument_family_dropdownload() {
		return [
			'none' => 'none',
	     	'String' => 'String',
	      	'Woodwind' => 'Woodwind',
	      	'Brass' => 'Brass',
	      	'Percussion' => 'Percussion',
		];
	}

	function instrumentDropdownCallback(array $form, FormStateInterface $form_state) {
		return $form['instrument_field_container'];	
	}

	public static function getSecondDropdownOptions($key = '') {
    switch ($key) {
      case 'String':
        $options = [
          'Violin' => 'Violin',
          'Viola' => 'Viola',
          'Cello' => 'Cello',
          'Double Bass' => 'Double Bass',
        ];
        break;

      case 'Woodwind':
        $options = [
          'Flute' => 'Flute',
          'Clarinet' => 'Clarinet',
          'Oboe' => 'Oboe',
          'Bassoon' => 'Bassoon',
        ];
        break;

      case 'Brass':
        $options = [
          'Trumpet' => 'Trumpet',
          'Trombone' => 'Trombone',
          'French Horn' => 'French Horn',
          'Euphonium' => 'Euphonium',
        ];
        break;

      case 'Percussion':
        $options = [
          'Bass Drum' => 'Bass Drum',
          'Timpani' => 'Timpani',
          'Snare Drum' => 'Snare Drum',
          'Tambourine' => 'Tambourine',
        ];
        break;

      default:
        $options = ['none' => 'none'];
        break;
    }
    return $options;
  }
}