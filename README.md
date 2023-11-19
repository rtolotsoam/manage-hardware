# manage-hardware
Create an API resource
Step 1:Go to the master branch.

Step 2:Run `composer install`.

Step 3:Create a user 'tolotsoa' with the password 'testtolotsoa' in the MySQL database.

Step 4:Execute the command `php bin/console doctrine:database:create` to create the 'hardware' database.

Step 5:Execute the command `php bin/console doctrine:schema:create` to create the 'equipment' table.

Step 6:Launch the Symfony server with the command `symfony serve`.

Step 7:Visit the URL `127.0.0.1:8000/api`.

Step 8:Retrieve, insert, update, and delete equipment via the API resource.

Step 9: For unit testing, create the 'hardware_test' database by running the command `php bin/console doctrine:database:create --env=test`.

Step 10: Execute the command `php bin/console doctrine:schema:create --env=test` to create the 'equipment' table.

Step 11:Launch unit tests with the command `./vendor/bin/phpunit`. For the first run, there might be 1 error because the test deletes equipment-1, but before launching the unit test, it is okay.
