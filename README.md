# Dao of Code API

Back end for Dao of Code. Built with [Lumen](http://lumen.laravel.com).

The API can be accessed at
[https://dao-api.othnet.ga](https://dao-api.othnet.ga).
Using HTTPS is required.

## Authentication

Authentication is required for all routes except the following:

* /signin
* /signup

Users can authenticate by sending their session token in the `x-access-token`
header.

## Supported URIs

### Users

**GET:**

* /users - Get all users.
* /users/{id/username} - Get all data of a user.
* /users/{id/username}/media - Get all media of a user.
* /users/{id/username}/groups - Get all groups of a user.

**POST:**

* /users - Create a new user.

Required fields:
    
|   Field name   |     Type     |             Description             |
|----------------|--------------|-------------------------------------|
| Username       | String       | Username of the user.               |
| Password       | String       | Password of the user.               |
| Email          | String       | Email address of the user.          |

### Authentication

**POST:**

* /signin - Sign in to the application.

Required fields:

|   Field name   |     Type     |             Description             |
|----------------|--------------|-------------------------------------|
| Username       | String       | Username of the user.               |
| Password       | String       | Password of the user.               |

If the sign-in attempt is successful, a new session token will be generated
and sent back in the `api_token` attribute of the JSON response.

### Media

**GET:**

* /media - Get all media.
* /media{?key=value} - Search media
    * Example: /users?tag=php - Search media tagged as PHP.
    * Supported fields for searching: `tag`, `title`, `description`.
* /media/{id} - Get all data of a medium.

**POST:**

* /media - Create a new medium.

Required fields:
    
|   Field name   |     Type     |             Description              |
|----------------|--------------|--------------------------------------|
| file_name      | String       | Name of the file in the storage.     |
| title          | String       | Title of the media.                  |
| description    | String       | Description of the media.            |
| tag            | String       | Tag assigned to the media.           |
| media_type     | String       | Media type (text, image, video).     |

Optional fields:
    
|   Field name   |     Type     |             Description              |
|----------------|--------------|--------------------------------------|
| group_id       | Integer      | ID of the group the media belongs to.|
| group_priority | Integer      | Order of visibility in media groups. |
| mime_type      | String       | MIME type of the media.              |

**DELETE:**

* /media/{id} - Delete a medium.

### Groups

**GET:**

* /media - Get all groups.
* /media/{id} - Get all data of a group.

**POST:**

* /groups - Create a new group.

Required fields:
    
|   Field name   |     Type     |             Description              |
|----------------|--------------|--------------------------------------|
| name           | String       | Name of the group.                   |
| tag            | String       | Tag assigned to the group.           |

**DELETE:**

* /media/{id} - Delete a medium.

### Authentication

**POST:**

* /signin - Sign in to the application.

Required fields:

|   Field name   |     Type     |             Description             |
|----------------|--------------|-------------------------------------|
| Username       | String       | Username of the user.               |
| Password       | String       | Password of the user.               |

If the sign-in attempt is successful, a new session token will be generated
and sent back in the `api_token` attribute of the JSON response.

* /signout - Sign out of the application.

Required fields: none
