# Nicodé Joomla Toolkit (Joomla Library)

Utility library for Joomla 4.x, 5.x, and 6.x designed to reuse helpers across components, modules, and plugins.

## Installation
Install the ZIP via **System → Install → Extensions**.

## What’s included (classes and purpose)
Each class is meant to reduce repetitive code in Joomla extensions.

| Module | Class | What it solves | Why it exists |
| --- | --- | --- | --- |
| `Assets` | `Nicode\Joomla\Toolkit\Assets` | Registers package assets (CSS/JS) | Centralizes WebAssetManager registration to avoid repeating paths. |
| `Db` | `Nicode\Joomla\Toolkit\Db\Database` | Small facade for queries and binds | Avoids repeating `Factory::getContainer()` and `setQuery`/`bind` boilerplate. |
| `Input` | `Nicode\Joomla\Toolkit\Input\Request` | GET/POST/REQUEST access with defaults | Reduces repeated `Input` access and keeps filters consistent. |
| `Date` | `Nicode\Joomla\Toolkit\Date\DateText` | Human-readable date ranges (es-ES) | Common in calendars/events; avoids repeated manual formatting. |
| `Html` | `Nicode\Joomla\Toolkit\Html\Esc` | HTML/attribute escaping | Keeps a single, safe escape helper for quick views. |
| `Html` | `Nicode\Joomla\Toolkit\Html\TableBuilder` | HTML tables from arrays | Converts `loadAssocList()` into a styled, accessible table. |
| `Ui` | `Nicode\Joomla\Toolkit\Ui\ProgressBar` | Accessible progress bar | Avoids rewriting ARIA markup and progress styles. |
| `Fs` | `Nicode\Joomla\Toolkit\Fs\Cleaner` | Old file cleanup | Utility to purge temp/log files without reimplementing. |
| `Util` | `Nicode\Joomla\Toolkit\Util\Arr` | Filter by key/value in arrays | Reusable filter for associative lists. |

## Basic usage
Once installed, Joomla autoloads classes via the manifest `<namespace>` mapping.

```php
use Nicode\Joomla\Toolkit\Db\Database;

$value = Database::result('SELECT 1');
```

## Examples by class

### Assets (register CSS/JS)
```php
use Joomla\CMS\Factory;
use Nicode\Joomla\Toolkit\Assets;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
Assets::register($wa);

$wa->useStyle('lib_nicode_joomla_toolkit.table');
$wa->useStyle('lib_nicode_joomla_toolkit.progress');
```

### Db\Database (queries with binds)
```php
use Joomla\Database\ParameterType;
use Nicode\Joomla\Toolkit\Db\Database;

$users = Database::objectList(
    'SELECT id, name FROM #__users WHERE block = :block',
    ['block' => [0, ParameterType::INTEGER]]
);
```

### Input\Request (GET/POST/REQUEST)
```php
use Nicode\Joomla\Toolkit\Input\Request;

$token = Request::post('token', 'STRING');
$page = Request::get('page', 'INT', 1);
```

### Date\DateText (date ranges)
```php
use Nicode\Joomla\Toolkit\Date\DateText;

$text = DateText::rangoFechasTexto('2026-02-03', '2026-02-06');
// "del 3 al 6 de febrero de 2026"
```

### Html\Esc (safe escaping)
```php
use Nicode\Joomla\Toolkit\Html\Esc;

echo '<span title="' . Esc::attr($title) . '">' . Esc::html($title) . '</span>';
```

### Html\TableBuilder (table from arrays)
```php
use Nicode\Joomla\Toolkit\Html\TableBuilder;

$html = TableBuilder::render($rows, [
    'headers' => [
        'name' => 'Name',
        'email' => 'Email',
    ],
    'highlighted' => ['email'],
    'caption' => 'User list',
]);
```

### Ui\ProgressBar (progress bar)
```php
use Nicode\Joomla\Toolkit\Ui\ProgressBar;

echo ProgressBar::render('Import progress', 65.5, [
    'showValue' => true,
    'striped' => true,
    'animated' => true,
]);
```

### Fs\Cleaner (temp cleanup)
```php
use Nicode\Joomla\Toolkit\Fs\Cleaner;

$deleted = Cleaner::deleteOldFiles(JPATH_CACHE, 24);
```

### Util\Arr (filter by key/value)
```php
use Nicode\Joomla\Toolkit\Util\Arr;

$active = Arr::filterByKeyValue($rows, 'state', 1);
```

## Included web assets
This package installs `media/lib_nicode_joomla_toolkit/joomla.asset.json` with table and progress bar styles.

## License
All code and assets in this package are licensed under GNU General Public License v2 or later (GPLv2+).

## Update server (Joomla Update System)
This package declares an update server in the manifest. The XML should be hosted at:

- `https://nicode.github.io/joomla-toolkit/updates/lib_nicode_joomla_toolkit.xml`

See the `updates/` directory in this repository for the files to publish.
