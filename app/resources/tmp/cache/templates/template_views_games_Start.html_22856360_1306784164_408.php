Welcome to the Game! 

Please choose which game you would like to play!

<?php echo $this->form->create(); ?> 
	<?php echo $this->form->field(array("player_count" => "Human Vs. Machine"), array("type" => "radio", 'value' => "1")); ?>
	<?php echo $this->form->field(array("player_count" => "Human Vs. Human"), array("type" => "radio", 'value' => "2")); ?> 
	<?php echo $this->form->submit("Start The Game"); ?>
<?php echo $this->form->end(); ?> 
