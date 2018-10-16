Requirements for the Extension Builder:
Composer
Laravel

This projects is used in building basic TYPO3 extensions.
The start up of a new extension is tedious and this program helps automating this.

Note: Because Windows doesn't like faking paths, this application doesn't work outside the project you want to build an extension for.

Another note: this project is made for an internship I did a while ago

To start a new extension:
php artisan build:extension ExampleName

After that the programm asks you for some basic configurations:

Do you want a controller, if yes, specify names:
JohnController, DoeController

Do you want a model, if yes, specify names:
John, Doe

Congratulations! You've built an extension!

If you run the Controller/Model builder separate from the main command you have the ability to choose an existing extension within the
project.

The program will show you all available extension within the project.

php artisan build:model ModelName
php artisan build:controller ControllerName
