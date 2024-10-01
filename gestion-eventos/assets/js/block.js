( function( blocks, element ) {
    var el = element.createElement;

    blocks.registerBlockType( 'gestion-eventos/eventos-block', {
        title: 'Event Block',
        icon: 'calendar',
        category: 'widgets',
        edit: function() {
            return el(
                'p',
                { className: 'event-block' },
                'Este es el bloque de eventos.'
            );
        },
        save: function() {
            return el(
                'p',
                { className: 'event-block' },
                'Este es el bloque de eventos.'
            );
        }
    } ); 
} )(
    window.wp.blocks,
    window.wp.element
);
 