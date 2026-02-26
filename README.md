# Nicodé Joomla Toolkit (Joomla Library)

A small, modern helper library you can install in Joomla and reuse across your components, modules, and plugins.

## Install
Install the ZIP via **System → Install → Extensions**.

## Usage
Once installed, Joomla will autoload classes via the `<namespace>` mapping in the manifest.

```php
use Nicode\Joomla\Toolkit\Db\Database;

$value = Database::result('SELECT 1');
```

## Included modules
- `Db`: database helpers
- `Input`: request helpers
- `Date`: date formatting utilities
- `Html`: HTML builders (tables)
- `Ui`: small UI helpers (progress bar)
- `Fs`: filesystem helpers
- `Assets`: WebAssetManager integration helpers

## Web assets
This library installs `media/lib_nicode_joomla_toolkit/joomla.asset.json` with CSS assets.

Example:

```php
use Joomla\CMS\Factory;
use Nicode\Joomla\Toolkit\Assets;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
Assets::register($wa);

$wa->useStyle('lib_nicode_joomla_toolkit.table');
$wa->useStyle('lib_nicode_joomla_toolkit.progress');
```

## License
All code and assets in this package are licensed under the GNU General Public License v2 or later (GPLv2+).

## Changelog

### 1.0.1
- Added `Util\Json` (safe JSON encode/decode helpers).
- Added `Util\Id::ulid()` (26-char ULID-like public id generator).
- Added `Validation\Validator` (small fluent validator).
- Added `Fs\Upload` (sanitize/validate/move uploads).
- Added `Db\Database::whereIn()` helper for safe `IN (...)` bindings.

