# User Extension Sprinkle

Example sprinkle for extending the User class to contain additional fields.

## Install
`cd` into the sprinkle directory of UserFrosting and clone as submodule:
```
git submodule add git@github.com:userfrosting/extend-user.git extend-user
```

### Add to the sprinkle list
Edit UserFrosting `app/sprinkles/sprinkles.json` file and add `extend-user` to the sprinkle list to enable it.

### Update the assets build & composer

- From the UserFrosting `/build` directory, run `npm run uf-assets-install`
- Run `composer update` from the `app/` directory.

### Run migration

- From the `migrations/` directory, run `php install.php`.  This should discover and run the migration in the Sprinkle, creating the new table.
