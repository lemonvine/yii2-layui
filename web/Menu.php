<?php

namespace melon\web;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 *
 * @author lemonvine
 */
class Menu extends \yii\widgets\Menu
{
	
	public $options = ['class' => 'layui-nav layui-nav-tree layui-left-nav-tree layui-this'];
	public $submenuTemplate = "\n<dl class='layui-nav-child'>\n{items}\n</dl>\n";
	public $itemOptions = ['class'=>'layui-nav-item'];
	//public $linkTemplate = '<a href="{url}">{label}</a>';
	public $linkTemplate = '<a href="{url}">{icon}<span class="layui-left-nav"> {label}</span></a>';
	public $activeCssClass = 'layui-this';
	public $iconClassPrefix = 'fa fa-';
	public $defaultIcon = 'circle-o ';
	private $i=0;
	private $icons = ['text-primary', 'text-success', 'text-info', 'text-warning', 'text-danger', 'text-white', 'text-success', 'text-purple'];
	
	protected function renderItem6($item)
	{
		if (isset($item['items'])) {
			$labelTemplate = '<a href="{url}" class="nav-link">{icon}<p>{label}<i class="fa fa-angle-left right"></i></p></a>';
			$linkTemplate = '<a href="{url}" class="nav-link">{icon}<p>{label}<i class="fa fa-angle-left right"></i></p></a>';
		} else {
			$labelTemplate = $this->labelTemplate;
			$linkTemplate = $this->linkTemplate;
		}
		$active = '';
		if ($item['active']) {
			$active= 'active';
		}
		
		$defaulticon = str_replace("@i@", $this->icons[$this->i%8], $this->defaultIconHtml);
		$this->i++;
		$replacements = [
			'{label}' => strtr($this->labelTemplate, ['{label}' => $item['label'],]),
			'{icon}' => empty($item['icon']) ? $defaulticon
			: '<i class="' . static::$iconClassPrefix . $item['icon'] . ' nav-icon"></i> ',
			'{url}' => isset($item['url']) ? Url::to($item['url']) : 'javascript:;',
			'{name}' => $item['name'],
		];
		
		$template = ArrayHelper::getValue($item, 'template', isset($item['url']) ? $linkTemplate : $labelTemplate);
		
		return strtr($template, $replacements);
	}
	
	
	
	protected function renderItem($item)
	{
		if(isset($item['icon'])){
			$icon= $item['icon'];
		}else{
			$icon= $this->defaultIcon.$this->icons[$this->i%8];
			$this->i++;
		}
		if (isset($item['url'])) {
			$url = Html::encode(Url::to($item['url']));
		}else{
			$url = 'javascript:;';
		}
		$template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
		return strtr($template, [
			'{url}' => $url,
			'{label}' => $item['label'],
			'{icon}' => "<i class='{$this->iconClassPrefix}{$icon}'></i>",
		]);
		
		$template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
		
		return strtr($template, [
			'{label}' => $item['label'],
		]);
	}
	
	
}
