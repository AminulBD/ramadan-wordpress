import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { TextControl, SelectControl, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { bangladesh as BDCities } from './utils/cities';

const name = 'ramadan/daily';

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'ramadan' ) }>
					<TextControl
						label={ __( 'Date', 'ramadan' ) }
						value={ attributes.date }
						type="date"
						onChange={ ( value ) =>
							setAttributes( { date: value } )
						}
					/>

					<SelectControl
						label={ __( 'City', 'ramadan' ) }
						value={ attributes.city }
						onChange={ ( value ) =>
							setAttributes( { city: value } )
						}
					>
						<option value="">
							{ __( '- Select -', 'ramadan' ) }
						</option>
						{ BDCities.map( ( division, di ) => (
							<optgroup key={ di } label={ division.label }>
								{ division.options.map( ( city, ci ) => (
									<option key={ ci } value={ city.value }>
										{ city.label }
									</option>
								) ) }
							</optgroup>
						) ) }
					</SelectControl>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<ServerSideRender block={ name } attributes={ attributes } />
			</div>
		</>
	);
}

export default {
	name,
	settings: {
		title: __( 'Daily', 'ramadan' ),
		description: __( 'Display daily ramadan time.', 'ramadan' ),
		category: 'ramadan',
		icon: 'megaphone',
		attributes: {
			date: {
				type: 'string',
				default: '2023-03-22',
			},
			city: {
				type: 'string',
				default: '',
			},
		},
		edit: Edit,
	},
};
