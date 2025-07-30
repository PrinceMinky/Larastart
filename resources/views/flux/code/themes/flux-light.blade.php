<script>
const fluxLightTheme = {
        name: 'flux-light',
        displayName: 'Flux Light',
        type: 'light',
        colors: {
            'editor.background': 'oklch(98.5% 0.001 106.423)',
            'editor.foreground': '#333333',
            'editor.lineHighlightBackground': '#f5f5f5',
            'editor.selectionBackground': '#e0e0e0',
            'editorCursor.foreground': '#333333',
            'editorLineNumber.foreground': '#999999',
            'editorLineNumber.activeForeground': '#333333',
        },
        tokenColors: [
            {
                scope: ['text'],
                settings: {
                    foreground: '#424258'
                }
            },
            {
                scope: ['punctuation.definition.tag', 'meta.tag.sgml'],
                settings: {
                    foreground: '#3B9FEC'
                }
            },
            {
                scope: ['entity.name.tag'],
                settings: {
                    foreground: '#157FD2'
                }
            },
            {
                scope: ['entity.other.attribute-name'],
                settings: {
                    foreground: '#D050A3'
                }
            },
            {
                scope: ['string', 'string.quoted'],
                settings: {
                    foreground: '#0EB0A9'
                }
            },
            {
                scope: ['keyword.operator', 'punctuation.separator'],
                settings: {
                    foreground: '#88DDFF'
                }
            },
            {
                scope: ['comment'],
                settings: {
                    foreground: '#999999',
                    fontStyle: 'italic'
                }
            },
            {
                scope: ['keyword'],
                settings: {
                    foreground: '#D050A3'
                }
            },
            {
                scope: ['variable', 'support.variable'],
                settings: {
                    foreground: '#424258'
                }
            }
        ]
    };
</script>