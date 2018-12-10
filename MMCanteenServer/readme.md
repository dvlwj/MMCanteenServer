# MMCanteen API

## Installation
  1. clone this repo `git clone https://github.com/egin10/MMCanteenServer.git`.
  2. move to `MMCanteenServer` directory.
  3. install dependencies use `composer install`.
  4. edit and config file `.env` for your connection to database.
  5. migrate databases with `php artisan migrate` command.
  6. run service with `php artisan serve` command.

## Content API

### Login
URL     : `localhost:8000/api/v1/user/signin`\s\s
method  : `POST`\s\s
params  : `name` and `password`\s\s
header : `application/json`\s\s
result  : 

    {
        "msg": "User signin",
        "user": {
            "id": 1,
            "name": "admin",
            "role": "admin",
            "created_at": "2018-11-21 03:55:27",
            "updated_at": "2018-11-21 03:55:27"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvdXNlci9zaWduaW4iLCJpYXQiOjE1NDQxMTI1ODcsImV4cCI6MTU0NDExNjE4NywibmJmIjoxNTQ0MTEyNTg3LCJqdGkiOiJhOHBLNlFxazhnZnFrVzREIn0.JhOqH3c2bsJKjLxhmJ8P1ecT1A7798Q2DC7BtqdXpSo" 
    }
    
### Tahun Ajaran
**Get All Data**\s\s
URL : `localhost:8000/api/v1/th-ajaran`\s\s
method : `GET`\s\s
params : none\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "msg": "List of Tahun Ajaran",
        "data": [
            {
                "id": 1,
                "tahun": "2018",
                "created_at": "2018-11-21 04:41:33",
                "updated_at": "2018-11-21 04:41:33",
                "detail": {
                    "link": "api/v1/th-ajaran/1",
                    "method": "GET"
                }
            },
            {
                "id": 2,
                "tahun": "2019",
                "created_at": "2018-11-21 04:41:38",
                "updated_at": "2018-11-21 04:41:38",
                "detail": {
                    "link": "api/v1/th-ajaran/2",
                    "method": "GET"
                }
            },
            {
                "id": 3,
                "tahun": "2020",
                "created_at": "2018-11-21 04:41:43",
                "updated_at": "2018-11-21 04:42:29",
                "detail": {
                    "link": "api/v1/th-ajaran/3",
                    "method": "GET"
                }
            }
        ]
    }
    
**View/Detail Data**\s\s
URL : `localhost:8000/api/v1/th-ajaran/{id}`\s\s
method : `GET`\s\s
params : `id`\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "msg": "Detail Tahun Ajaran",
        "data": {
            "id": 1,
            "tahun": "2018",
            "created_at": "2018-11-21 04:41:33",
            "updated_at": "2018-11-21 04:41:33",
            "update": {
                "link": "api/v1/th-ajaran/1",
                "method": "PATCH"
                }
            }
    }

**Edit Data**\s\s
URL : `localhost:8000/api/v1/th-ajaran/{id}`\s\s
method : `PUT` or `PATCH`\s\s
params : `id`, `tahun`\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "msg": "Tahun Ajaran updated",
        "th_ajaran": {
            "id": 1,
            "tahun": "2017",
            "created_at": "2018-11-21 04:41:33",
            "updated_at": "2018-12-08 10:15:18"
            }
    }

**Delete Data**\s\s
URL : `localhost:8000/api/v1/th-ajaran/{id}`\s\s
method : `DELETE`\s\s
params : `id`\s\s
header : `application/json` and `token`\s\s
result : 

    {
    "msg": "Tahun Ajaran deleted",
    "create": {
        "link": "api/v1/th-ajaran",
        "method": "POST",
        "params": "tahun"
        }
    }

### Kelas
**Get All Data**\s\s
URL : `localhost:8000/api/v1/kelas`\s\s
method : `GET`\s\s
params : none\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "msg": "List of Kelas",
        "kelas": [
            {
                "id": 1,
                "name": "3A",
                "created_at": "2018-11-21 04:09:48",
                "updated_at": "2018-11-21 04:09:48",
                "detail_kelas": {
                    "link": "api/v1/kelas/1",
                    "method": "GET"
                }
            },
            {
                "id": 2,
                "name": "3B",
                "created_at": "2018-11-21 04:09:53",
                "updated_at": "2018-11-21 04:09:53",
                "detail_kelas": {
                    "link": "api/v1/kelas/2",
                    "method": "GET"
                }
            },
            {
                "id": 3,
                "name": "3C",
                "created_at": "2018-11-21 04:09:57",
                "updated_at": "2018-11-21 04:09:57",
                "detail_kelas": {
                    "link": "api/v1/kelas/3",
                    "method": "GET"
                }
            }
        ]
    }

**View/Detail Data**\s\s
URL : `localhost:8000/api/v1/kelas/{id}`\s\s
method : `GET`\s\s
params : `id`\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "id": 1,
        "name": "3A",
        "created_at": "2018-11-21 04:09:48",
        "updated_at": "2018-11-21 04:09:48",
        "update": {
            "link": "api/v1/kelas/1",
            "method": "PATCH"
        }
    }

**Edit Data**\s\s
URL : `localhost:8000/api/v1/kelas/{id}`\s\s
method : `PUT` or `PATCH`\s\s
params : `id` and `name`\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "msg": "Kelas updated",
        "kelas": {
            "id": 1,
            "name": "4A",
            "created_at": "2018-11-21 04:09:48",
            "updated_at": "2018-12-10 15:26:36"
        }
    }

**Delete Data**\s\s
URL : `localhost:8000/api/v1/kelas/{id}`\s\s
method : `DELETE`\s\s
params : `id`\s\s
header : `application/json` and `token`\s\s
result : 

    {
        "msg": "Kelas deleted",
        "create": {
            "link": "api/v1/kelas",
            "method": "POST",
            "params": "name"
        }
    }