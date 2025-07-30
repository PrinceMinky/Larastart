@props([
    'lang' => 'html',
    'highlight' => true,
    'plugin' => 'shiki',
])

@php
use Illuminate\Support\Str;

// === General Settings ===
$lineNumbers = $plugin === 'prism' && (
    $attributes->has('prism:line-numbers') || $attributes->get('prism:line-numbers') === true
);

// === Shiki Plugin Handling ===
if ($plugin === 'shiki') {
    $theme = strtolower($attributes->get('shiki:theme', 'vitesse-light'));
    $themeNotFound = false;
    $themeView = null;

    $defaultThemes = [
        'andromeeda', 'aurora-x', 'ayu-dark', 'catppuccin-frappe', 'catppuccin-latte',
        'catppuccin-macchiato', 'catppuccin-mocha', 'dark-plus', 'dracula', 'dracula-soft',
        'everforest-dark', 'everforest-light', 'github-dark', 'github-dark-default',
        'github-dark-dimmed', 'github-dark-high-contrast', 'github-light', 'github-light-default',
        'github-light-high-contrast', 'gruvbox-dark-hard', 'gruvbox-dark-medium',
        'gruvbox-dark-soft', 'gruvbox-light-hard', 'gruvbox-light-medium', 'gruvbox-light-soft',
        'houston', 'kanagawa-dragon', 'kanagawa-lotus', 'kanagawa-wave', 'laserwave',
        'light-plus', 'material-theme', 'material-theme-darker', 'material-theme-lighter',
        'material-theme-ocean', 'material-theme-palenight', 'min-dark', 'min-light',
        'monokai', 'night-owl', 'nord', 'one-dark-pro', 'one-light', 'plastic',
        'poimandres', 'red', 'rose-pine', 'rose-pine-dawn', 'rose-pine-moon',
        'slack-dark', 'slack-ochin', 'snazzy-light', 'solarized-dark', 'solarized-light',
        'synthwave-84', 'tokyo-night', 'vesper', 'vitesse-black', 'vitesse-dark', 'vitesse-light',
    ];

    $customThemes = collect(File::files(resource_path('views/flux/code/themes')))
        ->map(fn($file) => Str::before($file->getFilename(), '.blade.php'))
        ->map(fn($name) => strtolower($name))
        ->toArray();

    $allThemes = array_merge($defaultThemes, $customThemes);

    if (!in_array($theme, $allThemes, true)) {
        $theme = 'vitesse-light';
        $themeNotFound = true;
    }

    if (in_array($theme, $customThemes, true)) {
        $themeView = "flux.code.themes.{$theme}";
    }

    $rawCode = html_entity_decode(trim($slot));
    $divId = 'shiki-' . md5($rawCode);
}

// === Code Class & Pre Styles ===
$codeLangClass = !$highlight && $lineNumbers
    ? 'language-none'
    : ($highlight ? "language-{$lang}" : '');

$preClasses = Flux::classes()
    ->add($codeLangClass)
    ->add($lineNumbers ? 'line-numbers' : '')
    ->add('overflow-x-auto whitespace-pre');
@endphp

@if ($highlight && $plugin === 'shiki')
    <div id="{{ $divId }}">Loading...</div>

    @if ($themeView)
        @include($themeView)
    @endif

    <script type="module">
        import { codeToHtml } from 'https://esm.sh/shiki@3.0.0';

        const themeNotFound = @json($themeNotFound);
        const code = @json($rawCode);
        const lang = @json($lang);
        const divId = @json($divId);
        const themeName = @json($theme);

        let theme;

        if(themeNotFound) {
            console.log('Required to load default theme as the selected theme was not found.');
        }

        if (themeName === 'flux-light') {
            theme = fluxLightTheme;
        } else if (themeName === 'flux-dark') {
            theme = fluxDarkTheme;
        } else {
            const themeModule = await import(`https://esm.sh/@shikijs/themes/${themeName}`);
            theme = themeModule.default;
        }

        const html = await codeToHtml(code, { lang, theme });
        document.getElementById(divId).innerHTML = html;
    </script>

    @assets
        <style>
            .shiki {
                max-height: 30rem;
                overflow-y: auto;
                overflow-x: auto;
                padding: 1rem;
                font-family: monospace;
            }
        </style>
    @endassets

@elseif ($highlight)
    <pre {{ $attributes->class($preClasses) }} style="max-height: 30rem; overflow-y: auto; overflow-x: auto; padding: 1rem; font-family: monospace;">
        <code class="{{ $codeLangClass }}">{!! $slot !!}</code>
    </pre>

    @assets
        <link href="https://cdn.jsdelivr.net/npm/prismjs/themes/prism.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/prismjs/plugins/toolbar/prism-toolbar.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/prismjs/prism.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prismjs/plugins/autoloader/prism-autoloader.min.js"></script>

        @if ($lineNumbers)
            <link href="https://cdn.jsdelivr.net/npm/prismjs/plugins/line-numbers/prism-line-numbers.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/prismjs/plugins/line-numbers/prism-line-numbers.min.js"></script>
        @endif
    @endassets

@else
    <pre style="max-height: 30rem; overflow-y: auto; overflow-x: auto; padding: 1rem; font-family: monospace;">
        <code>{!! $slot !!}</code>
    </pre>
@endif
