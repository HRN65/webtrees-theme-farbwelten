# Familienarchiv-Themes · Paletten-Kontrakt

Vier Theme-Module teilen sich `resources/css/base.css` (Struktur).
Jede Palette ist eine eigene Datei `resources/css/palette-<name>.css` und definiert
**ausschließlich** die untenstehenden Custom Properties auf `:root` plus maximal
~40 Zeilen palettenspezifische Feinheiten (z. B. Dark-Mode-Sonderfälle).

Ladereihenfolge pro Theme: `minimal.min.css` → `base.css` → `palette-<name>.css`.

## Pflicht-Variablen (alle auf `:root`)

```css
:root {
  /* Typografie */
  --fa-font-heading: Georgia, "Times New Roman", serif;   /* Überschriften, Seitentitel */
  --fa-font-body:    system-ui, -apple-system, sans-serif; /* Fließtext (Kontrast-Theme: auch Headings sans) */

  /* Grundflächen */
  --fa-bg:      #f5f3ef;   /* Seitenhintergrund */
  --fa-fg:      #1a2332;   /* Fließtext */
  --fa-muted:   #6b6257;   /* Sekundärtext */
  --fa-card:    #ffffff;   /* Karten, Tabellen, Formulare */
  --fa-border:  #e2ddd6;   /* Rahmen, Trennlinien */

  /* Markenfarben */
  --fa-primary:   #1e3a5f; /* Überschriften, Primärflächen */
  --fa-accent:    #c8922a; /* Akzente, Goldlinie */
  --fa-accent-lt: #e0a83a; /* helle Akzentvariante (Verläufe, Hover) */

  /* Links */
  --fa-link:       #2E75B6;
  --fa-link-hover: #1e3a5f;

  /* Header */
  --fa-header-bg:       #1e3a5f;
  --fa-header-fg:       rgba(245, 243, 239, .9);
  --fa-header-fg-muted: rgba(245, 243, 239, .7);
  --fa-header-accent:   #c8922a;  /* Goldlinie unterm Header */
  --fa-logo-url:        url("data:image/svg+xml,..."); /* Wortmarke als Data-URI, s. u. */

  /* Tabellen */
  --fa-table-head-bg: #ece7df;
  --fa-table-stripe:  rgba(30, 58, 95, .035);
  --fa-table-hover:   rgba(200, 146, 42, .10);

  /* Formulare */
  --fa-input-bg:     #ffffff;
  --fa-input-border: #cfc8bd;
  --fa-focus-ring:   rgba(46, 117, 182, .35);

  /* Primär-Buttons */
  --fa-btn-bg:       #1e3a5f;
  --fa-btn-fg:       #f5f3ef;
  --fa-btn-hover-bg: #2E75B6;

  /* Geschlechts-Tints (wt-chart-box-m/-f/-u/-x, Icons) */
  --fa-sex-m: #84beff;
  --fa-sex-f: #ff88aa;
  --fa-sex-u: #88cc88;
  --fa-sex-x: #ccaa88;
  --fa-sex-m-bg: rgba(132, 190, 255, .18);
  --fa-sex-f-bg: rgba(255, 136, 170, .18);
  --fa-sex-u-bg: rgba(136, 204, 136, .15);
  --fa-sex-x-bg: rgba(204, 170, 136, .15);

  /* Diagramme */
  --fa-chart-line:   #9a938a;  /* Verbindungslinien Pedigree/Descendants */
  --fa-chart-box-bg: #ffffff;  /* Grundfläche wt-chart-box */
  /* optional, Standard .75rem: Schrift in den Boxen. Die Boxhöhe ist im Kern
     fest; bei .8125rem läuft ein zweizeiliger Name über und verdrängt die
     Todeszeile (im Browser gemessen). */
  --fa-chart-box-font-size: .75rem;

  /* Sonstiges */
  --fa-shadow: 0 2px 10px rgba(30, 58, 95, .25); /* Header-/Karten-Schatten */
}
```

## Wortmarke (`--fa-logo-url`)

Data-URI-SVG (URL-encoded), Vorlagen in `resources/img/`:
- `wortmarke-hell.svg` – helle Schrift/Symbole, für **dunkle** Header
- `wortmarke.svg` – dunkle Variante, für **helle** Header

Farben im SVG an die Palette anpassen (Baum-Kreis = `--fa-accent`,
Schrift = `--fa-header-fg`-äquivalent als konkreter Hexwert, „trees"-tspan
= `--fa-accent-lt`-äquivalent). Feste Größe 242×50.

## Regeln

1. Keine Struktur-Selektoren in Paletten duplizieren, die base.css schon setzt —
   nur Variablen + echte palettenspezifische Ausnahmen.
2. Alle Farbpaare müssen WCAG-AA-Kontrast einhalten (Fließtext ≥ 4.5:1).
3. `[dir]`-Präfix nur verwenden, wenn minimal.min.css an gleicher Stelle
   Spezifität erzwingt (siehe base.css).
4. Tabellenflächen ausschließlich über `--bs-table-bg` **an der Zelle** setzen.
   Bootstrap 5.3 füllt jede Zelle selbst (`.table>:not(caption)>*>*`, 0-1-2);
   Flächen an `thead`/`tr` liegen dahinter, niedriger spezifische `th`-Regeln
   verlieren.
5. `--fa-sex-*-bg` transluzent halten: base.css legt sie als `background-image`
   über `--fa-chart-box-bg`. Deckende Werte funktionieren, machen
   `--fa-chart-box-bg` in den Boxen aber wirkungslos.
6. Dark-Paletten müssen zusätzlich abdecken: `.form-control`/`.form-select`
   (dunkle Inputs), `.modal-content`, `.dropdown-menu`, `.table`-Textfarbe,
   Bootstrap `--bs-body-*`-Überschreibungen macht base.css bereits aus den
   `--fa-*`-Werten — NICHT erneut setzen.
