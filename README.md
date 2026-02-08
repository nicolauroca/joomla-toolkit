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



## Update server (Joomla Update System)

This library declares an update server in the manifest. Host the update XML at:

- `https://nicolauroca.github.io/joomla-toolkit/updates/lib_nicode_joomla_toolkit.xml`

See `updates/` in this repository for the files you need to publish.
