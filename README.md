# Rest API plugin for CakePHP

## Installation

### Manual

Clone or copy the plugin code into your plugins directory.
```
git clone https://github.com/suiz0/cakephp-restapi.git
```

Update composer.json
```
{
    "autoload": {
        "psr-4": {
            "Kinbalam\\RestAPI\\": "plugins/Kinbalam/RestAPI/src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Kinbalam\\RestAPI\\Test\\": "plugins/Kinbalam/RestAPI/tests/"
        }
    }
}
```
Load the plugin your Application bootstrap method

```
src\Application.php
public function bootstrap()
{
    $this->addPlugin('Kinbalam/RestAPI');
}
```


## Todo

* Installation via composer