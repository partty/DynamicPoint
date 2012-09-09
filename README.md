# DynamicPoint
## Objective CMS and framework done wrighte

The aim of this project is to provide an intuitive and roubast CMS platfor for developing web apps and services. 

### Key features are:

 - Entiarly Object oriented with modern programing
 - PHP based, Using all the new HTM5 and CSS3 and jQuery
 - Clean and simple directory structure.
 - Modular MVC design 99% compliant with the MVC design pattern 
 - Easy and intuitiv managment and administration. 
 - Modules and plugins written quick and deployed easy.
 - XML based templates and Views that can be nested in one onather
 - Models with clever data integration and manipulation
 - Different types of controllers to do the different types of jobs there are.
 - Piping of the requests, alowing the minimal amout of code to be loaded at any request.

### Enviarment
The project is amed to create an enviermant in wich developers can write new modules and plugins easilly and fast. Aways there are problems with getting information from the request and this is the reason for many CMSs to still use GET parameters and globall variables. There are however ways to protect the data and still use complicated dashed URI. 
One way is to use static classes that get autoloaded at first use, so the developer don't cear about them, they just work. So in our environment design we impelented this exact feature. With the **dpURI** static methods you can get the uri fragments, no mather where you calling it from. There is a **dpConfig** class too, so you can find any configuration you like. There are secure configurations that you cant recal, like database passwords and such, however.

For more info look at the wiki

### Database
Database is accessed usig abstractions implemented in Models. Every model is kind of a diferent use case of table or tables. There can be sub models for getting subset of data. Working with data is often not very direct. You get the data and then pass it to a view so it can be shown. in this operation you don't realy manage the data, just call 2 methosds of the respective instances. There are casese you only need to make one call and the data is feched automatically.

For more info look at the wiki

### Graphics
Using templating and theming there are infinit posabilities for showing content. There are some build in visual elements for convinience. You can overwrite them when you like but it's recomended not to. 
There is a way to make a theme for build-in elements that you can use in multiple projects.

For more info look at the wiki

### Modularity
The system is a MVC. It can contain an MVCs of it's own as Moduls. The moduls can have Plugins that are MVCs too. This design alows to hav consistant MVC design trought the application and never to sacrifice the separation of the logic, data and visualisation. 

For more info look at the wiki

### Piping requests
Many developers write diferent files to take different pages in an applications and it's OK but this approach doesn't allow for verry rich apps, and is hard to maintain. There is significant code copyng or big include parts. 
For our system we discovered a way to do more with less and to still have control over what's happening. We call it piping of the request. This is a way to forword the request from one object to the next and every object in the chain desides what to do with it and where to forword it to or hou to servic it.
The idea is simple, You have a common application interface (this is where all the browser request are going) This interface forwords any request to a modul (CMS module for example) If the request is for simple enough and is in the modul it should be served the modul controlled calls the method to serve it. (like calling the view and passing it the model).
By using this piping we are able to apply independent logic all the way and still have object oriented design.
It's posible to add a module with super specialised purpous and it'll work nice, becaouse the system don't need to know what it does or to anticipate any returned value. Any modul can stop this propagation and force the rendering of the page. The system will send the page if only the chain return to it (it's only like a failsafe, but the moduls are responsible for returning their pages, as they can use diferent templates all together, or return different kind of content.)
Ajax requests are piped trought the most quick and direct path, so you can have logical URIs for the Ajax requests too.


## The CMS 
The CMS is intuitive and secure. THe content is edited by drag and drop, and on the page itself. This helps administrators to edit content fast and on the spot. It saves time and attention. The CMS is written to be scalable and roubast, so it can be used for any purous easily. From a small presentation to a big webstore or manifacturar websystem complete with blog, and forum functions build-in. It's question of Moduls and plugins.


## The Framework
The frame work can be used appart from the CMS. It's his own independant entity. 

For more information take a look at the WiKi and LICENSE


