<script>
    const fluxDarkTheme = {
        name: 'flux-dark',
        displayName: 'Flux Dark',
        type: 'dark',
        colors: {
            'editor.background': '#1e1e1e',
            'editor.foreground': '#bbbbbb',
            'editor.lineHighlightBackground': '#2a2a2a',
            'editor.selectionBackground': '#3a3a3a',
            'editorCursor.foreground': '#bbbbbb',
            'editorLineNumber.foreground': '#666666',
            'editorLineNumber.activeForeground': '#bbbbbb',
        },
        tokenColors: [
            {
                scope: ['text'],
                settings: {
                    foreground: '#EEFFFF'
                }
            },
            {
                scope: ['punctuation.definition.tag', 'meta.tag.sgml'],
                settings: {
                    foreground: '#88DDFF'
                }
            },
            {
                scope: ['entity.name.tag'],
                settings: {
                    foreground: '#81E6FF'
                }
            },
            {
                scope: ['entity.other.attribute-name'],
                settings: {
                    foreground: '#75FFC7'
                }
            },
            {
                scope: ['string', 'string.quoted'],
                settings: {
                    foreground: '#FF9BDE'
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
                    foreground: '#666666',
                    fontStyle: 'italic'
                }
            },
            {
                scope: ['keyword'],
                settings: {
                    foreground: '#75FFC7'
                }
            },
            {
                scope: ['variable', 'support.variable'],
                settings: {
                    foreground: '#EEFFFF'
                }
            }
        ]
    }
</script>