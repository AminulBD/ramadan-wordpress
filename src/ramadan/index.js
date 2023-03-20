import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
	CheckboxControl,
	PanelBody,
	SelectControl,
	TextControl,
} from '@wordpress/components';
import { bangladesh as BDCities } from '../utils/cities';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

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

				<PanelBody title={ __( 'Fields', 'ramadan' ) }>
					{ Object.keys( window.ramadan.headings ).map(
						( key, index ) => (
							<CheckboxControl
								key={ index }
								label={ window.ramadan.headings[ key ] ?? '-' }
								checked={ attributes.columns?.[ key ] }
								onChange={ ( value ) => {
									setAttributes( {
										columns: {
											...attributes.columns,
											[ key ]: value,
										},
									} );
								} }
							/>
						)
					) }
				</PanelBody>

				<PanelBody title={ __( 'Phase Titles', 'ramadan' ) }>
					<TextControl
						label={ __( 'First Phase', 'ramadan' ) }
						value={
							attributes.first_phase_title ??
							__( '10 Days: Mercy of Allah', 'ramadan' )
						}
						type="text"
						onChange={ ( value ) =>
							setAttributes( { first_phase_title: value } )
						}
					/>

					<TextControl
						label={ __( 'Second Phase', 'ramadan' ) }
						value={
							attributes.second_phase_title ??
							__( '10 Days: Forgiveness of Allah', 'ramadan' )
						}
						type="text"
						onChange={ ( value ) =>
							setAttributes( { second_phase_title: value } )
						}
					/>

					<TextControl
						label={ __( 'Third Phase', 'ramadan' ) }
						value={
							attributes.third_phase_title ??
							__( '10 Days: Safety from the Hellfire', 'ramadan' )
						}
						type="text"
						onChange={ ( value ) =>
							setAttributes( { third_phase_title: value } )
						}
					/>
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
