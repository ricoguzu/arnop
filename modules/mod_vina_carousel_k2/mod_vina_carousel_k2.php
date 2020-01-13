<?php
/*
# ------------------------------------------------------------------------
# Vina Item Carousel for K2 for Joomla 3
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

$items = modVinaK2ItemCarouselHelper::getItems($params);

if(!count($items)) {
	echo 'No item found! Please check your config!';
	return;
}

// get params
$moduleclass_sfx 	= $params->get('moduleclass_sfx', '');
$moduleWidth	= $params->get('moduleWidth', 	'100%');
$moduleHeight	= $params->get('moduleHeight', 	'auto');
$moduleMargin	= $params->get('moduleMargin', 	'0px');
$modulePadding	= $params->get('modulePadding', '10px');
$bgImage		= $params->get('bgImage', 		null);
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}
$isBgColor		= $params->get('isBgColor', 	1);
$bgColor		= $params->get('bgColor', 		'#CCCCCC');
$itemMargin		= $params->get('itemMargin', 	'0 5px');
$itemPadding	= $params->get('itemPadding', 	'10px');
$isItemBgColor	= $params->get('isItemBgColor', 1);
$itemBgColor	= $params->get('itemBgColor', 	'#FFFFFF');
$itemTextColor	= $params->get('itemTextColor', '#333333');
$itemLinkColor	= $params->get('itemLinkColor', '#0088CC');

// display params
$itemTitle 			= $params->get('itemTitle', 1);
$itemIntroText		= $params->get('itemIntroText', 1);
$itemImage			= $params->get('itemImage', 1);
$itemImgSize		= $params->get('itemImgSize', 'Medium');
$itemImgSize		= "image" . $itemImgSize;
$itemCategory		= $params->get('itemCategory', 0);
$itemDateCreated	= $params->get('itemDateCreated', 0);
$itemHits			= $params->get('itemHits', 0);
$itemReadMore		= $params->get('itemReadMore', 1);

// carousel params
$itemsVisible		= $params->get('itemsVisible', 		4);
$itemsDesktop		= $params->get('itemsDesktop', 		'[1170,4]');
$itemsDesktopSmall	= $params->get('itemsDesktopSmall', '[980,3]');
$itemsTablet		= $params->get('itemsTablet', 		'[800,3]');
$itemsTabletSmall	= $params->get('itemsTabletSmall', 	'[650,2]');
$itemsMobile		= $params->get('itemsMobile', 		'[450,1]');
$singleItem			= $params->get('singleItem', 		0);
$itemsScaleUp		= $params->get('itemsScaleUp', 		0);
$slideSpeed			= $params->get('slideSpeed', 		200);
$paginationSpeed	= $params->get('paginationSpeed', 	800);
$rewindSpeed		= $params->get('rewindSpeed', 		1000);
$autoPlay			= $params->get('autoPlay', 			5000);
$stopOnHover		= $params->get('stopOnHover', 		1);
$navigation			= $params->get('navigation', 		0);
$rewindNav			= $params->get('rewindNav', 		1);
$scrollPerPage		= $params->get('scrollPerPage', 	0);
$pagination			= $params->get('pagination', 		1);
$paginationNumbers	= $params->get('paginationNumbers', 0);
$responsive			= $params->get('responsive', 		1);
$autoHeight			= $params->get('autoHeight', 		0);
$mouseDrag			= $params->get('mouseDrag', 		1);
$touchDrag			= $params->get('touchDrag', 		1);

// include layout
require(JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default')));

// display copyright text
modVinaK2ItemCarouselHelper::getCopyrightText($module);