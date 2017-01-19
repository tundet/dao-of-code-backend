# Dao of Code API

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
    * username
    * password
    * email

### Authentication

**POST:**

* /signin - Sign in to the application.

    Required fields:
    * username
    * password

If the sign-in attempt is successful, a new session token will be generated
and sent back in the `api_token` attribute of the JSON response.

* /signout - Sign out of the application.

    Required fields:none