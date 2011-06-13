<div id="board" >
	<?php for ( $i = $board->getY()-1; $i >= 0; $i-- ) { ?> 
		<div class="row">
		<?php for ( $j = $board->getX()-1; $j >= 0; $j-- ) { ?>
			<div class="cell" > 
				<?php if ($board->getSpotOwner($i, $j)) { ?>
						<div class="marker">	
							<?= $board->getSpotOwner($i, $j) ?> 
						</div>
				<?php } else { ?> 
						<div class="blank">
							
						 &nbsp;</div>
				<?php } ?> 
			</div> 
		<?php } ?>
		
		</div>
	<?php } ?>
	
	<?php for ( $j = $board->getX()-1; $j >= 0; $j-- ) { ?>
		<div class="move" attrx="<?= $j ?>">
			<input type="button" value="<?= $j ?>" />
		</div>
	<?php }?>
	<div style="visibility:hidden;" id="moveForm"> 
		<?= $this->form->create() ?> 
		 <?=	$this->form->field("x", array("id"=>"xvalue", "type"=>'hidden')) ?> 
		<?= $this->form->end() ?> 
	</div>
</div>
