<?php
script('notestutorial', 'handlebars');
script('notestutorial', 'script');
style('notestutorial', 'style');
?>

<div id="app-navigation">
	<?php print_unescaped($this->inc('fragments/navigation')); ?>
	<?php print_unescaped($this->inc('fragments/settings')); ?>
</div>

<div id="app-content">
	<?php print_unescaped($this->inc('fragments/content')); ?>
</div>
