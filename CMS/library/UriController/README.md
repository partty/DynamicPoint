# UriCOntroller 
UriController provides uri devision. It does not need setting up. 
The purpose to this it to be available anywhere at any time. 


## Logical fragments

When you need a logical part of the uri, just do:
<	UriController::getUrl(1);>
if you need the second logical fragment. 
If the uri looks like this "http://www.host.com/dir1/logical/fragment/here", 
and dir1 is really a directory where the systems index.php is, 
then the above example will give you "fragment" and if you do:
<	UriController::getUrl(3);> 
you will get boolean false!

## Host
You can easily get the host by doing:
<	UriController::getHost();> 


## Protocol 
Use this to get the protocol:
<	UriController::getProtocol();> 

## The Base 
The base is the physical or web part of the url.
for this example "http://www.host.com/dir1/logical/fragment/here" is the url,
and the index.php of the system is in the "http://www.host.com/dir1" directory.
<	UriController::getBase();> 
This will give you - /www.host.com/dir1/".

## The Get query
You can use this UriController to access Get input. 
<	UriController::getQuery('varName');> 