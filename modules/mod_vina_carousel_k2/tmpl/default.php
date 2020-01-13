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

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_carousel_k2/assets/js/owl.carousel.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_carousel_k2/assets/css/owl.carousel.css');
$doc->addStyleSheet('modules/mod_vina_carousel_k2/assets/css/owl.theme.css');
?>
<style type="text/css">
#vina-carousel-k2<?php echo $module->id; ?> {
	width: <?php echo $moduleWidth; ?>;
	height: <?php echo $moduleHeight; ?>;
	margin: <?php echo $moduleMargin; ?>;
	padding: <?php echo $modulePadding; ?>;
	<?php echo ($bgImage != '') ? "background: url({$bgImage}) repeat scroll 0 0;" : ''; ?>
	<?php echo ($isBgColor) ? "background-color: {$bgColor};" : ''; ?>
	overflow: hidden;
}
#vina-carousel-k2<?php echo $module->id; ?> .item {
	<?php echo ($isItemBgColor) ? "background-color: {$itemBgColor};" : ""; ?>;
	color: <?php echo $itemTextColor; ?>;
	padding: <?php echo $itemPadding; ?>;
	margin: <?php echo $itemMargin; ?>;
}
#vina-carousel-k2<?php echo $module->id; ?> .item a {
	color: <?php echo $itemLinkColor; ?>;
}
</style>
<div id="vina-carousel-k2<?php echo $module->id; ?>" class="vina-carousel-k2 owl-carousel">
	<?php 
		foreach($items as $key => $item) :
			$image = $item->$itemImgSize;
			$title = $item->title;
			$link  = $item->link;
			$cname = $item->categoryname;
			$clink = $item->categoryLink;
			$hits  = $item->hits;
			$introtext = $item->introtext;
			$created   = $item->created;
	?>
	<div class="item">
		<!-- Image Block -->
		<?php if($itemImage && !empty($image)) : ?>
		<div class="image-block">
			<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
				<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" />
			</a>
		</div>
		<?php endif; ?>
		
		<!-- Text Block -->
		<?php if($itemTitle || $itemIntroText || $itemCategory || $itemDateCreated || $itemHits || $itemReadMore) : ?>
		<div class="text-block">
			<!-- Title Block -->
			<?php if($itemTitle) :?>
			<h3 class="title">
				<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
			</h3>
			<?php endif; ?>
			
			<!-- Info Block -->
			<?php if($itemCategory || $itemDateCreated || $itemHits) : ?>
			<div class="info">
				<?php if($itemDateCreated) : ?>
				<span><?php echo JTEXT::_('VINA_PUBLISHED'); ?>: <?php echo JHTML::_('date', $created, 'F d, Y');?></span>
				<?php endif; ?>
				
				<?php if($itemCategory) : ?>
				<span><?php echo JTEXT::_('VINA_CATEGORY'); ?>: <a href="<?php echo $clink; ?>"><?php echo $cname; ?></a></span>
				<?php endif; ?>
				
				<?php if($itemHits) : ?>
				<span><?php echo JTEXT::_('VINA_HITS'); ?>: <?php echo $hits; ?></span>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<!-- Intro text Block -->
			<?php if($itemIntroText) : ?>
			<div class="introtext"><?php echo $introtext; ?></div>
			<?php endif; ?>
			
			<!-- Readmore Block -->
			<?php if($itemReadMore) : ?>
			<div class="readmore">
				<a class="buttonlight morebutton" href="<?php echo $link; ?>" title="<?php echo $title; ?>">
					<?php echo JText::_('VINA_READ_MORE'); ?>
				</a>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#vina-carousel-k2<?php echo $module->id; ?>").owlCarousel({
		items : 			<?php echo $itemsVisible; ?>,
        itemsDesktop : 		<?php echo $itemsDesktop; ?>,
        itemsDesktopSmall : <?php echo $itemsDesktopSmall; ?>,
        itemsTablet : 		<?php echo $itemsTablet; ?>,
        itemsTabletSmall : 	<?php echo $itemsTabletSmall; ?>,
        itemsMobile : 		<?php echo $itemsMobile; ?>,
        singleItem : 		<?php echo ($singleItem) ? 'true' : 'false'; ?>,
        itemsScaleUp : 		<?php echo ($itemsScaleUp) ? 'true' : 'false'; ?>,

        slideSpeed : 		<?php echo $slideSpeed; ?>,
        paginationSpeed : 	<?php echo $paginationSpeed; ?>,
        rewindSpeed : 		<?php echo $rewindSpeed; ?>,

        autoPlay : 		<?php echo ($autoPlay) ? 'true' : 'false'; ?>,
        stopOnHover : 	<?php echo ($stopOnHover) ? 'true' : 'false'; ?>,

        navigation : 	<?php echo ($navigation) ? 'true' : 'false'; ?>,
        rewindNav : 	<?php echo ($rewindNav) ? 'true' : 'false'; ?>,
        scrollPerPage : <?php echo ($scrollPerPage) ? 'true' : 'false'; ?>,

        pagination : 		<?php echo ($pagination) ? 'true' : 'false'; ?>,
        paginationNumbers : <?php echo ($paginationNumbers) ? 'true' : 'false'; ?>,

        responsive : 	<?php echo ($responsive) ? 'true' : 'false'; ?>,
        autoHeight : 	<?php echo ($autoHeight) ? 'true' : 'false'; ?>,
        mouseDrag : 	<?php echo ($mouseDrag) ? 'true' : 'false'; ?>,
        touchDrag : 	<?php echo ($touchDrag) ? 'true' : 'false'; ?>,
	});
}); 
</script>