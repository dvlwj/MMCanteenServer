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
URL     : `localhost:8000/api/v1/user/signin` 
method  : `POST` 
params  : `name` and `password` 
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
**Get All Data**
URL : `localhost:8000/api/v1/th-ajaran`
method : `GET`  
params : none
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
    
**View/Detail Data**
URL : `localhost:8000/api/v1/th-ajaran/1`
method : `GET`
params : `id`
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

**Edit Data**
URL : `localhost:8000/api/v1/th-ajaran/1`
method : `PUT` or `PATCH`
params : `id`, `tahun`
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

**Delete Data**
URL : `localhost:8000/api/v1/th-ajaran/1`
method : `DELETE`
params : `id`
result : 

    {
    "msg": "Tahun Ajaran deleted",
    "create": {
        "link": "api/v1/th-ajaran",
        "method": "POST",
        "params": "tahun"
        }
    }
