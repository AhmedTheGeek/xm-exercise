# XM.com Exercise

### Requirements

1. php 7.2+.
2. Docker (for easier setup)

### Installation

1. Clone the project.
2. Run `make up`.

### Dockerized Version

After running the `make up` command you'll be able to access the frontend on `http://localhost:8080`.

### Manual Start

To start the backend:

1. `cd backend`
2. `composer install`
3. `php artisan serve`

To start the frontend:

1. `cd frontend`
2. `npm install`
3. `npm run serve`

### Runnning the unit tests

if you're running on docker just run `docker-compose exec backend php artisan test`
otherwise, from the root directory run `make test`

### Future Todo list

1. Internationalization
2. Use a mobile friendly chart.
