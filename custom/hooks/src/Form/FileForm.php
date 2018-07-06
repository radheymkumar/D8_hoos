<?php

namespace Drupal\hooks\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
/**
* 
*/
class FileForm extends FormBase
{
	
	public function getFormId() {
		return "FileForm_form";
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$form = array(
    		'#attributes' => array('enctype' => "multipart/form-data"),
  		);
		/*$form['host_info'] = array(
	        '#type' => 'select',
	        '#title' => t("Host Connection"),
	        '#options' => array(
	          'SSH2' => t('SSH2'),
	          'Web Service' => t('Web Service'),
	        ),
	        '#description' => t("Specify the connection information to the host"),
	        '#required' => TRUE,
	    );

	    $form['ssh_host'] = array(
	        '#type' => 'checkbox',
	        '#title' => t("Host Address"),
	        '#description' => t("Host address of the SSH2 server"),
	        '#states' => array(
	            'visible' => array(
	                ':input[name=host_info]' => array('value' => t('SSH2')),
	            ),
	            'required' => array(
	                ':input[name=host_info]' => array('value' => t('SSH2')),
	            ),
	        ),
	    );*/

	    /*$form['attachment'] = [
	    	'#type' => 'managed_file',
	    	'#title' => t('Attachment'),
	    	'#upload_location' => 'public://attachments/',
	    	'#description' => t('Allowed types: jpg jpeg png gif'),
	    	'#upload_validators' => [
	    		'file_validate_extensions' => array('jpg jpeg png gif'),
	    	],
	    	'#required' => TRUE,
	    ];*/
	    $form['attachment2'] = [
	    	'#type' => 'file',
	    	'#title' => t('Attachment 2'),
	    	'#description' => t('Allowed types: jpg jpeg png gif'),
	    ];
	    
	    $form['actions']['submit'] = [
			'#type' => 'submit',
			'#value' => t('handleManagedFile'),
			'#submit' => ['::handleManagedFile'],
		];
		return $form;
	}

	public function validateForm( array &$form, FormStateInterface $form_state) {

	}

	public function submitForm( array &$form, FormStateInterface $form_state) {
		drupal_set_message('Saves');
	}

	function handleManagedFile(array &$form, FormStateInterface $form_state) {
		//echo "<pre>";
		$validators = array(
			'file_validate_is_image' => array(),
			'file_validate_extensions' => array('jpeg jpg png gif'));
							//	  field_name     validate      path OR false   file_rename  
		$files = file_save_upload('attachment2', $validators, 'public://', FILE_EXISTS_RENAME);
		
		$file = File::load($files->id());
		$file->setPermanent(TRUE);
		$file->save();
		drupal_set_message('Saved : ' . $file->getFilename());

		//$fid = $form_state->getValue(['attachment', 0]);
		/*$attach = $form_state->getValue('attachment');
		$newFile = \Drupal\file\Entity\File::load(reset($attach));	
		$newFile->setPermanent();
		drupal_set_message('Saved : ' . $newFile->getFilename());*/


		/*dsm($newFile->getFileUri());
		dsm($newFile->getCreatedTime());
		dsm($newFile->getFilename());
		dsm($newFile->getMimeType());
		dsm($newFile->getOwner());
		dsm($newFile->getOwnerId());
		dsm($newFile->getSize());
		dsm($newFile->isTemporary());
		dsm($newFile->isPermanent());*/
		

	}
}