// WordPress dependencies.
import { registerBlockStyle } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';
import { __ } from '@wordpress/i18n';

domReady(() => {
	registerBlockStyle('core/group', [
		{
			name: 'placeholder',
			label: __('Placeholder', 'scaffold'),
		},
	]);
});
