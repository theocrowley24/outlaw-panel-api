# Outlaw Panel by Theo Crowley
An administrative database tool designed for a custom Arma 3 mission. Includes an advanced permission and user group system as well as administrative functionality to safely modify a MySQL database. This is the frontend repository.

Written in React with TypeScript and SASS. Backend API written in PHP Slim.

# Slim Framework 4 Application

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd [my-app-name]
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.
