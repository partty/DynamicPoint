# Convention for the DPFW 
This file explains the convention around which the **D**ynamic **P**oint **F**rame**W**ork is build


 - All main directories in the library represent a class or group of classes. There is always a class with the same name as any dir in the library, this classes are called main packages. 

 - All classes are written by themselves in single files. Every class must have its own file.

 - File names must be the same as the classes names, with the **.php** extension added (the class "mysql" must be written in the file named "mysql.php").

 - The code is Tabulated with tab characters. All operators are surrounded with space characters. 

 - The name of the classes start with a capital letter, then written with lower case letters. If the name of the class contains more than one word, every word is started with capital letter and written one after the other with no separators (ex. ThisIsAClassName).

 - Any package has a root Class, which is normally a factory or an abstract Class. If the package contains more classes they must be named as subclasses. 
 
 - The subclasses are named with the name of the main class followed by an underscore (_) Then the name of the Class itself. (ex. **PackageName_SubClassName**) 
 However to avoid collisions sometimes we add "**Dp**" prefix to the package name or the class itself. 
 
 - Some classes can have different variants, as db drivers. This is done by choosing a base name then an individual name and separating them with underscore (_) (ex. **DataBase_Driver_MySql** and **DataBase_Driver_PostgrSql**)
 
 - Some packages will extend the main package class (as extending types), but for packages that use Factories it may be best to create abstract classes wit "**_Abstract**" suffix and a factory with "**_Factory**" suffix (ex. **DataBase_Abstract** and **DataBase_Factory**). 
 You can use "**_Type**" suffix if you have more than one types in a package and "**_Interface**" for interfaces

 - Some packages can have additional resources, this resources must be contained in sub dir. The name of the dir does not matter however, it is a good idea to name it after the resource type, and have as much sub dirs as you need. (ex. **PackageName/images**, **PackageName/Templates**) 


## Further reading

See the **"Example" package** where this convention is explained with comment's to the code. 
Note: The only required element in a package is the file with the same name(.php) as the package, containing a class with that name!
**All files must contain the copyright notice, however the license will apply to all public files inside whether or not the notice is added!**