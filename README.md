# Nicode Joomla Toolkit (Joomla Library)

Reusable, modern helper library installable as a Joomla library
extension.\
Designed to reduce boilerplate and improve structure in Joomla 4, 5 and
6 extensions.

Latest stable version: **1.0.1**

------------------------------------------------------------------------

## Compatibility

-   Joomla 4.x
-   Joomla 5.x
-   Joomla 6.x

------------------------------------------------------------------------

## Installation

Install the ZIP package via:

**System → Install → Extensions → Upload Package File**

After installation, classes are autoloaded via the PSR-4 namespace
defined in the library manifest.

------------------------------------------------------------------------

## Basic Usage

``` php
use Nicode\Joomla\Toolkit\Db\Database;

$value = Database::result('SELECT 1');
```

------------------------------------------------------------------------

## Included Modules

### Database

-   `Db\Database`
    -   Query helpers
    -   Bound parameters
    -   `whereIn()` helper for safe `IN (...)` bindings

### Input

-   `Input\Request`
    -   Safe GET/POST access helpers

### Date

-   `Date\DateText`
    -   Human-readable date formatting

### HTML

-   `Html\Esc`
    -   Safe HTML escaping
-   `Html\TableBuilder`
    -   Accessible table generation

### UI

-   `Ui\ProgressBar`
    -   Accessible progress bar component

### Filesystem

-   `Fs\Cleaner`
    -   Old file cleanup utility
-   `Fs\Upload`
    -   Safe file upload handling
    -   Filename sanitization
    -   Validation and controlled move

### Assets

-   `Assets`
    -   Joomla WebAssetManager integration

### Utilities

-   `Util\Arr`
    -   Array filtering helpers
-   `Util\Json`
    -   Safe JSON encode/decode helpers
-   `Util\Id`
    -   `Id::ulid()` 26-character ULID-like public identifier generator

### Validation

-   `Validation\Validator`
    -   Lightweight fluent validation helper

------------------------------------------------------------------------

## Web Assets

This library installs:

    media/lib_nicode_joomla_toolkit/joomla.asset.json
    media/lib_nicode_joomla_toolkit/css/table.css
    media/lib_nicode_joomla_toolkit/css/progressbar.css

Example usage:

``` php
use Joomla\CMS\Factory;
use Nicode\Joomla\Toolkit\Assets;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
Assets::register($wa);

$wa->useStyle('lib_nicode_joomla_toolkit.table');
$wa->useStyle('lib_nicode_joomla_toolkit.progress');
```

------------------------------------------------------------------------

## Update Server

Configured via `<updateservers>` in the manifest.

Update XML:

    https://nicolauroca.github.io/joomla-toolkit/updates/lib_nicode_joomla_toolkit.xml

------------------------------------------------------------------------

## License

All code and assets in this package are licensed under the GNU General
Public License v2 or later (GPL-2.0-or-later).

------------------------------------------------------------------------

## Changelog

### 1.0.1

-   Installation packaging and manifest refinements
-   Added `Util\Json`
-   Added `Util\Id::ulid()`
-   Added `Validation\Validator`
-   Added `Fs\Upload`
-   Added `Db\Database::whereIn()`

### 1.0.0

-   Initial public release
-   PSR-4 architecture
-   Database, Input, Date, Html, UI, Fs and Assets modules
