# User Extension Sprinkle (UserFrosting 4.1)

Example sprinkle for extending the User class to contain additional fields.

# Installation

Edit UserFrosting `app/sprinkles.json` and add `extend-user` to the `base` list. For example:

```
{
    "base": [
        "core",
        "account",
        "admin",
        "extend-user"
    ]
}
```

### Update Composer

- Run `composer dump-autoload` from the root project directory.
- Run `composer update` from the root project directory.

### Run migration

- Run `php bakery bake` from the root project directory.
