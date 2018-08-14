# Change Log

## dev-master

## 0.1.3 (2018-08-14)
Bugfixes:
- Fixed a bug in bringing the Subscribe model to a array.

Features:
- Added unitTest for class Brownie\ESputnik\Model\SubscribeTest.

## 0.1.2 (2018-05-16)
- Change of license for MIT

## 0.1.1 (2017-08-16)
Features:
- Add Badge Poser

## 0.1.0 (2017-07-24)
Changed:
- Redesigned client creation for HTTPClient.
- Changed the ESputnik class constructor.
- Exceptions have been renamed: InvalidCode to InvalidCodeException, Json to JsonException, UndefinedMethod to UndefinedMethodException, Validate to ValidateException.

Features:
- Added unitTest for class Brownie\ESputnik\ESputnikTest.
- Added unitTest for class Brownie\ESputnik\HTTPClientTest.
- Added unitTest for class Brownie\ESputnik\Model\Address.
- Added API method "contacts".

## 0.0.3 ( 2017-06-06 )
Features:
- Added dependence on the extension of php-curl in the composer.json.
- The require-dev partition is added to the composer.json with phpunit/phpunit 4.8.35.
- Added API method "event".
- Code refactoring.
- Added unitTest for class Brownie\ESputnik\Config.

## 0.0.2 ( 2017-06-05 )
Bugfixes:
- Fixed auto loading of classes and annotation.

## 0.0.1 ( 2017-06-04 )
Features:
- Initinal commit.
- Added API method "version".
- Added API method "contact/subscribe".
- Added API method "addressbooks".
- Added API method "groups".
