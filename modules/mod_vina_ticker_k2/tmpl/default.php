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

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_ticker_k2/assets/js/jquery.easing.min.js', 'text/javascript');
$doc->addScript('modules/mod_vina_ticker_k2/assets/js/jquery.easy-ticker.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_ticker_k2/assets/css/style.css');
?>
<style type="text/css">
#vina-ticker-k2<?php echo $module->id; ?> {
	width: <?php echo $moduleWidth; ?>;
	padding: <?php echo $modulePadding; ?>;
	<?php echo ($bgImage != '') ? 'background: url('.$bgImage.') top center no-repeat;' : ''; ?>
	<?php echo ($isBgColor) ? 'background-color: ' . $bgColor : ''; ?>
}
#vina-ticker-k2<?php echo $module->id; ?> .vina-item {
	padding: <?php echo $itemPadding; ?>;
	color: <?php echo $itemTextColor; ?>;
	border-bottom: solid 1px <?php echo $bgColor; ?>;
	<?php echo ($isItemBgColor) ? 'background-color: ' . $itemBgColor : ''; ?>
}
#vina-ticker-k2<?php echo $module->id; ?> .vina-item a {
	color: <?php echo $itemLinkColor; ?>;
}
#vina-ticker-k2<?php echo $module->id; ?> .header-block {
	color: <?php echo $headerColor; ?>;
	margin-bottom: <?php echo $modulePadding; ?>;
}
</style>
<div id="vina-ticker-k2<?php echo $module->id; ?>" class="vina-ticker-k2">

<!-- Header Buttons Block -->
	<?php if($headerBlock) : ?>
	<div class="header-block">
		<div class="row-fluid">
			<?php if(!empty($headerText)) : ?>
			<div class="span<?php echo ($controlButtons) ? 7 : 12; ?>">
				<h3><?php echo $headerText; ?></h3>
			</div>
			<?php endif; ?>
			
			<?php if($controlButtons) : ?>
			<div class="span<?php echo empty($headerText) ? 12 : 5; ?>">
				<div class="control-block pull-right">
					<span class="up">UP</span>
					<span class="toggle">TOGGLE</span>
					<span class="down">DOWN</span>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

<!-- Items Block -->	
	<div class="vina-items-wrapper">
		<div class="vina-items">
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
			<div class="vina-item">
				<div class="row-fluid">
					<!-- Image Block -->
					<?php if($itemImage) : ?>
					<div class="span<?php echo ($itemTitle || $itemIntroText || $itemCategory || $itemDateCreated || $itemHits || $itemReadMore) ? 4 : 12; ?>">
						<?php if($linkOnImage) : ?>
							<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
								<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"/>
							</a>
						<?php else: ?>
							<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"/>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					
					<!-- Text Block -->
					<?php if($itemTitle || $itemIntroText || $itemCategory || $itemDateCreated || $itemHits || $itemReadMore) : ?>
					<div class="span<?php echo ($itemImage) ? 8 : 12; ?>">
						<div class="text-block">
							<!-- Title Block -->
							<?php if($itemTitle) :?>
							<h4 class="title">
								<?php if($linkOnTitle) : ?>
									<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
								<?php else: ?>
									<?php echo $title; ?>
								<?php endif; ?>
							</h4>
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
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#vina-ticker-k2<?php echo $module->id; ?> .vina-items-wrapper').easyTicker({
		direction: 		'<?php echo $direction?>',
		easing: 		'<?php echo $easing?>',
		speed: 			'<?php echo $speed?>',
		interval: 		<?php echo $interval?>,
		height: 		'<?php echo $moduleHeight; ?>',
		visible: 		<?php echo $visible?>,
		mousePause: 	<?php echo $mousePause?>,
		
		<?php if($controlButtons) : ?>
		controls: {
			up: '#vina-ticker-k2<?php echo $module->id; ?> .up',
			down: '#vina-ticker-k2<?php echo $module->id; ?> .down',
			toggle: '#vina-ticker-k2<?php echo $module->id; ?> .toggle',
			playText: 'Play',
			stopText: 'Stop'
		},
		<?php endif; ?>
	});
});
</script>