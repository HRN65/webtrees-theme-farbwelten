# Farbwelten

> **No longer maintained.** This module is archived as of November 2026. It still works with webtrees 2.2, but there will be no further updates.

A theme for [webtrees](https://webtrees.net) 2.2 with four colour palettes in a single module. The palette can be switched from the header menu, like in the core "colors" theme.

*Deutsche Version: [README.de.md](README.de.md)*

| Palette | Description |
|---|---|
| **Hell** (light) | Navy and gold on a warm paper tone. The default. |
| **Dunkel** (dark) | Dark mode with amber accents. |
| **Sepia** | Book-print look for printed family books, includes a print stylesheet. |
| **Bordeaux** | Wine red and gold on cream. |

All palettes share one structural stylesheet and differ only in their colour variables. Text contrast meets WCAG AA (4.5:1 or better) in every palette.

## Screenshots

Sepia:

![Sepia palette](docs/sepia.png)

Dunkel (dark):

![Dark palette](docs/dunkel.png)

## Features

- Palette picker in the header menu. Each user keeps their own choice, and when an administrator picks a palette it becomes the site default for visitors.
- Serif headings (Georgia), styled tables, fact sheets, forms, tabs, dropdowns and chart boxes.
- Menu icons as masked SVGs that take on the colours of the active palette.
- Print stylesheet in the Sepia palette: navigation is hidden, colours switch to black on white.
- Responsive, based on the webtrees minimal theme (Bootstrap 5).
- Version check: the webtrees control panel reports when a new release is available.

## Requirements

- webtrees 2.2.x
- PHP 8.2 or newer

## Installation

1. Download the [latest release](https://github.com/thobgg/webtrees-theme-farbwelten/releases).
2. Unpack it to `modules_v4/theme-farbwelten/` in your webtrees installation.
3. Check that the module is enabled under *Control panel → Modules → All modules → Farbwelten*.
4. Select **Farbwelten** in the theme menu, or set it as default under *Control panel → Website preferences → Default theme*.
5. Pick a palette from the new **Palette** menu in the header.

## Adding your own palette

The layout lives in `resources/css/base.css` and only uses CSS custom properties (`--fa-*`). A palette is a single CSS file that sets these variables.

1. Copy `resources/css/palette-hell.css` to `resources/css/palette-<name>.css` and adjust the values. The required variables are documented in [PALETTEN-KONTRAKT.md](PALETTEN-KONTRAKT.md) (in German; the variable names and code samples speak for themselves).
2. Add the palette to the `palettes()` method in `module.php`.

## Notes

The icon set also covers the menu classes of the [Sammlungen](https://github.com/thobgg/webtrees-sammlungen) and [Ortsregister](https://github.com/thobgg/webtrees-ortsregister) modules. Without these modules the selectors never match, so there are no side effects.

## License

GPL-3.0, see [LICENSE](LICENSE). Based on theme code from webtrees, © webtrees development team.
