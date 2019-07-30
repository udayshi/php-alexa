# US Alexa
This is PHP Helper library  for Alexa and  Echo Show to generate response with few lines of code..

## Install via composer
Require the package with composer:
```
composer require udayshi/usalexa
```

## Usage
#### Quick Implement
Just to send PlainText Quick response you can create function with any name and pass \USAlexa\Alexa $obj as parameter on created function.

Once you create the function you have to map and register the method.

Finally you can run it.

```php
    require('./vendor/autoload.php');
    $obj=new \USAlexa\Alexa();
    #Define function to handle request
    function launchIntentHandlerPhp(\USAlexa\Alexa $obj){
        
        $obj->response->setResponse('Hello From PHP USAlexa.');
    }
    
    #Register intent and run    
    $obj->registerIntentHandler('LaunchRequest','launchIntentHandlerPhp')
        ->run();
    
```
[more...](https://github.com/udayshi/usalexa/blob/master/Docs/quick.md)



#### Adding Effects
You can add the following effects:
- Whisper
- Break
- Emphasis 
    - Strong 
    - Moderate 
    - Reduced
- SayAs    
  

```php
    require('./vendor/autoload.php');
    $obj=new \USAlexa\Alexa();
    #Define function to handle request
    function launchIntentHandlerPhp(\USAlexa\Alexa $obj){
        
        $obj->response->setResponse('Hello From PHP USAlexa.')
        #Auto detect and send ssml
        $obj->response->setWhisper('Hello')
                               ->setBreak(2)
                               ->setEmphasisStrong('Strong')
                               ->setEmphasisModerate('Moderate')
                               ->setEmphasisReduced('Reduced')
                               ->setSayAs('TEST');
                       ;
    }
    
    #Register intent and run    
    $obj->registerIntentHandler('LaunchRequest','launchIntentHandlerPhp')
        ->run();
    
```


#### Echo Show Response
As long as you have minimum parameter for the echo show it will send proper response to the targeted devices.



```php
    require('./vendor/autoload.php');
    $obj=new \USAlexa\Alexa();
    #Define function to handle request
    function launchIntentHandlerPhp(\USAlexa\Alexa $obj){
        
        $obj->response->setResponse('Hello From PHP USAlexa for echo show.')
        #Autodetect       
        $img=$obj->getImageObject('[[IMG_URL]]');
        $obj->template->setBackgroundImage($img);
        $img=$obj->getImageObject('[[IMG_URL]]');
        $obj->template->setImage($img);

                               
                       ;
    }
    
    #Register intent and run    
    $obj->registerIntentHandler('LaunchRequest','launchIntentHandlerPhp')
        ->run();
    
```
[more...](https://github.com/udayshi/usalexa/blob/master/Docs/echo-show.md)