<!-- translation strings -->
<div style="display:none" id="new-note-string"><?php p($l->t('New note')); ?></div>

<script id="navigation-tpl" type="text/x-handlebars-template">
	<div id="new-note" class="app-navigation-new">
		<button type="button" class="icon-add">
			<?php p($l->t('Add note')); ?>
		</button>
	</div>
    {{#each notes}}
        <li class="note with-menu {{#if active}}active{{/if}}"  data-id="{{ id }}">
            <a href="#" class="icon-file">{{ title }}</a>
            <div class="app-navigation-entry-utils">
                <ul>
                    <li class="app-navigation-entry-utils-menu-button svg"><button></button></li>
                </ul>
            </div>

            <div class="app-navigation-entry-menu">
                <ul>
                    <li><button class="delete" title="delete">
							<span class="icon-delete"></span>
							<span><?php p($l->t('Delete')); ?></span>
						</button></li>
                </ul>
            </div>
        </li>
    {{/each}}
</script>

<ul></ul>
