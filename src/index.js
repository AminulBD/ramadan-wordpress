import { registerBlockType } from '@wordpress/blocks';

import citySelector from './city-selector';
import daily from './daily';
import monthly from './monthly';
import monthLinks from './month-links';
import ramadan from './ramadan';
import yearly from './yearly';

const blocks = [ citySelector, daily, monthly, monthLinks, ramadan, yearly ];

function registerBlock( block ) {
	const { name, settings } = block;
	registerBlockType( name, settings );
}

blocks.forEach( registerBlock );
