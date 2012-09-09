# Example package, part of DPFW
This package is written to demonstrate the conventions that must be followed during development. 
It shows the maximum of the use case of the package. 

This implementation is ignored in the loading process. This package is never used. 

Include files are used only for static loading of classes, or to speed-up loading process in large chains of related classes.
Normally don't use any include or autoload! If it doesen't work, you probably doing something wrong. 

The Root class is required by the framework, if it is not used in the package - it still needs to be there (write an empty class)


# In the README the purpose of the package is explained, and given some use cases and examples. 

Here is an example how to start this example package.

<	$one=Example_MyType_Factory::create_typeOne();
	echo $one->getType();>