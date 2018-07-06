<?php
namespace Drupal\hooks\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use \Drupal\Core\Render\Element\Table;
use Drupal\Core\Render\Element;
/**
* 
*/
class TablePage extends FormBase
{
	
	public function getFormId() {
		return 'tablepage_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$header = [
			'nid' => t('Nid'),
			'title' => t('Title'),
			'type' => t('Type'),
			'status' => t('Status'),
			'operations' => t('Operations'),
			'destination' => t('Destination'),
		];
		$query = \Drupal::database()->select('node_field_data','n');
		$query->fields('n');
		$query->condition('n.type','article','=');
		$table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
		$pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
		$result = $pager->execute()->fetchAll();

		foreach ($result as $data) {
			//$row[] = (array)$data;
			// URL Example
		  	// $url = Url::fromUri('internal:/reports/search/'.$data->nid);	//Internal example
		  	// $url = Url::fromUri('http://drupal.org');	// External example

			$option = [
			    //'query' => ['node' => $data->nid],
			    'attributes' => [
					'class' => [
						'use-ajax','book',
					],
					'data-dialog-type' => ['modal'],
					'data-dialog-options'=> ['{"height":"475","width":"940"}'],
				],
		  	];
			$url = Url::fromUri('internal:/node/'.$data->nid, $option); //  Option example Query strings
			
			$destination = [
					'query' => ['destination' => 'node/'.$data->nid],
				];
			$destination = Url::fromUri('internal:/user/login', $destination); //  Option example Query strings	
			$row[$data->nid] = [
				'nid' => $data->nid,
				'title' => $data->title,
				'type' => $data->type,
				'status' => $data->status,
				//'operations' => \Drupal::l(t('View','test'),new Url('my.routing',['rought_parameter' => $custom_varabile], ['attributes' => ['class' => ['btns']]])),
				'operations' => \Drupal::l(t('View'),$url),
				'destination' => \Drupal::l(t('View'),$destination),
			];
		}

		$form['status'] = [
			'#type' => 'select',
			'#title' => t('Status'),
			'#options' => [1 => 'Publish', 0 => 'Unpublish', 2 => 'Delete', 3 => 'Unpublish Content',],
			'#default_value' => '', //isset($form_state['storage']['status']) ? $form_state['storage']['status'] : '',       
		];

		$form['table'] = [
			'#type' => 'tableselect',
			'#header' => $header,
			'#options' => $row,
			'#empty' => t('No record found...'),
		];
		$form['pager'] = [
			'#type' => 'pager'
		];
		$form['submit'] = array(
		    '#type' => 'submit',
		    '#value' => t('Submit'),
		  );

		$list[] = t('This is first @f');
		$list[] = t('This is first @s');
		$list[] = t('This is first @t');

		$form['list'] = [
			'#theme' => 'item_list',
			'#title' => 'My List',	
			'#items' => $list,
			'#list_type' => 'ol',
			'#attributes' => ['class' => 'mylist'],
  			'#wrapper_attributes' => ['class' => 'container'],
			'#empty' => t('No record found...'),
		];

		return $form;
	}

	public function validateForm(array &$form, FormStateInterface $form_state) {

	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		$values = $form_state->getValues();
		//echo "<pre>";
		//print_r($values);
		//https://www.metaltoad.com/blog/drupal-8-entity-api-cheat-sheet
		$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($values['table']);
		if($values['status'] == 0 || $values['status'] == 1) {
			foreach ($nodes as $node) {
				$node->set('status', $values['status']);
				$node->save();
			} 
		}
		if($values['status'] == 2) {
			foreach ($nodes as $value) {
				$value->delete();
			}
		}

		if($values['status'] == 3) {

		}	
		
	}
}