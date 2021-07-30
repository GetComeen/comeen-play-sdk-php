# SDK's Command Line Interface

## Setup project:
> install

Proceed to complete installation including DB setup, composer, npm...

### Global Options
```array
--no-interaction (bool) => Does not asks to confirm operation,
```

## Application

### Import
Import application using: github, gitlab, path, zip
> app:import {--type=} {src}

Arguments:
```array
src => [url or path]
type => [github, gitlab, path, zip]
```

### Update
Update specific application
> app:update {app} {src}

Arguments:
```array
app => [application id],
src => [url or path]
type => [github, gitlab, path, zip]
```

Options:
```array
--all => Update all applications
```

### Sync
Sync specific application (confirmation)
> app:sync {app}

Arguments:
```array
app => [application id],
```

Options:
```array
--all => Sync all applications
```

### Delete
Delete specific application (confirmation)
> app:delete {app}

Arguments:
```array
app => [application id],
```

## Users

### Create
Create a user
> user:create {name} {pass}

Arguments:
```array
name => Name used on the GUI (fullname),
pass => Password for the new user,
```

### Update
Update a user for the given fields, remaining fields stays untouched
> user:update {user}

Arguments:
```array
user => Id of the user,
{user_attribute} => value,
```

### Delete
Delete specific user (confirmation)
> user:delete {user}

Arguments:
```array
user => Id of the user,
```

## Auths Access

### Generate
Create private auth and generates its token
> auth:generate --less --with {name}

Arguments:
```array
name => [auth name mainly used to display],
```

Options:
```array
--except => [ids] (every apps/bundles access allowed except those provided here)
--only => [ids] (none apps/bundles access allowed except those provided here)
```

### Renew-token
Create private auth and generates its token
> auth:renew-token {auth}

Arguments:
```array
auth => [Auth id],
```

Options:
```array
--all => If provided, renew every auth access tokens
```

### Delete
Create private auth and generates its token
> auth:delete {auth}

Arguments:
```array
auth => [Auth id],
```

Options:
```array
--all => If provided, delete every auth access
```

## Bundle

### Import
Import application using: github, gitlab, path, zip
> bundle:create {name} {apps}

Arguments:
```array
name => "Bundle's name"
apps => [apps id]
description => "Describe your bundle possibilies"
```
