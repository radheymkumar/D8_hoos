<?php

namespace Drupal\hooks\Controller;

use Drupal\Core\Controller\ControllerBase;
#use Drupal\Core\Entity\EntityInterface;
/*use Drupal\node\Entity\Node;
use Drupal\Core\Entity;*/
use Drupal\Core\Database\Database;
use Drupal\image\Entity\ImageStyle;

use Drupal\Component\Render\FormattableMarkup;
/**
* 
*/
class MessageTemplate extends ControllerBase
{
	public function tables_list() {
		$header = [
			'nid' => t('Nid'),
			['data' => ('Title'), 'field' => 'title','sort'=>'asc'],
			'type' => t('Type'),
			'status' => t('Status'),
			'uid' => t('Uid'),
			'created' => t('Created'),
			'changed' => t('Changed'),
			'body' => t('Body'),
			'fname' => t('FName'),
			'tags' => t('Tags'),
			'image' => t('Image'),
		];
		$query = \Drupal::database()->select('node_field_data','n');
		$query->join('node__body','b', 'n.nid=b.entity_id');
		$query->join('node__field_first_name','fn', 'n.nid=fn.entity_id');
		$query->join('node__field_tags','t', 'n.nid=t.entity_id');
		$query->join('taxonomy_term_field_data','tfd', 't.field_tags_target_id=tfd.tid');
		$query->join('node__field_image','fi', 'n.nid=fi.entity_id');
		$query->join('file_managed','fm','fi.field_image_target_id=fm.fid');
		$query->fields('n');
		$query->fields('b',['body_value','body_format']);
		$query->fields('fn',['field_first_name_value']);
		$query->fields('t',['field_tags_target_id']);
		$query->fields('tfd',['name']);
		$query->fields('fi',['field_image_target_id']);
		$query->fields('fm',['uri']);
		$query->condition('n.type','article','=');
		$table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
		$pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
		$result = $pager->execute()->fetchAll();
		
		//file_create_url

		foreach ($result as $data) {
			//$row[] = (array)$data;
			$row[] = [
				'nid' => $data->nid,
				'title' => new FormattableMarkup('<b>:title</b>',[':title' => $data->title]),
				'type' => $data->type,
				'status' => $data->status,
				'uid' => $data->uid,
				'created' => format_date($data->created),
				'changed'=> date('\o\n D \a\t M Y', $data->changed),
				'body_value' => self::body_sub_str_lenght($data->body_value),
				//'body_value' => MessageTemplate::body_sub_str_lenght($data->body_value),
				'fname' => self::body_sub_str_lenght($data->field_first_name_value),
				'tags' => $data->name,
				'image' =>  new FormattableMarkup('<img src=":img"/>', [':img' => ImageStyle::load('thumbnail')->buildUrl($data->uri)]),
			];
		}
		
		$form['table'] = [
			'#type' => 'table',
			'#header' => $header,
			'#rows' => $row,
			'#empty' => t('No record found...'),
		];
		$form['pager'] = [
			'#type' => 'pager'
		];

		return $form;

	}

	function body_sub_str_lenght($data) {
		$str = strlen($data);
		if($str > 20) {
			return substr($data, 0,20).'...';
		} else {
			return $data;
		}
	}

	public function description() {
		//$node = Node::load(48);
		//$node = entity_load('node', 47);
		//$node = entity_load('user', 1);
		//$entity = \Drupal::entityTypeManager()->getStorage('user')->load(1);
		//$entities = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple([46,47,48]);
		//$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);

		//dsm($entities);

		$list = [
			'apple' => t('Apple'),
			'book' => t('Book'),
			'cat' => t('Cat'),
			'one' => t('One'),
			'two' => t('Two'),
			'three' => t('Three'),
		];

		$list2 = [
			'apple' => t('Apple'),
			'book' => t('Book'),
			'cat' => t('Cat'),
			'one' => t('One'),
			'two' => t('Two'),
			'three' => t('Three'),
		];

		$arg = 'radhey';
		$form = \Drupal::formBuilder()->getForm('Drupal\hooks\Form\FormTemplate');
		return [
			'#theme' => 'message_template',
			'#test_var' => $list,
			'#test_var2' => $list2,
			'#my_from' => $form,
			'#form_arg' => $arg,
		];

		/*return [
			'#markup' => t('This is messageContents'),
		];*/
	}

	public function twig_code_example() {
		return [
			'#theme' => 'twig_code_example_template',
		];
	}
}