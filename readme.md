# MMCanteen 

## Installation
  1. clone this repo `git clone https://github.com/egin10/MMCanteenServer.git`.
  2. move to `MMCanteenServer` directory.
  3. install dependencies use `composer install`.
  4. edit and config file `.env` for your connection to database.
  5. migrate databases with `php artisan migrate` command.
  6. seeder data admin and petugas with `composer dump-autoload` and then run `php artisan db:seed --class=UsersTableSeeder`.
  7. run service with `php artisan serve` command.

## Content API for MOBILE DEV

### Login
URL     : `localhost:8000/api/v1/user/signin`  
method  : `POST`  
params  : `username` and `password`  
header : `application/json`  
result  :

    {
        "msg": "User signin",
        "user": {
            "id": 1,
            "username": "admin",
            "role": "admin",
            "created_at": "2018-11-21 03:55:27",
            "updated_at": "2018-11-21 03:55:27"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvdXNlci9zaWduaW4iLCJpYXQiOjE1NDQxMTI1ODcsImV4cCI6MTU0NDExNjE4NywibmJmIjoxNTQ0MTEyNTg3LCJqdGkiOiJhOHBLNlFxazhnZnFrVzREIn0.JhOqH3c2bsJKjLxhmJ8P1ecT1A7798Q2DC7BtqdXpSo" 
    }

### User/Petugas
**Edit Data/Change Password**  
URL : `localhost:8000/api/v1/petugas`  
method : `PATCH`   
params : `password`  
header : `application/json` and `token`  
result : 

    {
        "status": 1,
        "msg": "Password updated",
        "user": {
            "id": 2,
            "username": "petugas",
            "role": "petugas",
            "created_at": "2019-01-10 09:41:45",
            "updated_at": "2019-01-14 10:49:29"
        }
    }

### Siswa
**Get All Data**  
URL : `localhost:8000/api/v1/siswa/{kelas_id}/{th_ajaran_id}`  
method : `GET`  
params : `kelas_id` and `th_ajaran_id`  
header : `application/json` and `token`  
result : 

    {
        "msg": "List of Siswa",
        "siswa": [
            {
                "id": 2,
                "nis": "990099200193",
                "name": "Mujiono",
                "kelas_id": 1,
                "th_ajaran_id": 2,
                "created_at": "2018-12-10 20:29:21",
                "updated_at": "2018-12-10 20:29:21",
                "detail_siswa": {
                    "link": "api/v1/siswa/2",
                    "method": "GET"
                }
            },
            {
                "id": 3,
                "nis": "990099200194",
                "name": "Antonio",
                "kelas_id": 1,
                "th_ajaran_id": 2,
                "created_at": "2018-12-10 20:29:34",
                "updated_at": "2018-12-10 20:29:34",
                "detail_siswa": {
                    "link": "api/v1/siswa/3",
                    "method": "GET"
                }
            },
            {
                "id": 4,
                "nis": "990099200195",
                "name": "Tukiman",
                "kelas_id": 1,
                "th_ajaran_id": 2,
                "created_at": "2018-12-10 20:29:43",
                "updated_at": "2018-12-10 20:29:43",
                "detail_siswa": {
                    "link": "api/v1/siswa/4",
                    "method": "GET"
                }
            }
        ]
    }

**Edit Data**  
URL : `localhost:8000/api/v1/siswa/{id}`  
method : `PATCH`   
params : `status(aktif, non aktif)`  
header : `application/json` and `token`  
result : 

    {
        "status": 1,
        "msg": "Siswa updated",
        "siswa": {
            "id": 2,
            "nis": "002",
            "name": "Abdul",
            "kelas_id": 1,
            "th_ajaran_id": 1,
            "status": "aktif",
            "created_at": "2019-01-10 19:58:27",
            "updated_at": "2019-01-11 13:44:24"
        }
    }

**Get Data Kelas**
URL : `localhost:8000/api/v1/siswa/kelas`  
method : `GET`  
params : -
header : `application/json` and `token`  
result : 

    {
        "status": 1,
        "msg": "List of Kelas",
        "kelas": [
            {
                "id": 1,
                "name": "1A"
            },
            {
                "id": 2,
                "name": "2A"
            },
            {
                "id": 3,
                "name": "3A"
            },
            {
                "id": 4,
                "name": "4A"
            },
            {
                "id": 5,
                "name": "5A"
            },
            {
                "id": 6,
                "name": "6A"
            }
        ]
    }

**Get Data Tahun Ajaran**
URL : `localhost:8000/api/v1/siswa/th-ajaran`  
method : `GET`
params : -
header : `application/json` and `token`  
result : 

    {
        "status": 1,
        "msg": "List of Tahun Ajaran",
        "th_ajaran": [
            {
                "id": 1,
                "tahun": "2018"
            },
            {
                "id": 2,
                "tahun": "2019"
            }
        ]
    }

### Absen
**Create/Add Data**  
URL : `localhost:8000/api/v1/absen`  
method : `POST`  
params : `nis` and `status(pagi, siang)`  
header : `application/json` and `token`  
result : 

    {
        "status": 1,
        "msg": "Absen siswa added",
        "absen": {
            "user_id": 2,
            "siswa_id": 2,
            "time": "2019-01-14",
            "status": "pagi",
            "keterangan": "tidak makan",
            "updated_at": "2019-01-14 07:56:59",
            "created_at": "2019-01-14 07:56:59",
            "id": 23
        },
        "link": "api/v1/absen",
        "method": "GET",
        "params": "kelas, th_ajaran, bulan, tahun"
    }

**Get All Data**  
URL : `localhost:8000/api/v1/absen/{kelas}/{th_ajaran}/{bulan}/{tahun}`  
method : `GET`  
params : `kelas`, `th_ajaran`, `bulan` and `tahun`  
header : `application/json` and `token`  
result : 

    {
        "msg": "List of Absen",
        "absens": [
            {
                "id": 1,
                "time": "2018-12-10",
                "user_id": 1,
                "siswa_id": 2,
                "kelas": "4A",
                "th_ajaran": "2019",
                "created_at": "2018-12-10 20:43:03",
                "updated_at": "2018-12-10 20:43:03",
                "data_siswa": {
                    "id": 2,
                    "nis": "990099200193",
                    "name": "Mujiono"
                },
                "data_petugas": {
                    "id": 1,
                    "name": "admin"
                }
            },
            {
                "id": 2,
                "time": "2018-12-10",
                "user_id": 1,
                "siswa_id": 3,
                "kelas": "4A",
                "th_ajaran": "2019",
                "created_at": "2018-12-10 20:46:03",
                "updated_at": "2018-12-10 20:46:03",
                "data_siswa": {
                    "id": 3,
                    "nis": "990099200194",
                    "name": "Antonio"
                },
                "data_petugas": {
                    "id": 1,
                    "name": "admin"
                }
            },
            {
                "id": 3,
                "time": "2018-12-10",
                "user_id": 1,
                "siswa_id": 4,
                "kelas": "4A",
                "th_ajaran": "2019",
                "created_at": "2018-12-10 20:46:13",
                "updated_at": "2018-12-10 20:46:13",
                "data_siswa": {
                    "id": 4,
                    "nis": "990099200195",
                    "name": "Tukiman"
                },
                "data_petugas": {
                    "id": 1,
                    "name": "admin"
                }
            }
        ]
    }
