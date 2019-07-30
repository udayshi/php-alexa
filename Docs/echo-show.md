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


#### Available Methods on \USAlexa\Alexa()->template

    - setType($type,$title=NULL,$token=NULL) 
        This method is used to set the template.Title and Token are optional.
    
    - setToken($token)
        This method is used to set the token.
    
    - setBackButton($show=true)
        This method is used to enable or disable background button.

    - setBackgroundImage(Image $img)
        This method is used to set the background Image.
        
    - setImage(Image $img)
        This method is used to set the image.
        
    -  setText(TextContent $txt)
        This method is used to set the text     
        
    - setListItem($token=NUll,TextContent $txt=null,Image $img=null)
        This method is used to set the listitem with image and text.
        
     - setListText($token=NUll,TextContent $txt=null)
        This method is used to set listitem with text only.
        
     - setListTexts($objTxts=[])
        This method is used to set multiple items of text.
        
     - setListImage($token=NUll,Image $img=null)
        This method is used to set image only.
        
     - setListImages($objImg=[])  
        This method is used to set multiple items of image.      
        
[Back](https://github.com/udayshi/php-alexa/)                             