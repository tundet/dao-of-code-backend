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

* /signout - Sign out of the application.

    Required fields: none
