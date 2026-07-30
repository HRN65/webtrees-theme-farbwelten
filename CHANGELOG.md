# Changelog

## v1.1.0 (2026-07-30)

Struktur: Farbschema an die Palette gekoppelt, verdeckte Regeln repariert.

- **`bootstrapColorScheme()`** meldet jetzt `dark` für die Palette Dunkel und
  `light` für Hell, Sepia und Bordeaux. Vorher erbte das Theme `auto` vom
  `MinimalTheme` — und Bootstrap 5.3 kennt kein `[data-bs-theme=auto]`, es
  griffen also die Hell-Werte aus `:root`, auch in der dunklen Palette.
  Gemessen behoben: Hinweisfelder (Fläche `#cff4fc` → `#032830`, Kontrast
  7,7:1 → 10,0:1), Warnfelder (`#fff3cd` → `#332701`, 7,2:1 → 10,8:1),
  Schließen-Symbol (`filter: none` → `invert(1)`, vorher schwarz auf dunkel
  bei 1,3:1) und die DataTables-Variablen `--dt-row-stripe`, `--dt-row-hover`
  und `--dt-column-ordering` (`0,0,0` → `255,255,255`). Für die drei hellen
  Paletten ändert sich nachweislich nichts — `auto` und `light` liefern
  identische Werte in allen geprüften Komponenten.
- **Sechzehn wirkungslose Regeln repariert.** `vendor.min.css` ist
  RTL-vorverarbeitet: rtlcss versieht jede Regel mit richtungsabhängigen
  Eigenschaften mit `[dir]`, Bootstrap steht dort bei Spezifität 0-2-0. Unsere
  einfachen Klassenregeln bei 0-1-0 kamen nie an. Betroffen waren Eingabe- und
  Auswahlfelder samt Fokus, Kontrollkästchen, Eingabegruppen, Kartenköpfe,
  Blätterleiste und Dialoge — **in allen vier Paletten**. In Dunkel etwa
  standen Eingabefelder auf dem Seitengrund `#14181f` statt auf
  `--fa-input-bg` `#171c24`, Dialoge ebenso statt auf `--fa-card`.
- **`palette-dunkel.css` um 47 Zeilen kürzer.** Der handgeschriebene
  Sonderfall-Block für Formulare, Dialoge, Menüs, Select-Pfeil und
  Tabellentext ist überflüssig geworden; übrig bleibt die Platzhalterfarbe.
- `PALETTEN-KONTRAKT.md`: Regel 3 beschreibt jetzt die Spezifitätsfalle samt
  Reihenfolge der Gegenmittel, Regel 6 ersetzt den Sonderfall-Block durch den
  Eintrag in `bootstrapColorScheme()`.

Geprüft mit einem Komponentenspiegel in Brave (headless): 21 Bootstrap-Bau-
teile, beide Schemata nebeneinander, berechnete Farben und WCAG-Kontraste
ausgelesen statt geschätzt. Hell erreicht durchgehend ≥ 4,7:1.

## v1.0.2 (2026-07-30)

Nachtrag zu v1.0.1: die Diagramm-Boxen waren dort **nicht** behoben.

- `minimal.min.css` adressiert Boxen und Verbindungslinien mit `[dir]`-Präfix
  (Spezifität 0-2-0) und speist sie aus eigenen Variablen. Unsere Regeln bei
  0-1-0 kamen nie an: Boxflächen zeigten `--bs-body-bg` (den Seitengrund),
  Rahmen `--bs-blue`/`--bs-pink`, Linien `--bs-secondary-color`.
- Der Eingriff läuft jetzt über die Kern-Variablen `--sex-*-bg`, `--sex-*-fg`
  und `--chart-line`; der transluzente Tint liegt per `[dir] .wt-chart-box-*`
  als `background-image` über der Fläche. Das erfasst auch die Linienklassen,
  die base.css nie aufgeführt hatte (`wt-chart-horizontal-first-child`,
  `-middle-child`, `-last-parent` und weitere).
- Am gerenderten Diagramm nachgemessen: Rahmen `#7396bd`/`#bd7f96`,
  Fläche `#1d232c` + Tint, Linien `#5a626e`; von `#0d6efd` und `#d63384`
  kein Pixel mehr.
- Der Inhalt der Diagramm-Boxen wird nicht mehr unten abgeschnitten. Die
  Boxhöhe ist im Kern fest und nicht erhöhbar (die Anschlusslinien hängen
  an halber Boxhöhe), die Serifenschrift baut aber breiter als die Sans der
  Kern-Themes, sodass der Name zweizeilig umbrach und die Todeszeile
  heraus- oder verlorenging. Drei Maßnahmen:
  - Schrift im Kasten `.75rem` (`--fa-chart-box-font-size`, palettenweise
    anpassbar). Im Browser gemessen: bei diesem Wert passen Name und beide
    Ereignisse in **jeden** Kastentyp — 20rem, 15rem und 10rem×8rem — auch
    bei zweizeiligem Namen. Bei `.8125rem` läuft es um 5px über.
  - Namen auf zwei Zeilen begrenzt (in Pedigree auf/ab auf vier, dort ist
    die Box 8rem hoch), damit ein sehr langer Name die Fakten nicht
    hinausschiebt.
  - Ereignisse einzeln auf zwei Zeilen begrenzt, der Faktenblock auf vier.
    Der Clamp sitzt an den `<div class="fact_BIRT/fact_DEAT">`, nicht am
    Container — dort hätte er Geburt und Tod gemeinsam gekappt.
  Geprüft mit einem Messstand in Brave (headless) gegen alle drei
  Kastengrößen, vier Namenslängen und drei Schriftgrößen, zusätzlich als
  Stresstest mit einer 25 % breiteren Ersatzschrift: Georgia fehlt auf
  vielen Linux-Systemen, der Ersatz baut breiter.

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
