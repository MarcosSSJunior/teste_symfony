# teste_symfony
<p>Test development using symfony 5</p>

# Run Project
<p>First of all you need to have PHP 7.4 or higher and a mysql container or service
Then you have to install the Composer to install de dependencies and you are ready to run.</p>

<p>to install the dependencies just run in your console/cmd</p>
$ composer install

<p>configure the env DATABASE_URL file in .env with your database url following the example</p>
DATABASE_URL={driver}://{user}:{password}@{host}:{port}/{database}

<p>after that run</p>
$ php -S localhost:{port} -t public
<p>and <b>BOOM</b>, you are running</p>

# Tests
<p>To run the unit tests just need run in your console/cmd</p>
$ php vendor/bin/phpunit  

# APIs
<p>You can import the file insomnia_teste_symfony.json located in the root folder directly in your Insomnia</p>
