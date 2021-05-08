<?php
namespace Kinbalam\RestAPI\Model\Domain;

use Cake\Core\Configure;

class Configuration {
    public static function IsAuthEnabled() {
        $userDefined = Configure::read('RestAPI.options.disableAuth');
        return isset($userDefined) ? false :  true;
    }
}
