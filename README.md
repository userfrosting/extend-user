# User Extension Sprinkle (UserFrosting 4.1)

Example sprinkle for extending the User class to contain additional fields.

# Installation

Edit UserFrosting `app/sprinkles.json` and add the following to the `require` list : `"userfrosting/extend-user": "~4.1.1"`. Also add `extend-user` to the `base` list. For example:

```
{
    "require": {
        "userfrosting/extend-user": "~4.1.1"
    },
    "base": [
        "core",
        "account",
        "admin",
        "extend-user"
    ]
}
```

### Update Composer

- Run `composer update` from the root project directory.

### Run migration

- Run `php bakery bake` from the root project directory.
