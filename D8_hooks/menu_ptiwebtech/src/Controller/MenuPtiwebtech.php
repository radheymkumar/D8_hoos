<?php

namespace Drupal\menu_ptiwebtech\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
/**
* 
*/
class MenuPtiwebtech extends ControllerBase
{
	
	function menu1() {
		return [
			'#markup' => t('This is first menu'),
		];
	}

	function permissioned() {
		$url = Url::fromRoute('menu_ptiwebtech.menu1');
		return ['#markup' => $this->t('This is link @link', 
					['@link' => Link::createFromRoute($url->getInternalPath(), $url->getRouteName())->toString(),
					]),
				];
	}

	function permissionedController() {

		return [
			'#markup' => $this->t('This is permissionedController'),
		];
	}

	function customAccess() {
		return [
			'#markup' => $this->t('This is customAccess'),
		];
	}

	function urlArgument($arg1, $arg2) {
		$url = Url::fromRoute('menu_ptiwebtech.urlArgument', ['arg1' => '11', 'arg2' => '22']);
		
		return [
			'#markup' => $this->t('This is urlArgument @arg', [
				'@arg' => Link::createFromRoute($url->getInternalPath(), $url->getRouteName(), $url->getRouteParameters())->toString(),
			]),
		];
	}

	function placeholderDisplay($arg) {
		//dsm($arg);

		//dprint_r($list);
		$list[] = t('This is first @f');
		$list[] = t('This is first @s', ['@s' => $arg]);
		$list[] = t('This is first @t', ['@t' => $arg]);
		//dsm($list);
		$renderArray['lists'] = [
			'#theme' => 'item_list',
			'#items' => $list,
			'#title' =>  $this->t('urlArgument'),
		];
		
		
		return $renderArray;
		/*return [
			'#markup' => $arg,
		];*/
	}
}