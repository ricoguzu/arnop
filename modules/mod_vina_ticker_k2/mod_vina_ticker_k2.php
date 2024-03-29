<?php
/*
# ------------------------------------------------------------------------
# Vina Item Ticker for K2 for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum: http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once dirname(__FILE__) . '/helper.php';

$items = modVinaK2ItemTickerHelper::getItems($params);

if(!count($items)) {
	echo 'No item found! Please check your config!';
	return;
}

// get params
$moduleclass_sfx 	= $params->get('moduleclass_sfx', '');
$itemTitle 			= $params->get('itemTitle', 1);
$itemIntroText		= $params->get('itemIntroText', 1);
$itemImage			= $params->get('itemImage', 1);
$itemImgSize		= $params->get('itemImgSize', 'Medium');
$itemImgSize		= "image" . $itemImgSize;
$itemCategory		= $params->get('itemCategory', 0);
$itemDateCreated	= $params->get('itemDateCreated', 0);
$itemHits			= $params->get('itemHits', 0);
$itemReadMore		= $params->get('itemReadMore', 1);
$linkOnTitle		= $params->get('linkOnTitle', 1);
$linkOnImage		= $params->get('linkOnImage', 1);

$moduleWidth	= $params->get('moduleWidth', '300px');
$moduleHeight	= $params->get('moduleHeight', 'auto');
$bgImage		 = $params->get('bgImage', NULL);
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}
$isBgColor		= $params->get('isBgColor', 1);
$bgColor		= $params->get('bgColor', '#43609C');
$modulePadding	= $params->get('modulePadding', '10px');

$headerBlock	= $params->get('headerBlock', 1);
$headerText		= $params->get('headerText', '');
$headerColor	= $params->get('headerTextColor', '#FFFFFF');
$controlButtons	= $params->get('controlButtons', 1);

$isItemBgColor	= $params->get('isItemBgColor', 1);
$itemBgColor	= $params->get('itemBgColor', '#FFFFFF');
$itemPadding	= $params->get('itemPadding', '10px');
$itemTextColor	= $params->get('itemTextColor', '#141823');
$itemLinkColor	= $params->get('itemLinkColor', '#3B5998');

$direction		= $params->get('direction', 'up');
$easing			= $params->get('easing', 'jswing');
$speed			= $params->get('speed', 'slow');
$interval		= $params->get('interval', 5000);
$visible		= $params->get('visible', 2);
$mousePause		= $params->get('mousePause', 1);

// include layout
require(JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default')));

// display copyright text
modVinaK2ItemTickerHelper::getCopyrightText($module);