# APIDoc

## Login

User login

**URL** : `/api/user/login`

**Method** : `POST`

**Auth required** : NO

**Body constraints**

```json
{
    "email": "[valid email address]",
    "password": "[password in plain text]"
}
```

**Body example**

```json
{
    "username": "marquardt.kales@gmail.com",
    "password": "abcd1234"
}
```

#### Success Response

**Code** : `200 OK`

**Response content example**

```json
{
    "code": 200,
    "data": {
        "user": {
            "id": 1,
            "firstname": "Mac",
            "lastname": "Boyle",
            "phone": "1-329-237-2659 x807",
            "email": "marquardt.kales@gmail.com",
            "email_verified_at": null,
            "is_admin": 0,
            "avatar": null,
            "created_at": "2020-10-15T03:49:17.000000Z",
            "updated_at": "2020-10-15T03:49:17.000000Z"
        },
        "token": {
            "token_type": "Bearer",
            "expires_in": 31622399,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjlhYzMxNTFhZjU1NzFkMTU5YTcyNDc0ODAyNTVkZThhOTliMjg0NzZhNDhjYmZmNDUyZWU0ODJiYmRlMDI5MDU0NmMwNzU3OWZlMjAwYzIiLCJpYXQiOjE2MDI3MzM4ODEsIm5iZiI6MTYwMjczMzg4MSwiZXhwIjoxNjM0MjY5ODgxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.BlJe3-duHrnN_jzbrRL4D3vTCoeb_wFpdmnDb5QtRCGP3nC2n5yuVxHib7SX44dV7PZcczWrDEry3YtqriHjCViGiNtUqykgdYJvZ88xt6fQlPst2PzwhJRIpki7hDHBHpBTYwUYINtZLNbuna3zxBZR4fz1n6f8syayW10bx9T60rUgdMfXgb5BLGXwHgHQw7PX65hE7nmhmiSQBNOHtQumadZEI977jzUoHBq7Qoryo7gAlQAJtiiE_GB-IRCrqZCyj0hUhCYXRQlUSmGumkbjD7o5_N9slsTfqn0AkKt3SYawGtxW3uyIDce2N-HpPS35cnmqV3txAi8vqjQ3mo5LwB0tuR5DTNsm-8Q_qpEkFz8sO18nOtvHmnYYUfDhHZL6uzYPyF9RRsY37O2rZqiKM6ZEKVNbTrYYqOlbXIqoZcYY5yx_msJIa2JavukrGwWbj0TMNznxkOOhX4UX9X48mJG7QOApmn6C6IhMoYM8Hf65PqPh3EH1iy_cDdudO6becvtw5nGN8agHki6BhdaILBlQ_a6s8h-AuTm1qocJjw_Or8xbOrJ-fbDJ2yweO5L_yxf_UbDsVieESf8S2HI53SuSqeEtfT1uvfZ5exuEXvcjwyhDsutyxK_VriE3shsKOM8N0tbAtdYIWUWo-UP8tEVpA29U6H20hoq-5Lw"
        }
    },
    "message": "ok"
}
```

#### Error Response

**Condition** : If 'email' and 'password' combination is wrong.

**Code** : `401 Unauthorized`

**Content** :

```json
{
    "code": 401,
    "data": [],
    "message": "The user credentials were incorrect."
}
```

## Create User's Account

Create an Account for the authenticated User if an Account for that User does
not already exist. Each email can only have one Account.

**URL** : `/api/user/create`

**Method** : `POST`

**Auth required** : NO

**Permissions required** : None

**Body constraints**

```json
 {
            "firstname": "[string]",
            "lastname": "[string]",
            "email": "[valid email address and unique in users]",
            "phone": "[string]",
            "password":"[min 8 chars min]",
            "is_admin": "[options, boolean, true for create root user]"
}
```

**Data example** All fields must be sent.

```json
 {
            "firstname": "Mac",
            "lastname": "Boyle",
            "email": "marquardts.kalee@gmail.com",
            "phone": "1-329-237-2659 x807",
            "password":"1qaz2wsx"
}
```

#### Success Response

**Condition** : If everything is OK and an Account didn't exist for this User.

**Code** : `200`

**Content example**

```json
{
    "code": 200,
    "data": {
        "user": {
            "firstname": "Masc",
            "lastname": "Boylde",
            "email": "marquardtse.kalee@gmail.com",
            "phone": "1-329-237-26259 x807",
            "updated_at": "2020-10-15T05:51:00.000000Z",
            "created_at": "2020-10-15T05:51:00.000000Z",
            "id": 6
        },
        "token": {
            "token_type": "Bearer",
            "expires_in": 31622399,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZTM5ZmFmNGI3NTAwYThkZjdiOGY3MzFmZDNhM2RmYjljY2Q5MGQ2NzZhMWUyNGViNDlhZmNhZTNkYmJiZjI1OGUwNDQyMzUwMDNmZDk3OGYiLCJpYXQiOjE2MDI3NDEwNjAsIm5iZiI6MTYwMjc0MTA2MCwiZXhwIjoxNjM0Mjc3MDYwLCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.qNQaV8OLXsslMVcxhmioXtSOtxu4NiHWJRdXNMszKfe1pannNNbUiHzwKBILvZVQRX6XCFh-xbyEKsbppQKJ7ZFsSs9G6ydeIiEHknsv4u7rSpwVVa_GE110lG2HMR5w9xovRcEpAunG8xrnjE_wMNXSSFYnkTz3-d9An1nFAPb_ykk0Irf3HOJ9lJZVDgYMr_iqI4FF7BC9Mz-am6tKzZk2gP41rTSYxcsgi9k4l2U833blMb7LzjKT4KlJmW3e0DOGlPiqtwJb3MO_sNWdBXAwx2Qc-mKc60Ip3LCkklFNe3aZovDzHyKc7JRBlSxDSrIcXG5Q8yjJ-9z9G_i9MGYZagWrSaL5Ai7rmU82iCDLCFPETrmp67OFOxASXzRlfDjVC9X6It7F-kio8RCT5pCTe_mecRiS-Q5SbjFY6k0L8PHfbYb6UFNsdungCeS75N9YNHVHb6mAHVw8i_F61xZVzk_Mjdd2Zq7s3w8OX05zG-EHYF9ZGcA5Deaim4LxW_k_nyF2d0FtXUCUP7-MN8vysHa-1JwUKc2p-iH1RSTyiCEIsQO_bMBXtkM2O08mu8dzkpjUQDyckCBifwoji-s9P5tskeTXgoX3JikbXQjwLjMa8fp-x1VSAR9iqwf54TNEWCTU9YnAAAltg2j3IGljWwv4TcAqYaKobLdHO6s"
        }
    },
    "message": "ok"
}
```

#### Error Responses

**Condition** : If fields are missed or andy other fields validate fails.

**Code** : `422 Unprocessable Entity`

**Content example**

```json
{
    "code": 422,
    "data": [
        "The email has already been taken.",
        "The password field is required."
    ],
    "message": "Unprocessable Entity response"
}
```

## Read User Information

Show user information.

**URL** : `/api/user/{user id}`

**URL Parameters** : `user id=[integer]` where `user id` is the ID of the user.

**Method** : `GET`

**Auth required** : YES

**Permissions required** : Can only read auth user's own information, root user can read any.

**Data constraints** : `{}`


#### Success Responses

**Condition** : User can not see any Accounts.

**Code** : `200 OK`

**Content** : 
```json
{
    "code": 200,
    "data": {
        "user": {
            "id": 1,
            "firstname": "Mac",
            "lastname": "baibai",
            "phone": "1-329-237-2659 x807",
            "email": "marquardt.kales@gmail.com",
            "email_verified_at": null,
            "avatar": "http://localhost:9086/storage/avatars/zaZlkw7ZptRe9eiGm7IjykzJfEH06Vh05BghzwDE.jpeg",
            "created_at": "2020-10-15T03:49:17.000000Z",
            "updated_at": "2020-10-15T04:24:14.000000Z"
        }
    },
    "message": "ok"
}
```
## Update User information
Allow the Authenticated User to update their details, root user can update any.

**URL** : `/api/user/{user id}`

**URL Parameters** : `user id=[integer]` where `user id` is the ID of the user.

**Method** : `PUT`

**Auth required** : YES

**Permissions required** : None

**Data constraints**

```json
 {
            "firstname": "[option,string]",
            "lastname": "[option,string]",
            "email": "[option,valid email address and unique in users]",
            "phone": "[option,string]",
            "password":"[option,min 8 chars min]",
            "avatar": "[option,image url]"
}
```

**Data examples**

Partial data will be allowed. Null value field will be ignored.

```json
{
    "firstname": "John"
}
```

#### Success Responses

**Condition** : Data provided is valid and User is Authenticated.

**Code** : `200 OK`

**Content example** : 

```json
{
    "code": 200,
    "data": {
        "user": {
            "id": 1,
            "firstname": "kale",
            "lastname": "baibai",
            "phone": "1-329-237-2659 x807",
            "email": "marquardt.kaleee@gmail.com",
            "email_verified_at": null,
            "avatar": "http://localhost/storage/avatars/zaZlkw7ZptRe9eiGm7IjykzJfEH06Vh05BghzwDE.jpeg",
            "created_at": "2020-10-15T03:49:17.000000Z",
            "updated_at": "2020-10-15T06:03:58.000000Z"
        }
    },
    "message": "ok"
}
```

#### Error Responses

**Condition** : If fields validate fails.

**Code** : `422 Unprocessable Entity`

**Content example**

```json
{
    "code": 422,
    "data": [
        "The email has already been taken."
    ],
    "message": "Unprocessable Entity response"
}
```

## Upload User Avatar
Allow the Authenticated User to upload avatar image.

**URL** : `/api/user/avatar`

**Method** : `POST`

**Auth required** : YES

**Permissions required** : None

**Data constraints**
avatar field must be an image file.
```json
{
    "avatar":"[required, image file]"
}
```

**Data examples**

#### Success Responses

**Condition** : Data provided is valid and User is Authenticated.

**Code** : `200 OK`

**Content example** : 

```json
{
    "code": 200,
    "data": {
        "url": "http://localhostg/storage/avatars/zaZlkw7ZptRe9eiGm7IjykzJfEH06Vh05BghzwDE.jpeg"
    },
    "message": "ok"
}
```

#### Error Responses

**Condition** : If fields validate fails.

**Code** : `422 Unprocessable Entity`

**Content example**

```json
{
    "code": 422,
    "data": [
        "The avatar must be an image."
    ],
    "message": "Unprocessable Entity response"
}
```

## Delete User

Delete the Account of the Authenticated User if they are Root user.

**URL** : `/api/user/{user id}`

**URL Parameters** : `user id=[integer]` where `user id` is the ID of the user.

**Method** : `DELETE`

**Auth required** : YES

**Permissions required** : User is Root User.

**Data** : `{}`

#### Success Response

**Condition** : If the Account exists.

**Code** : `200`

**Content** : 
```json
{
    "code": 200,
    "data": [],
    "message": "ok"
}
```

#### Error Responses

**Condition** : If there was no Account available to delete.

**Code** : `500 Internal Server Error`

**Content** : 
```json
{
    "code": 500,
    "data": [],
    "message": "No query results for model [App\\Models\\User] 4"
}
```

**Condition** : Authorized User is not Owner of Account at URL.

**Code** : `403 FORBIDDEN`

**Content** : 
```json
{
    "code": 403,
    "data": [],
    "message": "User has no permission."
}
```
## Search User
Search user by filter.

**URL** : `/api/user/search`

**Method** : `GET`

**Auth required** : YES

**Permissions required** : None.

**Data constraints**

```json
 {
            "firstname": "[option,string]",
            "lastname": "[option,string]",
            "email": "[option,valid email address and unique in users]",
            "phone": "[option,string]"
}
```

**Data examples**

Partial data will be allowed. Null value field will be ignored.

```json
{
    "firstname": "John"
}
```

#### Success Response

**Code** : `200`

**Content** : 
```json
{
    "code": 200,
    "data": {
        "total": 2,
        "data": [
            {
                "id": 3,
                "firstname": "John",
                "lastname": "coywe",
                "phone": "1-321-232-2659 x807",
                "email": "marquardt.kalee@gmail.com"
            },
            {
                "id": 5,
                "firstname": "John",
                "lastname": "Boyle",
                "phone": "1-329-237-2659 x807",
                "email": "marqts.ope@gmail.com"
            }
        ]
    },
    "message": "ok"
}
```
