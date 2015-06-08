# API_INSTAGRAM
This API returns information about the location of a media id.
It connected to Instagram API to get the coordinates, name and location id through the media id. If it got the coordinates, the app connects to Google Place API for get additional information about de location.

## REQUEST

`GET /locations/instagram/{media_id}`

## RESPONSE

`
{
    "id": "12",
    "location": {
        "geopoint": {
            "latitude": 37.777275,
            "longitude": -122.40468777
        },
        "reference": "Harriet St",
        "address": "San Francisco",
        "id": 3,
        "name": "Chevron"
    }
}
`

## HOW TO INSTALL
Requeriments:

- Composer (updated)

- CURL PHP

### Steps
1) Clone the repository: $ git clone https://github.com/nicorivas07/API_INSTAGRAM.git

2) $ cd API_INSTAGRAM

3) $ sudo composer install (It may take a few minutes)

4) $ phpunit (run test)

5) $ php artisan route:list (see the endpoint)

4) $ php artisan serve (turn on a test enviroment in http://localhost:8000)

5) Try GET http://localhost:8000/locations/instagram/{media_id}

6) Enjoy!