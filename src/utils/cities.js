const bdDivision = window.ramadan.cities;
const bdCities = [];

// map all district to bdCities from bdDivision
Object.keys( bdDivision ).forEach( ( division ) => {
	const localCities = [];

	Object.keys( bdDivision[ division ].cities ).forEach( ( district ) => {
		localCities.push( {
			label: bdDivision[ division ].cities[ district ],
			value: district,
		} );
	} );

	bdCities.push( {
		label: bdDivision[ division ].title,
		value: division,
		options: localCities,
	} );
} );

export const bangladesh = bdCities;
