import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

const name = 'ramadan/city-selector';

function Edit( { attributes } ) {
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<ServerSideRender block={ name } attributes={ attributes } />
		</div>
	);
}

export default {
	name,
	settings: {
		title: __( 'City Links', 'ramadan' ),
		description: __( 'Display all city selector.', 'ramadan' ),
		category: 'ramadan',
		icon: 'megaphone',
		edit: Edit,
	},
};
