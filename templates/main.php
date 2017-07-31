<?php
script('notestutorial', 'handlebars');
script('notestutorial', 'script');
style('notestutorial', 'style');
?>

<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('fragments/navigation')); ?>
		<?php print_unescaped($this->inc('fragments/settings')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('fragments/content')); ?>
		</div>
	</div>
</div>
