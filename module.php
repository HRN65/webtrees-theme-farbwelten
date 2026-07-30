<?php

/**
 * Farbwelten – a webtrees theme with four colour palettes.
 *
 * Modelled on the core "colors" theme (app/Module/ColorsTheme.php):
 * palette switcher in the user menu, stored per user, an admin's
 * choice becomes the site default.
 *
 * Structure: resources/css/base.css (shared, consumes var(--fa-*))
 *            resources/css/palette-{hell,dunkel,sepia,bordeaux}.css
 * Contract:  PALETTEN-KONTRAKT.md
 *
 * Fully reversible: select another theme or delete this folder.
 */

declare(strict_types=1);

use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Menu;
use Fisharebest\Webtrees\Module\MinimalTheme;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Session;
use Fisharebest\Webtrees\Site;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return new class extends MinimalTheme implements ModuleCustomInterface {
    use ModuleCustomTrait;

    private const DEFAULT_PALETTE = 'hell';

    public function title(): string
    {
        // Proper noun – not translated.
        return 'Farbwelten';
    }

    public function description(): string
    {
        return I18N::translate('One theme, four palettes: light, dark, sepia and bordeaux – switchable from the header menu.');
    }

    public function customModuleAuthorName(): string
    {
        return 'Thomas Bugge';
    }

    public function customModuleVersion(): string
    {
        return '1.1.0';
    }

    public function customModuleLatestVersionUrl(): string
    {
        return 'https://raw.githubusercontent.com/thobgg/webtrees-theme-farbwelten/main/latest-version.txt';
    }

    public function customModuleSupportUrl(): string
    {
        return 'https://github.com/thobgg/webtrees-theme-farbwelten';
    }

    /**
     * @return array<string,string>
     */
    public function customTranslations(string $language): array
    {
        if ($language === 'de') {
            return [
                'One theme, four palettes: light, dark, sepia and bordeaux – switchable from the header menu.'
                    => 'Ein Theme, vier Paletten: Hell, Dunkel, Sepia und Bordeaux – umschaltbar im Kopfmenü.',
                'Light'    => 'Hell',
                'Dark'     => 'Dunkel',
                'Sepia'    => 'Sepia',
                'Bordeaux' => 'Bordeaux',
            ];
        }

        return [];
    }

    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }

    /**
     * Header menu as in the core "colors" theme: standard items plus palette picker.
     *
     * @return array<Menu>
     */
    public function userMenu(Tree|null $tree): array
    {
        return array_filter([
            $this->menuPendingChanges($tree),
            $this->menuMyPages($tree),
            $this->menuThemes(),
            $this->menuPalette(),
            $this->menuLanguages(),
            $this->menuLogin(),
            $this->menuLogout(),
        ]);
    }

    /**
     * Switch palettes (POST from the menu, data-wt-post-url).
     */
    public function postPaletteAction(ServerRequestInterface $request): ResponseInterface
    {
        $user    = Validator::attributes($request)->user();
        $palette = Validator::queryParams($request)->isInArrayKeys($this->palettes())->string('palette');

        $user->setPreference('fa-palette', $palette);

        // An admin's choice becomes the site default (also used for visitors).
        if (Auth::isAdmin($user)) {
            Site::setPreference('FA_DEFAULT_PALETTE', $palette);
        }

        Session::put('fa-palette', $palette);

        return response();
    }

    /**
     * Bootstrap 5.3 has no `[data-bs-theme=auto]`, so "auto" falls back to the
     * light values in `:root` — even under the dark palette. Anything base.css
     * does not derive from `--fa-*` (alerts, close buttons, select arrows,
     * DataTables stripes) would stay light. Hence: scheme follows palette.
     */
    public function bootstrapColorScheme(): string
    {
        return $this->palette() === 'dunkel' ? 'dark' : 'light';
    }

    /**
     * @return array<string>
     */
    public function stylesheets(): array
    {
        return [
            asset('css/minimal.min.css'),
            $this->assetUrl('css/base.css'),
            $this->assetUrl('css/palette-' . $this->palette() . '.css'),
        ];
    }

    protected function menuPalette(): Menu
    {
        /* I18N: A colour scheme */
        $menu    = new Menu(I18N::translate('Palette'), '#', 'menu-color');
        $palette = $this->palette();

        foreach ($this->palettes() as $palette_id => $palette_name) {
            $url = route('module', ['module' => $this->name(), 'action' => 'Palette', 'palette' => $palette_id]);

            $menu->addSubmenu(new Menu(
                $palette_name,
                '#',
                'menu-color-' . $palette_id . ($palette === $palette_id ? ' active' : ''),
                ['data-wt-post-url' => $url],
            ));
        }

        return $menu;
    }

    /**
     * @return array<string,string>
     */
    private function palettes(): array
    {
        return [
            'hell'     => I18N::translate('Light'),
            'dunkel'   => I18N::translate('Dark'),
            'sepia'    => I18N::translate('Sepia'),
            'bordeaux' => I18N::translate('Bordeaux'),
        ];
    }

    private function palette(): string
    {
        // Logged in: personal preference.
        $palette = Auth::user()->getPreference('fa-palette');

        // Otherwise: choice made earlier in this session.
        if ($palette === '') {
            $palette = Session::get('fa-palette');
            $palette = is_string($palette) ? $palette : '';
        }

        // Otherwise: site default.
        if ($palette === '') {
            $palette = Site::getPreference('FA_DEFAULT_PALETTE');
        }

        if (!array_key_exists($palette, $this->palettes())) {
            $palette = self::DEFAULT_PALETTE;
        }

        return $palette;
    }
};
