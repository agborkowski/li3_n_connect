Welcome to the Game! 

Please choose which game you would like to play!

<?= $this->form->create(); ?> 
	<?= $this->form->field(array("player_count" => "Human Vs. Machine"), array("type" => "radio", 'value' => "1")) ?>
	<?= $this->form->field(array("player_count" => "Human Vs. Human"), array("type" => "radio", 'value' => "2")) ?> 
	<?= $this->form->submit("Start The Game"); ?>
<?= $this->form->end(); ?> 
