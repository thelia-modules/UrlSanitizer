# UrlSanitizer

This module allows you to sanitize your urls.

Only compatible with Thelia >= 2.4.0.

For Thelia <= 2.4.0 you can install this module https://github.com/thelia-modules/UrlRemoveAccent
but he only replace accent and he override Thelia url sanitize.

## Installation

```
composer require thelia/url-sanitizer-module ~1.0.0
```

## Usage

- If the module is activated, every rewritten url saved will be automatically sanitized.
- If you want to sanitize the existing urls in your database, go to the module configuration and follow the instructions.
