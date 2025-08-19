# Laravel Language Sync Command

This package provides a custom Artisan command to **generate and synchronize language folders** for all supported locales using `mcamara/laravel-localization`.

## 📌 Installation

1. Copy `SyncLangFolders.php` into `app/Console/Commands/`.
2. Register the command in `app/Console/Kernel.php`.
3. Ensure `config/laravellocalization.php` contains your supported locales.

## 🚀 Usage

```bash
php artisan lang:sync-folders
```

This will:
- Create missing language folders.
- Copy missing translation keys from `resources/lang/en` into other locales.
- Preserve existing translations.

## 📂 Example Structure

```
resources/lang/
├── en/
│   └── messages.php
├── yo/
│   └── messages.php
└── fr/
    └── messages.php
```

## ⚡ Optional Advanced Usage

- **Remove stale keys** → Extend the command to remove keys not found in `en/`.
- **Export to JSON** → Add logic to dump translations into JSON for translators.

---
👤 Author: Dr. Mogbojuri Babatunde
