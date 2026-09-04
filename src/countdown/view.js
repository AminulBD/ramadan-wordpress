import { __, sprintf } from '@wordpress/i18n';

function pad( value ) {
	return String( value ).padStart( 2, '0' );
}

function formatRemaining( seconds ) {
	seconds = Math.max( 0, Math.floor( seconds ) );

	const hours = Math.floor( seconds / 3600 );
	const minutes = Math.floor( ( seconds % 3600 ) / 60 );
	const secs = seconds % 60;

	return pad( hours ) + ':' + pad( minutes ) + ':' + pad( secs );
}

function setup( root ) {
	let data;

	try {
		data = JSON.parse( root.dataset.schedule || '{}' );
	} catch {
		return;
	}

	if ( ! data.events || ! data.events.length ) {
		return;
	}

	const timer = root.querySelector( '[data-timer]' );
	const label = root.querySelector( '[data-label]' );
	const clock = root.querySelector( '[data-clock]' );
	const progress = root.querySelector( '[data-progress]' );
	const chips = root.querySelectorAll( '.ramadan-countdown__event' );
	const skew = data.now * 1000 - Date.now();

	function tick() {
		const now = ( Date.now() + skew ) / 1000;
		let next = null;
		let prev = null;

		for ( let i = 0; i < data.events.length; i++ ) {
			if ( data.events[ i ].ts > now ) {
				next = data.events[ i ];
				break;
			}
		}

		for ( let i = data.events.length - 1; i >= 0; i-- ) {
			if ( data.events[ i ].ts <= now ) {
				prev = data.events[ i ];
				break;
			}
		}

		if ( ! next && data.nextDay ) {
			next = data.nextDay;
		}

		if ( ! next ) {
			return;
		}

		if ( label ) {
			label.textContent = sprintf(
				/* translators: %s: salat event name, e.g. Iftar. */
				__( 'Time left until %s', 'ramadan' ),
				next.label
			);
		}

		if ( timer ) {
			timer.textContent = formatRemaining( next.ts - now );
		}

		if ( clock ) {
			const siteNow = new Date( ( now + data.offset ) * 1000 );
			clock.textContent =
				pad( siteNow.getUTCHours() ) +
				':' +
				pad( siteNow.getUTCMinutes() ) +
				':' +
				pad( siteNow.getUTCSeconds() );
		}

		if ( progress ) {
			const from = prev ? prev.ts : next.ts - 86400;
			const span = Math.max( next.ts - from, 1 );
			const percent = Math.max(
				0,
				Math.min( 100, ( ( now - from ) / span ) * 100 )
			);
			progress.style.width = percent + '%';
		}

		chips.forEach( function ( chip ) {
			const key = chip.dataset.key;
			const event = data.events.find( ( item ) => item.key === key );
			const isPast = event && event.ts <= now;
			const isNext = next && event && event.ts === next.ts;

			chip.classList.toggle( 'is-past', isPast && ! isNext );
			chip.classList.toggle( 'is-next', isNext );
		} );
	}

	tick();
	setInterval( tick, 1000 );
}

function init() {
	document.querySelectorAll( '.ramadan-countdown' ).forEach( setup );
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', init );
} else {
	init();
}
