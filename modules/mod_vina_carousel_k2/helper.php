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

require_once JPATH_SITE .'/components/com_k2/helpers/route.php';
require_once JPATH_SITE.'/components/com_k2/helpers/utilities.php';

class modVinaK2ItemCarouselHelper
{
	public static function getItems(&$params, $format = 'html')
	{
		jimport('joomla.filesystem.file');
		
		$mainframe 	= JFactory::getApplication();
		$limit 		= $params->get('itemCount', 5);
		$cid 		= $params->get('category_id', NULL);
		$ordering 	= $params->get('itemsOrdering', '');
		
		$componentParams 	= JComponentHelper::getParams('com_k2');
		$limitstart 		= JRequest::getInt('limitstart');

		$user 	= JFactory::getUser();
		$aid 	= $user->get('aid');
		$db 	= JFactory::getDBO();

		$jnow 		= JFactory::getDate();
		$now 		=  K2_JVERSION == '15' ? $jnow->toMySQL() : $jnow->toSql();
		$nullDate 	= $db->getNullDate();
		
		if($params->get('source') == 'specific')
		{
			$value 	 = $params->get('items');
			$current = array();
			
			if(is_string($value) && !empty($value)) $current[] = $value;
			if(is_array($value)) $current = $value;

			$items = array();
			
			foreach($current as $id)
			{

				$query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams 
				FROM #__k2_items as i 
				LEFT JOIN #__k2_categories c ON c.id = i.catid 
				WHERE i.published = 1 ";
				
				if(K2_JVERSION != '15')
				{
					$query .= " AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
				}
				else
				{
					$query .= " AND i.access<={$aid} ";
				}
				
				$query .= " AND i.trash = 0 AND c.published = 1 ";
				
				if(K2_JVERSION != '15') 
				{
					$query .= " AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
				}
				else
				{
					$query .= " AND c.access<={$aid} ";
				}
				
				$query .= " AND c.trash = 0 
				AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." ) 
				AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." ) 
				AND i.id={$id}";
				
				if(K2_JVERSION != '15')
				{
					if($mainframe->getLanguageFilter())
					{
						$languageTag = JFactory::getLanguage()->getTag();
						$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
					}
				}
				
				$db->setQuery($query);
				$item = $db->loadObject();
				
				if($item) $items[] = $item;
			}
		}
		else
		{
			$query = "SELECT i.*, CASE WHEN i.modified = 0 THEN i.created ELSE i.modified END as lastChanged, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";
			
			if ($ordering == 'best')
				$query .= ", (r.rating_sum/r.rating_count) AS rating";

			if ($ordering == 'comments')
				$query .= ", COUNT(comments.id) AS numOfComments";

			$query .= " FROM #__k2_items as i RIGHT JOIN #__k2_categories c ON c.id = i.catid";

			if ($ordering == 'best')
				$query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";

			if ($ordering == 'comments')
				$query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";

			if(K2_JVERSION != '15')
			{
				$query .= " WHERE i.published = 1 AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") AND i.trash = 0 AND c.published = 1 AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).")  AND c.trash = 0";
			}
			else
			{
				$query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";
			}

			$query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
			$query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";

			if($params->get('catfilter'))
			{
				if(!is_null($cid))
				{
					if(is_array($cid))
					{
						if($params->get('getChildren'))
						{
							$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
							$categories = $itemListModel->getCategoryTree($cid);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";
						}
						else
						{
							JArrayHelper::toInteger($cid);
							$query .= " AND i.catid IN(".implode(',', $cid).")";
						}
					}
					else
					{
						if($params->get('getChildren'))
						{
							$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
							$categories = $itemListModel->getCategoryTree($cid);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";
						}
						else
						{
							$query .= " AND i.catid=".(int)$cid;
						}
					}
				}
			}
			
			if ($params->get('FeaturedItems') == '0')
				$query .= " AND i.featured != 1";

			if ($params->get('FeaturedItems') == '2')
				$query .= " AND i.featured = 1";

			if ($ordering == 'comments')
				$query .= " AND comments.published = 1";
				
			if(K2_JVERSION != '15')
			{
				if($mainframe->getLanguageFilter())
				{
					$languageTag = JFactory::getLanguage()->getTag();
					$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
				}
			}
			
			switch ($ordering)
			{

				case 'date' :
					$orderby = 'i.created ASC';
					break;

				case 'rdate' :
					$orderby = 'i.created DESC';
					break;

				case 'alpha' :
					$orderby = 'i.title';
					break;

				case 'ralpha' :
					$orderby = 'i.title DESC';
					break;

				case 'order' :
					if ($params->get('FeaturedItems') == '2')
						$orderby = 'i.featured_ordering';
					else
						$orderby = 'i.ordering';
					break;

				case 'rorder' :
					if ($params->get('FeaturedItems') == '2')
						$orderby = 'i.featured_ordering DESC';
					else
						$orderby = 'i.ordering DESC';
					break;

				case 'hits' :
					if ($params->get('popularityRange'))
					{
						$datenow = JFactory::getDate();
						$date =  K2_JVERSION == '15'?$datenow->toMySQL():$datenow->toSql();
						$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$params->get('popularityRange')." DAY) ";
					}
					$orderby = 'i.hits DESC';
					break;

				case 'rand' :
					$orderby = 'RAND()';
					break;

				case 'best' :
					$orderby = 'rating DESC';
					break;

				case 'comments' :
					if ($params->get('popularityRange'))
					{
						$datenow = JFactory::getDate();
						$date =  K2_JVERSION == '15'?$datenow->toMySQL():$datenow->toSql();
						$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$params->get('popularityRange')." DAY) ";
					}
					$query .= " GROUP BY i.id ";
					$orderby = 'numOfComments DESC';
					break;

				case 'modified' :
					$orderby = 'lastChanged DESC';
					break;

				case 'publishUp' :
					$orderby = 'i.publish_up DESC';
					break;

				default :
					$orderby = 'i.id DESC';
					break;
			}
			
			$query .= " ORDER BY ".$orderby;
			$db->setQuery($query, 0, $limit);
			$items = $db->loadObjectList();
		}
		
		$model = K2Model::getInstance('Item', 'K2Model');
		
		if(count($items))
		{
			foreach($items as $item)
			{
				//Clean title
				$item->title = JFilterOutput::ampReplace($item->title);
				
				//Images
				if($params->get('itemImage'))
				{
					$date = JFactory::getDate($item->modified);
					$timestamp = '?t='.$date->toUnix();
					
					if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XS.jpg'))
					{
						$item->imageXSmall = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XS.jpg';
						if($componentParams->get('imageTimestamp'))
						{
							$item->imageXSmall .= $timestamp;
						}
					}
					
					if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg'))
					{
						$item->imageSmall = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_S.jpg';
						if($componentParams->get('imageTimestamp'))
						{
							$item->imageSmall .= $timestamp;
						}
					}
					
					if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg'))
					{
						$item->imageMedium = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
						if($componentParams->get('imageTimestamp'))
						{
							$item->imageMedium .= $timestamp;
						}
					}
					
					if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg'))
					{
						$item->imageLarge = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_L.jpg';
						if($componentParams->get('imageTimestamp'))
						{
							$item->imageLarge .= $timestamp;
						}
					}
					
					if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XL.jpg'))
					{
						$item->imageXLarge = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg';
						if($componentParams->get('imageTimestamp'))
						{
							$item->imageXLarge .= $timestamp;
						}
					}
					
					if(JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_Generic.jpg'))
					{
						$item->imageGeneric = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_Generic.jpg';
						if($componentParams->get('imageTimestamp'))
						{
							$item->imageGeneric .= $timestamp;
						}
					}
					
					$image = 'image'.$params->get('itemImgSize', 'Small');
					if(isset($item->$image))
						$item->image = $item->$image;
				}
				
				//Read more link
				$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));
				
				//Category link
				$item->categoryLink = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid.':'.urlencode($item->categoryalias))));
				
				// Introtext
				$item->text = '';
				if($params->get('itemIntroText'))
				{
					// Word limit
					if($params->get('itemIntroTextWordLimit'))
					{
						$item->text .= K2HelperUtilities::wordLimit($item->introtext, $params->get('itemIntroTextWordLimit'));
					}
					else
					{
						$item->text .= $item->introtext;
					}
				}
				// Restore the intotext variable after plugins execution
                $item->introtext = $item->text;
				
				//Clean the plugin tags
				$item->introtext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $item->introtext);
				
				$rows[] = $item;
			}
			return $rows;
		}
	}
	public static function getCopyrightText($module)
	{
		echo '<div class="vina-copyright">© Free <a href="http://vinagecko.com/joomla-modules" title="Free Joomla! 3 Modules">Joomla! 3 Modules</a>- by <a href="http://vinagecko.com/" title="Beautiful Joomla! 3 Templates and Powerful Joomla! 3 Modules, Plugins.">VinaGecko.com</a></div>';
	}
}