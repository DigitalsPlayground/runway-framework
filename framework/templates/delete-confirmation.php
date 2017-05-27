<form method="post" action="<?php echo esc_url($action_url_yes); ?>" style="display:inline;">
	<p>
		<?php if( isset($msg_confirm) )	echo rf__($msg_confirm); ?>
		<?php echo __( 'You are about to remove the following', 'framework').' '.rf__($item_confirm).':'; ?>
		<ul class="ul-disc">
			<?php if(is_array($item_title)) {
						foreach($item_title as $title) { ?>
							<li><?php rf_e($title); ?></li>
						<?php } 
				  } else { ?>
				  		<li><?php rf_e($item_title); ?></li>
			<?php } ?>
		</ul>
		<?php echo __( 'Are you sure you want to delete these', 'framework').' '.rf__($item_confirm).'?'; ?>
	</p>
	<?php submit_button( __( 'Yes, Delete these', 'framework').' '.rf__($item_confirm), 'button', 'submit', false ); ?>
</form>
<form method="post" action="<?php echo esc_url($action_url_no); ?>" style="display:inline;">
	<?php submit_button( __( 'No, Return me to the list of', 'framework' ).' '.rf__($item_confirm), 'button', 'submit', false ); ?>
</form>