## Requirements
To run this application, you need:
-   PHP 8.2 or newer
-   **[Composer](https://getcomposer.org/)**

## Installation
1.  Clone this repository to your local machine using the command below:
	```
	git clone git@github.com:MarullahRuhyat/gym.git
	```
2.  Navigate to the project root directory:
	```
	cd gym
	```
3.  Install dependencies:
	```
	composer install
	```
4.  Create a copy of the `.env.example` file and name it `.env`:
	```
	cp .env.example .env
	```
5.  Generate a new application key:
	```
	php artisan key:generate
	```
6.  Configure your database.
    ```
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

7.  Run database migrations and seeders:
	```
	php artisan migrate 
	```
8. Serve the application:
    ```
    php artisan serve
    ```

## Run docker container
```
docker compose up
```
