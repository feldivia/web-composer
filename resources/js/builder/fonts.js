/**
 * WebComposer available fonts configuration.
 * Only these 10 Google Fonts are allowed in the editor.
 */
export const fonts = [
    { value: 'Inter', name: 'Inter' },
    { value: 'Roboto', name: 'Roboto' },
    { value: 'Open Sans', name: 'Open Sans' },
    { value: 'Montserrat', name: 'Montserrat' },
    { value: 'Poppins', name: 'Poppins' },
    { value: 'Lato', name: 'Lato' },
    { value: 'Playfair Display', name: 'Playfair Display' },
    { value: 'Merriweather', name: 'Merriweather' },
    { value: 'Raleway', name: 'Raleway' },
    { value: 'Space Grotesk', name: 'Space Grotesk' },
];

export const fontNames = fonts.map(f => f.value);

/**
 * Google Fonts CDN URL for all 10 fonts.
 */
export const googleFontsUrl = 'https://fonts.googleapis.com/css2?family=Inter&family=Roboto&family=Open+Sans&family=Montserrat&family=Poppins&family=Lato&family=Playfair+Display&family=Merriweather&family=Raleway&family=Space+Grotesk&display=swap';

export default fonts;
