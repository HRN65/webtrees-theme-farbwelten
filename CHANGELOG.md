# Changelog

## v1.0.1 (2026-07-30)

Fehlerbehebung / bug fixes — gemeldet in
[#1](https://github.com/thobgg/webtrees-theme-farbwelten/issues/1).

- Tabellenköpfe zeigen wieder `--fa-table-head-bg`. Bootstrap 5.3 füllt
  jede Zelle einzeln mit `--bs-table-bg`; die Fläche am `<thead>` lag
  dahinter, die `th`-Regel der Faktenblätter war zu niedrig spezifisch.
  Betraf Listen-Tabellen und die Label-Spalte der Personen- und
  Familienseiten in allen vier Paletten.
- Diagramm-Boxen legen die Geschlechts-Tints jetzt als `background-image`
  über `--fa-chart-box-bg`. Vorher verwarf die `background`-Kurzschreibweise
  die Grundfläche, sodass der transparente Tint direkt auf dem
  Seitenhintergrund lag: Boxen ohne Absetzung (Hell, Sepia, Bordeaux)
  bzw. zu dunkel (Dunkel).

## v1.0.0 (2026-07-11)

Erstes Release / initial release.

- Ein Theme-Modul mit vier Paletten: Hell, Dunkel, Sepia, Bordeaux.
  Paletten-Menü im Kopfbereich, Benutzer-Präferenz, Admin-Wahl wird
  Site-Standard (Muster: Core-Theme „colors").
- Gemeinsame Struktur in `base.css`: Bootstrap-Mapping, Header mit
  Wortmarke, Tabellen, Faktenblätter, Formulare, Tabs, Dropdowns,
  Diagramm-Boxen, Footer, Fokus-Ringe, Mobil-Anpassungen.
- Paletten als reine CSS-Variablen-Sätze (`--fa-*`), dokumentiert in
  `PALETTEN-KONTRAKT.md`. Kontraste nach WCAG AA geprüft.
- Menü-Icons als SVG-Masken, palettenabhängig eingefärbt.
- Sepia mit Druck-Stylesheet, Dunkel mit angepassten Formularen,
  Modalen und Dropdowns.
- Sprachen: Englisch (Quellsprache) und Deutsch.
