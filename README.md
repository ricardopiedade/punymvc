# PunyMVC

PunyMVC is a work-in-progress minimalistic ultra-light MVC framework for PHP applications.

It is designed to be simple and straight-to-the-point, but at the same time modular, well organized and easy to extend or change.

Although it is already usable, it's still in a very early stage so it may (and most probably will) have some bugs, and some features may not work correctly in all kinds of situations. 

### Directory Structure
This is a default directory structure for a PunyMVC application.
"public" is the web server document root, can have any name and be anywhere, as long as all requests go through his index.php file.
"PunyMVC" is the core directory.
"application" is the default application root

* application/  
    * controllers/ 
    * models/ 
    * libraries/ 
    * views/ 
* public/       
    * index.php _(all requests must go through here)_
* PunyMVC/      
    * Request.php
    * Response.php
    * PunyMVC.php
    * Router.php
    * Controller.php
    * Library.php
    * Model.php
    * Database.php
    * Loader.php
    * View.php
    * Config.php



### Core Classes:

* **Request**
The _Request_ class represents a HTTP request, and has method to access request information like request headers, request method, POST or GET params, raw request body, etc.
* **Response**
The _Response_ class represents a HTTP response, and handles all the output like HTTP headers, Status Codes, raw output or MVC Views.
* **PunyMVC**
This is the framework main class. To start a _PunyMVC_ application you must create a _PunyMVC_ instance. It has methods to set routes, configure database access, add configuration settings, etc. In the end, call the _PunyMVC->run()_ method and let it handle your requests. 
* **Router**
The _Router_ class takes a Request and tries to match one of the specified routes with the Request Uri to find an appropriate controller to process the request.
* **Controller**
The _Controller_ class is the heart of your application. The _PunyMVC_ object, after locating a suitable controller for the request, will instance it and call the defined method, passing along the _Request_ Object and a new, (almost) empty _Response_ Object. All developer created controllers must extend this _Controller_ class. This class extends the _Loader_ class, so that developers can access Models, Libraries and Configuration items within their controllers.
* **Library**
The _Library_ class is a parent for developer created custom classes, or libraries. It extends the _Loader_ class, so developers can access other Libraries, Models or Configuration items from whitin their own libraries. Developer libraries must extend this Library class.
* **Model**
The _Model_ class is a parent class for developer created Models. It also extends the _Loader_ class, granting access to other Models, Libraries and Configuration Items, and also provides access to the _Database_ class.
* **Database**
The _Database_ class returns singleton instances of database connections. Currently it returns a singleton _PDO_ object. Developers must first supply connection configuration parameters to access this class. Multiple database singletons are supported via named instances.
* **Loader**
The _Loader_ class is a parent class for _Controller_, _Model_ and _Library_ classes. It provided a way to load singleton instances of Libraries and Models, as well as access to Configuration Items.
* **View**
The _View_ class takes an template file and an array of data and parses the template using the data array as variables. The _View_ instance belongs to the Response object.
* **Config**
The _Config_ class provides a way to set or get configuration key->value pairs thourhgout the application.

## Application Flow

When the _PunyMVC->run()_ method is called, the following workflow is executed:

1. The _PunyMVC_ object instances a _Router_ object and a _Request_ object and calls the _Router->getRouteAction()_ method, passing along the _Request_ object.
2. The _Router_ inspects the _Request_ to find a matching route, and returns an generic object back to the _PunyMVC_ object, containing the path, class and method of the appropriate _Controller_.
3. The _PunyMVC_ class instances the controller and calls its method, passing along the _Request_ object and a new _Response_ Object.
4. From here on is it up to the developer's code... The controller's parent _Controller_ base class extends the _Loader_ class, providing him with easy means to access models, libraries, and configuration items. As the _Request_ and _Response_ objects are required parameters of the _Controller_ base class, the developer can also get _Request_ information, and use the _Response_ object to manipulate output such as sending response headers, setting raw output or executing views.
5. When the controller code is finished, either the developer can call the _Response->send()_ method, or it will be called automatically via the _Response_ object destructor. The _Response_ object will build the response by setting the HTTP status code, outputting the response headers and finally the response body.
6. That's it!


