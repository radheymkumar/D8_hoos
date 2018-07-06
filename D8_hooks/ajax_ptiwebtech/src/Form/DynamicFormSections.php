<?php

namespace Drupal\ajax_ptiwebtech\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* 
*/
class DynamicFormSections extends FormBase
{
	
	function getFormId() {
		return 'DynamicFormSections_form';
	}

	function buildForm(array $form, FormStateInterface $form_state) {
		
    $form['question_select_type'] = [
      '#type' => 'select',
      '#title' => t('Question Type'),
      '#options' => [
        'Choose question style' => 'Choose question style',
        'Multiple Choice' => 'Multiple Choice',
        'True/False' => 'True/False',
        'Fill-in-the-blanks' => 'Fill-in-the-blanks',
      ],
      '#ajax' => [
        'callback' => '::promptCallback',
        'wrapper' => 'questions-fieldset-wrapper',
        'progress' => [
          'type' => 'throbber', // bar
          'message' => 'Search questions',
        ],
      ],
    ];

    $form['question_type_submit'] = [
      '#type' => 'submit',
      '#value' => t('Choose'),
      '#attributes' => ['class' => ['ajax-example-inline']],
      '#limit_validation_errors' => [],
      '#validate' => [],
    ];

    $form['fieldset1'] = [
      '#type' => 'details',
      '#title' => $this->t('Stuff will appear here'),
      '#open' => True,
      '#attributes' => ['id' => ['questions-fieldset-wrapper']],
    ];

    $question_type = $form_state->getValue('question_select_type');
    
    if(!empty($question_type) && $question_type != 'Choose question style') {
      //drupal_set_message('<pre>'.print_r($question_type,True));
      $form['fieldset1']['question'] = [
        '#markup' => t('Who was the first president of the U.S.?'),
      ];
      switch ($question_type) {
        case 'Multiple Choice':
          $form['fieldset1']['question'] = [
            '#type' => 'select',
            '#title' => t('Select New Question'),
            '#options' => [
                'George Bush' => 'George Bush',
                'Adam McGuire' => 'Adam McGuire',
                'Abraham Lincoln' => 'Abraham Lincoln',
                'George Washington' => 'George Washington'
            ],
          ];  
          break;
        case 'True/False':
          $form['fieldset1']['question'] = [
            '#type' => 'radios',
            '#title' => $this->t('Was George Washington the first president of the United States?'),
            '#options' => ['George' => 'True', 'Washington' => 'False'],
          ];
          break;
        case 'Fill-in-the-blanks':
          $form['fieldset1']['question'] = [
            '#type' => 'textfield',
            '#title' => t('New Questions'),
            '#description' => t('This is next questions here'),
          ];
          break;  
      }
      
      $form['fieldset1']['submit'] = [
        '#type' => 'submit',
        '#value' => 'Submit Your Answer',
      ];

    }

    return $form;

	}

	function submitForm(array &$form, FormStateInterface $form_state) {
      //drupal_set_message('<pre>'.print_r($form_state->getValue()));
      if ($form_state->getValue('question_type_submit') == 'Choose') {
        $form_state->setValue('question_select_type', $form_state->getUserInput()['question_select_type']);
        $form_state->setRebuild();
      }
      
      if($form_state->getValue('submit') == 'Submit Your Answer') {
        $form_state->setRebuild(FALSE);
        $answar = $form_state->getValue('question');
          if($answar == $this->t('George')) {
            drupal_set_message('okkk');
          }
      }
    $form_state->setRebuild();
    
	}

  function promptCallback(array $form, FormStateInterface $form_state) {
    return $form['fieldset1'];
  }

}