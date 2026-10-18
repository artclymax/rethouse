<?php if (!empty($address = get_field('contacts_address', 'option'))): ?>
	<div class="address-box icon icon--address">
		<address class="address-box__descr descr">
			<?php echo wp_kses_post($address) ?>
		</address>
	</div>
<?php endif; ?>