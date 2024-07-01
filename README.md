## Requirements
To run this application, you need:
-   Docker

## Installation
1.  Clone this repository to your local machine using the command below:
	```
	git clone git@github.com:MarullahRuhyat/gym.git
	```
2.  Navigate to the project root directory:
	```
	cd gym
	```
4.  Create a copy of the `.env.example` file and name it `.env`:
	```
	cp .env.example .env
	```

## DEV
```
docker compose up
```
## PROD
```
docker compose -f compose.prod.yaml up
```
