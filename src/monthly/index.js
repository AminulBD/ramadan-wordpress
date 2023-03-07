import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { bangladesh as BDCities } from '../utils/cities';
import metadata from "./block.json";

function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();
	const years = Array.from( { length: 20 }, ( v, k ) => ( {
		label: k + 2020,
		value: k + 2020,
	} ) );
	const months = [];
	const localeMonths = window.ramadan.months;

	Object.keys( localeMonths ).forEach( ( month ) => {
		months.push( {
			label: localeMonths[month],
			value: month,
		} );
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'ramadan' ) }>
					<SelectControl
						label={ __( 'Year', 'ramadan' ) }
						value={ attributes.year }
						options={ [
							{ label: __( 'Current', 'ramadan' ), value: '' },
							...years,
						] }
						onChange={ ( value ) =>
							setAttributes( { year: value } )
						}
					/>

					<SelectControl
						label={ __( 'Month', 'ramadan' ) }
						value={ attributes.month }
						options={ [
							{ label: __( 'Current', 'ramadan' ), value: '' },
							...months,
						] }
						onChange={ ( value ) =>
							setAttributes( { month: value } )
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
						value={ attributes.dateformat ?? 'd F, l' }
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

