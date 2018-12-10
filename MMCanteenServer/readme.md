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
header : `application/json`  
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

### User/Petugas
**Create/Add Data**  
URL : `localhost:8000/api/v1/petugas`  
method : `POST`  
params : `name`, `password` and `role`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Petugas created",
        "user": {
            "name": "Petugas4",
            "role": "petugas",
            "updated_at": "2018-12-10 20:18:27",
            "created_at": "2018-12-10 20:18:27",
            "id": 3,
            "signin": {
                "link": "api/v1/signin",
                "method": "POST",
                "params": "name, password"
            }
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdjEvcGV0dWdhcyIsImlhdCI6MTU0NDQ0NzkwNywiZXhwIjoxNTQ0NDUxNTA3LCJuYmYiOjE1NDQ0NDc5MDcsImp0aSI6IjdoUnRJSERWZXA0aXZyMWIifQ.Ci6yXwwL7_LNzacRR8Ho5NV4uN9XejcvJSxT7a2ns2k"
    }

**Get All Data**  
URL : `localhost:8000/api/v1/petugas`  
method : `GET`  
params : none  
header : `application/json` and `token`  
result : 

    {
        "msg": "List of Petugas",
        "users": [
            {
                "id": 1,
                "name": "admin",
                "role": "admin",
                "created_at": "2018-11-21 03:55:27",
                "updated_at": "2018-11-21 03:55:27",
                "detail_user": {
                    "link": "api/v1/petugas/1",
                    "method": "GET"
                }
            },
            {
                "id": 2,
                "name": "petugas1",
                "role": "petugas",
                "created_at": "2018-11-21 03:58:33",
                "updated_at": "2018-11-21 03:58:33",
                "detail_user": {
                    "link": "api/v1/petugas/2",
                    "method": "GET"
                }
            }
        ]
    }

**View/Detail Data**  
URL : `localhost:8000/api/v1/petugas/{id}`  
method : `GET`  
params : `id`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Detail petugas",
        "user": {
            "id": 1,
            "name": "admin",
            "role": "admin",
            "created_at": "2018-11-21 03:55:27",
            "updated_at": "2018-11-21 03:55:27",
            "update": {
                "link": "api/v1/petugas/1",
                "method": "PATCH"
            }
        }
    }

**Edit Data**  
URL : `localhost:8000/api/v1/petugas/{id}`  
method : `PUT` or `PATCH`   
params : `id`,`name`,`role` and `password`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Petugas updated",
        "user": {
            "id": 2,
            "name": "Petugas3",
            "role": "petugas",
            "created_at": "2018-11-21 03:58:33",
            "updated_at": "2018-12-10 20:15:44"
        }
    }

**Delete Data**  
URL : `localhost:8000/api/v1/petugas/{id}`  
method : `DELETE`  
params : `id`  
result : 

    {
        "msg": "Petugas deleted",
        "create": {
            "link": "api/v1/petugas",
            "method": "POST",
            "params": "name, password, role"
        }
    }
    
### Tahun Ajaran
**Get All Data**  
URL : `localhost:8000/api/v1/th-ajaran`  
method : `POST`  
params : `tahun`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Tahun Ajaran created",
        "th_ajaran": {
            "tahun": "2021",
            "updated_at": "2018-12-10 20:21:39",
            "created_at": "2018-12-10 20:21:39",
            "id": 4
        },
        "link": "api/v1/th-ajaran",
        "method": "GET"
    }

**Get All Data**  
URL : `localhost:8000/api/v1/th-ajaran`  
method : `GET`  
params : none  
header : `application/json` and `token`  
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
URL : `localhost:8000/api/v1/th-ajaran/{id}`  
method : `GET`  
params : `id`  
header : `application/json` and `token`  
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
URL : `localhost:8000/api/v1/th-ajaran/{id}`  
method : `PUT` or `PATCH`  
params : `id`, `tahun`  
header : `application/json` and `token`  
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
URL : `localhost:8000/api/v1/th-ajaran/{id}`  
method : `DELETE`  
params : `id`  
header : `application/json` and `token`  
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
**Create/Add Data**  
URL : `localhost:8000/api/v1/kelas`  
method : `POST`  
params : `name`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Kelas created",
        "kelas": {
            "name": "5B",
            "updated_at": "2018-12-10 20:19:34",
            "created_at": "2018-12-10 20:19:34",
            "id": 3
        },
        "link": "api/v1/kelas",
        "method": "GET"
    }

**Get All Data**  
URL : `localhost:8000/api/v1/kelas`  
method : `GET`  
params : none  
header : `application/json` and `token`  
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

**View/Detail Data**  
URL : `localhost:8000/api/v1/kelas/{id}`  
method : `GET`  
params : `id`  
header : `application/json` and `token`  
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

**Edit Data**  
URL : `localhost:8000/api/v1/kelas/{id}`  
method : `PUT` or `PATCH`   
params : `id` and `name`  
header : `application/json` and `token`  
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

**Delete Data**  
URL : `localhost:8000/api/v1/kelas/{id}`  
method : `DELETE`  
params : `id`  
result : 

    {
        "msg": "Kelas deleted",
        "create": {
            "link": "api/v1/kelas",
            "method": "POST",
            "params": "name"
        }
    }

### Siswa
**Create/Add Data**  
URL : `localhost:8000/api/v1/siswa`  
method : `POST`  
params : `nis`, `name`, `kelas_id` and `th_ajaran_id`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Siswa created",
        "siswa": {
            "nis": "990099200195",
            "name": "Tukiman",
            "kelas_id": "1",
            "th_ajaran_id": "2",
            "updated_at": "2018-12-10 20:29:43",
            "created_at": "2018-12-10 20:29:43",
            "id": 4
        },
        "link": "api/v1/siswa",
        "method": "GET"
    }

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

**View/Detail Data**  
URL : `localhost:8000/api/v1/siswa/{id}`  
method : `GET`  
params : `id`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Detail siswa",
        "siswa": {
            "id": 1,
            "nis": "990099200192",
            "name": "Joko Suharyono",
            "kelas_id": 1,
            "th_ajaran_id": 2,
            "created_at": "2018-12-10 20:29:09",
            "updated_at": "2018-12-10 20:29:09",
            "update": {
                "link": "api/v1/siswa/1",
                "method": "PATCH"
            }
        }
    }

**Edit Data**  
URL : `localhost:8000/api/v1/siswa/{id}`  
method : `PUT` or `PATCH`   
params : `id`, `nis`, `name`, `kelas_id` and `th_ajaran_id`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Siswa updated",
        "siswa": {
            "id": 1,
            "nis": "990099200195",
            "name": "Suparjo",
            "kelas_id": "1",
            "th_ajaran_id": "2",
            "created_at": "2018-12-10 20:29:09",
            "updated_at": "2018-12-10 20:32:41"
        }
    }

**Delete Data**  
URL : `localhost:8000/api/v1/siswa/{id}`  
method : `DELETE`  
params : `id`  
result : 

    {
        "msg": "Siswa deleted",
        "create": {
            "link": "api/v1/siswa",
            "method": "POST",
            "params": "nis, name, kelas_id, th_ajaran_id"
        }
    }

### Absen
**Create/Add Data**  
URL : `localhost:8000/api/v1/absen`  
method : `POST`  
params : `nis`  
header : `application/json` and `token`  
result : 

    {
        "msg": "Absen siswa added",
        "absen": {
            "user_id": 1,
            "siswa_id": 2,
            "kelas": "4A",
            "th_ajaran": "2019",
            "time": "2018-12-10 20:43:03",
            "updated_at": "2018-12-10 20:43:03",
            "created_at": "2018-12-10 20:43:03",
            "id": 1
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
