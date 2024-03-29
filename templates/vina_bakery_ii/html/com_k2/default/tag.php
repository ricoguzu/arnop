<?php
/**
 * @version		$Id: tag.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Tag Layout -->
<div id="k2Container" class="tagView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<h1 class="entry-title page-header"><?php echo $this->escape($this->params->get('page_title')); ?></h1>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('tagFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>
	<div class="tagItemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="tagItemView">

			<div class="tagItemHeader">
			
				<?php if($item->params->get('tagItemDateCreated',1)): ?>	
				<!-- Date created -->
				<span class="itemDateCreated pull-left">
					<span class="vina_d">
					<?php echo JHTML::_('date', $item->created , JText::_('VINA_K2_D')); ?>
					</span>
					<span class="vina_m">
					<?php echo JHTML::_('date', $item->created , JText::_('VINA_K2_M')); ?>
					</span>
					<span class="vina_y">
					<?php echo JHTML::_('date', $item->created , JText::_('VINA_K2_Y')); ?>	
					</span>	
				</span>
				<?php endif; ?>
			
			  <?php if($item->params->get('tagItemTitle',1)): ?>
			  <!-- Item title -->
			  <h2 class="tagItemTitle">
			  	<?php if ($item->params->get('tagItemTitleLinked',1)): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  </h2>
			  <?php endif; ?>
			  
			  <?php if(
				$item->params->get('tagItemCategory')				||
				$item->params->get('tagItemReadMore')
				): ?>
			  <ul class="vina-header-toolbar">
			  
			  	<?php if($item->params->get('tagItemCategory')): ?>
				<!-- Item category name -->
				<li>
					<div class="tagItemCategory">
						<?php /*?><span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span><?php */?>
						<em class="icon-folder-open"></em>
						<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
					</div>
				</li>
				<?php endif; ?>
				
			  
				
				<?php if ($item->params->get('tagItemReadMore')): ?>
				<!-- Item "read more..." link -->
				<li class="pull-right">
					<div class="tagItemReadMore">
						<a class="k2ReadMore btn btn-small btn-primary" href="<?php echo $item->link; ?>">
							<?php echo JText::_('K2_READ_MORE'); ?>
						</a>
					</div>
				</li>
				<?php endif; ?>
				
			  </ul>
			  <?php endif; ?>
			  
		  </div>

		  <div class="tagItemBody media">
			  <?php if($item->params->get('tagItemImage',1) && !empty($item->imageGeneric)): ?>
			  <!-- Item Image -->
			  <div class="tagItemImageBlock pull-left">
				  <span class="tagItemImage">
				    <a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
				    	<img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:<?php echo $item->params->get('itemImageGeneric'); ?>px; height:auto;" />
				    </a>
				  </span>
				  <div class="clr"></div>
			  </div>
			  <?php endif; ?>
			  
			  <?php if($item->params->get('tagItemIntroText',1)): ?>
			  <!-- Item introtext -->
			  <div class="tagItemIntroText media-body">
			  	<?php echo $item->introtext; ?>
			  </div>
			  <?php endif; ?>

			  <div class="clr"></div>
		  </div>
		  
		  <div class="clr"></div>
		  
		  <?php if($item->params->get('tagItemExtraFields',0) && count($item->extra_fields)): ?>
		  <!-- Item extra fields -->  
		  <div class="tagItemExtraFields">
		  	<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
		  	<ul>
				<?php foreach ($item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->value != ''): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
					<?php if($extraField->type == 'header'): ?>
					<h4 class="tagItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
					<?php else: ?>
					<span class="tagItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
					<span class="tagItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
					<?php endif; ?>		
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
		    <div class="clr"></div>
		  </div>
		  <?php endif; ?>

			<div class="clr"></div>
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<div class="pagination">
			<?php echo $this->pagination->getPagesLinks(); ?>
			<div class="clr"></div>
			<?php echo $this->pagination->getPagesCounter(); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php endif; ?>
	
</div>
<!-- End K2 Tag Layout -->
