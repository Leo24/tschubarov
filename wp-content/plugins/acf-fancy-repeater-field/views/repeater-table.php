<div class="meta">

</div>

<div class="handle">
	<ul class="acf-hl acf-tbody">
		<li class="li-fancyrepeater-order">
			<span class="acf-icon large"><?php echo $i; ?></span>
		</li>
		<li class="li-fancyrepeater-label">
			<strong>
				<a class="edit-field" title="<?php _e( 'Edit', 'acf_child_post_field' ); ?> <?php echo esc_attr( $field['button_label'] ); ?>" href="#"><?php echo $row[$title_input_key]; ?></a>
			</strong>
			
			<div class="row-options">
				<a class="edit-field" title="<?php _e( 'Edit', 'acf_child_post_field' ); ?> <?php echo esc_attr( $field['button_label'] ); ?>" href="#"><?php _e( 'Edit', 'acf_child_post_field' ); ?></a>
				<a class="delete-field acf-fancyrepeater-remove-row" title="<?php _e( 'Delete', 'acf_child_post_field' ); ?> <?php echo esc_attr( $field['button_label'] ); ?>" href="#">| <?php _e( 'Delete', 'acf_child_post_field' ); ?></a>
			</div>
		</li>
		<li class="li-fancyrepeater-name">
		</li>
		<li class="li-fancyrepeater-type">
		</li>	
	</ul>
</div>

<div class="settings">
	<table <?php acf_esc_attr_e( array('class' => "acf-table acf-input-table {$field['layout']}-layout") ); ?>>

		<?php if ( $field['layout'] == 'table' ): ?>
			<thead>
				<tr>
					<?php if ( $show_order ): ?>
						<th class="order"><span class="order-spacer"></span></th>
					<?php endif; ?>

					<?php
					foreach ( $field['sub_fields'] as $sub_field ):

						$atts = array(
						    'class' => "acf-th acf-th-{$sub_field['name']}",
						    'data-key' => $sub_field['key'],
						);


						// Add custom width
						if ( $sub_field['wrapper']['width'] ) {

							$atts['data-width'] = $sub_field['wrapper']['width'];
						}
						?>

						<th <?php acf_esc_attr_e( $atts ); ?>>
							<?php acf_the_field_label( $sub_field ); ?>
							<?php if ( $sub_field['instructions'] ): ?>
					<p class="description"><?php echo $sub_field['instructions']; ?></p>
				<?php endif; ?>
				</th>

			<?php endforeach; ?>

			</tr>	
			</thead>
		<?php endif; ?>

		<tbody>
			<tr class="acf-row">

				<?php if ( $show_order ): ?>
					<td class="order" title="<?php _e( 'Drag to reorder', 'acf' ); ?>"><?php echo intval( $i ) + 1; ?></td>
				<?php endif; ?>

				<?php echo $before_fields; ?>

				<?php
				foreach ( $field['sub_fields'] as $sub_field ):

					// prevent repeater field from creating multiple conditional logic items for each row
					if ( $i !== 'acfcloneindex' ) {

						$sub_field['conditional_logic'] = 0;
					}


					// add value
					if ( isset( $row[$sub_field['key']] ) ) {

						// this is a normal value
						$sub_field['value'] = $row[$sub_field['key']];
					} elseif ( isset( $sub_field['default_value'] ) ) {

						// no value, but this sub field has a default value
						$sub_field['value'] = $sub_field['default_value'];
					}


					// update prefix to allow for nested values
					$sub_field['prefix'] = "{$field['name']}[{$i}]";


					/*$loc = 'a:29:{s:9:"read_only";b:0;s:4:"mask";s:0:"";s:14:"mask_autoclear";i:0;s:16:"mask_placeholder";s:1:"_";s:8:"function";s:5:"regex";s:7:"pattern";s:12:"^[^{,\s.}]+$";s:7:"message";s:23:"Only one word required.";s:6:"unique";s:10:"non-unique";s:15:"unique_statuses";a:2:{i:0;s:7:"publish";i:1;s:6:"future";}s:6:"drafts";i:1;s:2:"ID";i:0;s:3:"key";s:19:"field_56154f431d42a";s:5:"label";s:9:"Form Name";s:4:"name";s:9:"form_name";s:6:"prefix";s:27:"acf[field_56154efd1d427][0]";s:4:"type";s:15:"validated_field";s:5:"value";s:2:"kw";s:10:"menu_order";i:1;s:12:"instructions";s:52:"short name - use only one word or number if possible";s:8:"required";i:1;s:2:"id";s:19:"field_56154f431d42a";s:5:"class";s:0:"";s:17:"conditional_logic";i:0;s:6:"parent";s:19:"field_56154efd1d427";s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:5:"_name";s:9:"form_name";s:6:"_input";s:19:"field_56154f431d42a";s:6:"_valid";i:1;s:9:"sub_field";a:37:{s:4:"type";s:4:"text";s:3:"key";s:19:"field_56154f431d42a";s:4:"name";s:21:"[field_56154f431d42a]";s:5:"_name";s:9:"form_name";s:2:"id";s:20:"-field_56154f431d42a";s:5:"value";N;s:11:"field_group";s:0:"";s:8:"readonly";s:0:"";s:8:"disabled";s:0:"";s:6:"parent";s:19:"field_56154efd1d427";s:4:"save";s:0:"";s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";s:9:"read_only";b:0;s:4:"mask";s:0:"";s:14:"mask_autoclear";i:0;s:16:"mask_placeholder";s:1:"_";s:8:"function";s:5:"regex";s:7:"pattern";s:12:"^[^{,\s.}]+$";s:7:"message";s:23:"Only one word required.";s:6:"unique";s:10:"non-unique";s:15:"unique_statuses";a:2:{i:0;s:7:"publish";i:1;s:6:"future";}s:6:"drafts";i:1;s:2:"ID";i:0;s:5:"label";s:9:"Form Name";s:6:"prefix";s:0:"";s:10:"menu_order";i:1;s:12:"instructions";s:52:"short name - use only one word or number if possible";s:8:"required";i:1;s:5:"class";s:0:"";s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:6:"_input";s:21:"[field_56154f431d42a]";s:6:"_valid";i:1;}}';
					$rem = 'a:29:{s:2:"ID";i:0;s:3:"key";s:19:"field_56154f431d42a";s:5:"label";s:9:"Form Name";s:4:"name";s:9:"form_name";s:6:"prefix";s:27:"acf[field_56154efd1d427][0]";s:4:"type";s:15:"validated_field";s:5:"value";s:2:"kw";s:10:"menu_order";i:1;s:12:"instructions";s:52:"short name - use only one word or number if possible";s:8:"required";i:1;s:2:"id";s:0:"";s:5:"class";s:0:"";s:17:"conditional_logic";i:0;s:6:"parent";s:19:"field_56154efd1d427";s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:5:"_name";s:9:"form_name";s:6:"_input";s:0:"";s:6:"_valid";i:1;s:9:"read_only";b:0;s:4:"mask";s:0:"";s:14:"mask_autoclear";i:0;s:16:"mask_placeholder";s:1:"_";s:8:"function";s:5:"regex";s:7:"pattern";s:12:"^[^{,\s.}]+$";s:7:"message";s:23:"Only one word required.";s:6:"unique";s:10:"non-unique";s:15:"unique_statuses";a:2:{i:0;s:7:"publish";i:1;s:6:"future";}s:6:"drafts";i:1;s:9:"sub_field";a:37:{s:4:"type";s:4:"text";s:3:"key";s:19:"field_56154f431d42a";s:4:"name";s:21:"[field_56154f431d42a]";s:5:"_name";s:9:"form_name";s:2:"id";s:20:"-field_56154f431d42a";s:5:"value";N;s:11:"field_group";s:0:"";s:8:"readonly";s:0:"";s:8:"disabled";s:0:"";s:6:"parent";i:20;s:4:"save";s:0:"";s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";s:9:"read_only";b:0;s:4:"mask";s:0:"";s:14:"mask_autoclear";i:0;s:16:"mask_placeholder";s:1:"_";s:8:"function";s:5:"regex";s:7:"pattern";s:12:"^[^{,\s.}]+$";s:7:"message";s:23:"Only one word required.";s:6:"unique";s:10:"non-unique";s:15:"unique_statuses";a:2:{i:0;s:7:"publish";i:1;s:6:"future";}s:6:"drafts";i:1;s:2:"ID";i:21;s:5:"label";s:9:"Form Name";s:6:"prefix";s:0:"";s:10:"menu_order";i:1;s:12:"instructions";s:52:"short name - use only one word or number if possible";s:8:"required";i:1;s:5:"class";s:0:"";s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:6:"_input";s:21:"[field_56154f431d42a]";s:6:"_valid";i:1;}}';

					$diff = array_diff(unserialize($loc)['sub_field'], unserialize($rem)['sub_field']);*/

					if ($sub_field['value']=='kw')
						//var_dump($diff);
						//echo (serialize($sub_field));
						$sub_field['sub_field']['parent'] = 'field_56154efd1d427';

					//var_dump($sub_field);
					// render input
					acf_render_field_wrap( $sub_field, $el );
					?>

				<?php endforeach; ?>

				<?php echo $after_fields; ?>


			</tr>
		</tbody>
	</table>
</div>