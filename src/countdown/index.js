import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	CheckboxControl,
	PanelBody,
	SelectControl,
	TextControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { bangladesh as BDCities } from '../utils/cities';
import metadata from './block.json';

const countableEvents = Object.keys( window.ramadan.headings ).filter(
	( key ) => ! [ 'date', 'day', 'sunset' ].includes( key )
);

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'ramadan' ) }>
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

					<TextControl
						label={ __( 'Time Format', 'ramadan' ) }
						value={ attributes.timeformat ?? 'h:i A' }
						type="text"
						onChange={ ( value ) =>
							setAttributes( { timeformat: value } )
						}
					/>
				</PanelBody>
				<PanelBody title={ __( 'Fields', 'ramadan' ) }>
					{ countableEvents.map( ( key, index ) => (
						<CheckboxControl
							key={ index }
							label={ window.ramadan.headings[ key ] ?? '-' }
							checked={ attributes.events?.[ key ] }
							onChange={ ( value ) => {
								setAttributes( {
									events: {
										...attributes.events,
										[ key ]: value,
									},
								} );
							} }
						/>
					) ) }
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<ServerSideRender
					block={ metadata.name }
					attributes={ attributes }
				/>
			</div>
		</>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
} );
