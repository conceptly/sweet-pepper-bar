/**
 * Odometer — a number that rolls to its next value digit by digit, like a counter on a
 * till roll (About → Story → counter ledger; about-story.js).
 *
 * Each digit is a column showing one cell of a 0–9 ×4 strip. Columns are indexed from the
 * right, so the units column is always the units column; a longer number adds columns on the
 * left (width grows from 0), a shorter one collapses them. The thousands gap belongs to
 * column 3. Digits only roll forward, and the right-hand ones take extra turns. The digits are
 * aria-hidden; a screen reader gets the formatted number from a hidden span.
 */

const CELLS    = 40;
const ROLL_MS  = 1300;
const STAGGER  = 70;
const formatCount = ( n ) => Math.round( n ).toString().replace( /\B(?=(\d{3})+(?!\d))/g, ' ' );

const makeCol = ( index ) => {
    const col = document.createElement( 'span' );
    col.className = 'odo__col' + ( index > 0 && index % 3 === 0 ? ' odo__col--gap' : '' );
    const strip = document.createElement( 'span' );
    strip.className = 'odo__strip';
    for ( let i = 0; i < CELLS; i++ ) {
        const c = document.createElement( 'span' );
        c.textContent = i % 10;
        strip.appendChild( c );
    }
    col.appendChild( strip );
    col._strip = strip;
    col._pos = 0;
    return col;
};

const place = ( col, pos, ms = 0, delay = 0 ) => {
    col._strip.style.transition = ms ? `transform ${ ms }ms cubic-bezier(0.22, 1, 0.36, 1) ${ delay }ms` : 'none';
    col._strip.style.transform = `translateY(${ -pos * 1.25 }em)`;
    col._pos = pos;
};

export function odometer( el ) {
    el.classList.add( 'is-odometer' );
    el.textContent = '';
    const sr = document.createElement( 'span' );
    sr.className = 'screen-reader-text';
    const row = document.createElement( 'span' );
    row.className = 'odo';
    row.setAttribute( 'aria-hidden', 'true' );
    el.append( sr, row );
    const cols = []; // cols[0] = units

    // Roll to n. `fromZero` spins every column up from 0 (the entrance).
    const set = ( n, { instant = false, fromZero = false } = {} ) => {
        const digits = String( Math.round( n ) ).split( '' ).reverse().map( Number );
        sr.textContent = formatCount( n );

        while ( cols.length < digits.length ) {
            const col = makeCol( cols.length );
            col.classList.add( 'is-collapsed' );
            row.prepend( col );
            cols.push( col );
        }
        // Surplus columns on the left collapse, then leave.
        for ( let i = digits.length; i < cols.length; i++ ) {
            const col = cols[ i ];
            if ( col.classList.contains( 'is-collapsed' ) ) continue;
            col.classList.add( 'is-collapsed' );
            setTimeout( () => { if ( col.classList.contains( 'is-collapsed' ) && cols.indexOf( col ) >= digits.length ) { col.remove(); cols.splice( cols.indexOf( col ), 1 ); } }, instant ? 0 : ROLL_MS );
        }
        void row.offsetWidth;

        digits.forEach( ( t, i ) => {
            const col = cols[ i ];
            col.classList.remove( 'is-collapsed' );
            const from = fromZero ? 0 : col._pos % 10;
            if ( instant ) { place( col, t ); return; }
            place( col, from );
            // Forward only, like a real counter; the right-hand digits take extra turns.
            const extra = i === 0 ? 20 : i === 1 ? 10 : 0;
            const target = from + ( ( t - from + 10 ) % 10 ) + ( fromZero ? 10 : extra );
            void col.offsetWidth;
            place( col, Math.min( target, CELLS - 1 ), ROLL_MS, ( digits.length - 1 - i ) * STAGGER );
            clearTimeout( col._settle );
            col._settle = setTimeout( () => place( col, t ), ROLL_MS + digits.length * STAGGER + 50 );
        } );
    };
    const zero = () => cols.forEach( ( col ) => place( col, 0 ) );
    return { set, zero };
}
