### Quick 
Just to send PlainText Quick response you can create function with any name and pass 
\USAlexa\Alexa $obj as parameter on created function.

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
You can also register object by default it expect run method.

```php
        require('./vendor/autoload.php');
        $obj=new \USAlexa\Alexa();
        class Launch{
            private $obj;
            function __construct(\USAlexa\Alexa $obj)
            {
                $this->obj=$obj;
            }
        
            function run(){
                $obj=$this->obj;
                $obj->response->setResponse('I am default object method.');
        
          
            }
            
            function process(){
              $obj->response->setResponse('I am modified run method.');
            }
        }
        $obj=new Launch($obj);
        $obj->registerIntentHandlerObject('LaunchRequest',$obj)
            ->run();
```
     
If you want to  modify name of run method to be called then you can do the following.

```php
        $obj=new Launch($obj);
        $obj->registerIntentHandlerObject('LaunchRequest',$obj,'process')
            ->run();
```    

[Back](https://github.com/udayshi/php-alexa/)