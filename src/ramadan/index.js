import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { bangladesh as BDCities } from '../utils/cities';
import { __ } from '@wordpress/i18n';
import metadata from "./block.json";

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'ramadan' ) }>
					<TextControl
						label={ __( 'Start Date', 'ramadan' ) }
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
						<option value="">{ __( '- Select -', 'ramadan' ) }</option>
						{ BDCities.map( ( division, di ) => (
							<optgroup key={ di } label={ division.label }>
								{ division.options.map( ( city, ci ) => (
									<option key={ ci } value={ city.value }>{ city.label }</option>
								) ) }
							</optgroup>
						) ) }
					</SelectControl>

					<TextControl
						label={ __( 'Date Format', 'ramadan' ) }
						value={ attributes.dateformat ?? 'd M' }
						type="text"
						onChange={ ( value ) =>
							setAttributes( { dateformat: value } )
						}
					/>

					<TextControl
						label={ __( 'Time Format', 'ramadan' ) }
						value={ attributes.timeformat ?? 'h:i A' }
						type="text"
						onChange={ ( value ) =>
							setAttributes( { timeformat: value } )
						}
					/>

					<TextControl
						label={ __( 'Day Format', 'ramadan' ) }
						value={ attributes.dayformat ?? 'D' }
						type="text"
						onChange={ ( value ) =>
							setAttributes( { dayformat: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
} );
