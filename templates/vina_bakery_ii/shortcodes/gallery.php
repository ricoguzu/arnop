<?php
/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2014 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');

//[Gallery]
if(!function_exists('gallery_sc')) {
	$galleryArray = array();
	function gallery_sc( $atts, $content="" ){
		global $galleryArray;
		
		$tags = array();
		
		extract(shortcode_atts(array(
			'columns' => 3,
			'modal' => 'yes',
			'filter' => 'no',
			'id' => 'gallery'
		), $atts));
		 
		do_shortcode( $content );
		
			//Add gallery.css file
		Helix::addCSS('gallery.css');
		//isotope
		if($filter=='yes')
			Helix::addJS('jquery.isotope.min.js');
		
		$tags = array();
		
		foreach ($galleryArray as $key=>$item) {
			$tmp = explode(",", $item['tag']);
			for($i = 0; $i < count($tmp); $i++)
			{
				$tag = ltrim($tmp[$i]);
				if(!in_array($tag, $tags))
				{
					$tags[] = $tag;
				}
			}
			
		}
		
		ob_start();
		if($filter=='yes') {
		?>
		
		<div class="gallery-filters btn-group">
			<a class="btn active" href="#" data-filter="*"><?php echo JText::_('Show All'); ?></a>
			<?php foreach ($tags as $tag) { ?>		  
				<a class="btn" href="#" data-filter=".<?php echo $id . '-' . strtolower(str_replace(" ", "-", $tag)); ?>">
					<?php echo ucfirst($tag); ?>
				</a>
			<?php } ?>
		</div>
		<?php } ?>
		
		<ul class="gallery"  id="<?php echo $id; ?>">
			<?php foreach ($galleryArray as $key=>$item) {
				$itag_img = array();
				$itag_img = explode(",", $item['tag']);
			?>	
				<li style="width:<?php echo round(100/$columns); ?>%" class="<?php 
					for($i = 0; $i < count($itag_img); $i++)
					{
						$itag_img[$i] = ltrim($itag_img[$i]);
						$itag_img[$i] = strtolower($itag_img[$i]);
						$itag_img[$i] = str_replace(" ", "-", $itag_img[$i]);
						echo $id.'-'.$itag_img[$i].' ';
					}
				?>">
						<a class="img-polaroid" data-toggle="modal" href="<?php echo ($modal=='yes')? '#modal-' . $id . '-' . $key . '':'#' ?>">
	
						<?php
						echo '<img alt=" " src="' . $item['src'] . '" />';
						?>
						<?php if($item['content'] !='') { ?>
							<div>
								<div>
									<?php echo do_shortcode($item['content']); ?>
								</div>
							</div>
						<?php } ?>
					</a>
				</li>
				
				<?php if($modal=='yes') { ?>
				<div id="modal-<?php echo $id .'-'. $key; ?>" class="modal hide fade" tabindex="-1">
					<a class="close-modal" href="javascript:;" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i>
					</a>
					<div class="modal-body">
						<?php echo '<img src="' . $item['src'] . '" alt=" " width="100%" style="max-height:400px" />';?>
					</div>
				</div>
				<?php } ?>
				
			<?php } ?>
		</ul>
		
		<?php if($filter=='yes') { ?>
			<script type="text/javascript">
				window.addEvent('load', function(){
					spnoConflict(function($){
					$gallery = $('.gallery-filters').next();
					$gallery.isotope({
					  // options
					  itemSelector : 'li',
					  layoutMode : 'fitRows'
					});
					
					$filter = $('.gallery-filters');
					$selectors = $filter.find('>a');
					
					$filter.find('>a').click(function(){
						var selector = $(this).attr('data-filter');
						
							$selectors.removeClass('active');
							$(this).addClass('active');
							
							$gallery.isotope({ filter: selector });
						  return false;
						});
					});
				});
			</script>
		<?php } ?>
		  
		<?php
		$galleryArray = array();	
		//return $html;
		return ob_get_clean();
	}
	add_shortcode( 'gallery', 'gallery_sc' );
	
	//Accordion Items
	function gallery_item_sc( $atts, $content="" ){
		global $galleryArray;
		$galleryArray[] = array(
			'src'=>(isset($atts['src'])?$atts['src']:''),
			'id'		=> (isset($atts['id']) ? $atts['id'] : ''),	
			'tag'=>(isset($atts['tag']) && $atts['tag'] !='')?$atts['tag']:'',
			'content'=>$content
		);
	}

	add_shortcode( 'gallery_item', 'gallery_item_sc' );
}