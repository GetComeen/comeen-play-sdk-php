### APPLICATION API v1

Repository Server may create auth access preventing access to some data. These accesses are defined using a token so please provide a correct access_token to your requests in order to access some restricted resources. \
Add a bearer to the request header with your access token: \
`Bearer: {access_token}`

## Applications
### Get all applications
> GET /v1/applications/

Parameters:
```array
version => 0.0.1-stable|alpha|beta|rc
```

### Get specific application
> GET /v1/applications/{app_id}

Parameters:
```array
version => stable|alpha|beta|rc
```

RETURN:

```json
{
  "name": "Basic Message",
  "id": "basic-message",
  "type": "dynamicscreen.app.basic-message",
  "version": "0.0.1",
  "apiLevel": "1",
  "description": "Display basic message with title and description",
  "logoUrl": "https://ds-app.com/path/to/logo",
  "modules": [
    {
      "type": "slide",
      "id": 31,
      "build_token": "token",
      "...": "..."
    },
    {}
  ]
}
```

### Get a module
> GET /v1/applications/{app_id}/{module}/{module_id}

```array
version => stable|alpha|beta|rc
```

RETURN:
```json
{
  "component_url": "",
  "options": {}
}
```

### Create a module
> GET /v1/applications/{app_id}/{module}/create

RETURN:
```json
{
  "component_url": "https://ds-app.com/builds/{app_id}/0.0.1-beta/script.js"
}
```

### Store a module
> POST /v1/applications/{app_id}/{module}

```array
options => "component data here"
```

RETURN:
```json
{
  "status": "success",
  "data": {
      "name": "Basic Message",
      "id": 42,
      "version": "0.0.1",
      "version": "stable",
      "apiLevel": "1",
      "options": {}
  }
}
```

### Edit a module
> GET /v1/applications/{app_id}/{module}/edit

SAME as Create

### Update a module
> POST /v1/applications/{app_id}/{module}/edit

SAME as Store

### Update a module
> POST /v1/applications/{app_id}/{module}/{module_id}

Parameters:
```array
formData => {}
```

RETURN:
```json
{
  "status": "success",
  "data": {
      "name": "Basic Message",
      "id": 42,
      "version": "0.0.1",
      "version": "stable",
      "apiLevel": "1"
  }
}
```

### Delete a module
> DELETE /v1/applications/{app_id}/{module}/{module_id}

RETURN:
```json
{
  "status": "success"
}
```

### Get all module from the given application (really useful ?)
> GET /v1/applications/{app_id}/modules/

```array
version => stable|alpha|beta|rc
type => *|slide|service|datasource|widget|auth-driver
```

RETURN:

### Get application builds
> GET /v1/applications/{app_id}/builds

Parameters:
```array
version => stable|alpha|beta|rc
```

RETURN scripts.js content corresponding to the given app build as JSON

### Submit a slide
> GET /v1/modules/{module_type}/

Parameters:
```array
version => stable|alpha|beta|rc
```

RETURN:

```json
{
  "name": "Greetings message",
  "version": "0.0.1",
  "id": 23,
  "type": "dynamicscreen.slide.basic-message"
}
```

## Bundles
### Get all bundles
> GET /v1/bundles/

Parameters:
```array
version => stable|alpha|beta|rc
```

RETURN:
```json
[
    {
      "id": "google-workspace",
      "full-identifier": "dynamicscreen.bundle.google-workspace",
      "name": "Google Workspace",
      "version": "0.0.1",
      "apiLevel": "1",
      "description": "Google Workspace bundle including gsheet, gdoc, gslide, datastudio and many more...",
      "logo": {
        "src": "https://ds-app.com/path/to/logo.jpeg",
        "mimeType": "image/jpeg",
        "size": 1099
      },
      "medias": [
        {
          "mimeType": "video/mpeg",
          "name": "google-workspace-presentation",
          "title": "Discover Google Workspace in 1 minute",
          "src": "https://ds-app.com/path/to/video.mpeg",
          "size": 23788
        },
        { "...": "..." }
      ]
    },
    { "...": "..." }
]
```

### Get specific bundle
> GET /v1/bundles/{bundle_id}

Parameters:
```array
version => stable|alpha|beta|rc
```

RETURN
```json
{
  "id": "google-workspace",
  "full-identifier": "dynamicscreen.bundle.google-workspace",
  "name": "Google Workspace",
  "version": "0.0.1",
  "apiLevel": "1",
  "description": "Google Workspace bundle including gsheet, gdoc, gslide, datastudio and many more...",
  "logo": {
    "src": "https://ds-app.com/path/to/logo.jpeg",
    "mimeType": "image/jpeg",
    "size": 1099
  },
  "medias": [
    {
      "mimeType": "video/mpeg",
      "name": "google-workspace-presentation",
      "title": "Discover Google Workspace in 1 minute",
      "src": "https://ds-app.com/path/to/video.mpeg",
      "size": 23788
    },
    { "...": "..." }
  ]
}
```

## Auth Providers
```array
type => google|microsoft|navitia|darksky|twitter|lumapps|yammer|unsplash|facebook
```

### Initiate a connection
> GET /v1/auth-providers/{type}/start

RETURN
```json
{
  "redirect_url": "https://ds-app.com/v1/auth/google",
  "token": "token"
}
```

### Validate a connection
> POST /v1/auth-providers/{type}

Parameters:
```array
token => "token",
callback_url => "https://dynamicscreen.xyz/auth/google"
```

RETURN
```json
{
  "data": {
    "access_token": "access_token",
    "refresh_token": "refresh_token",
    "expiration": "datetime",
    "many": "more"
  }
}
```

### Test a connection
> GET /v1/auth-provider/{type}/test

Parameters:
```array
token => "token"
```

RETURN
```json
{
  "success": true
}
```






















