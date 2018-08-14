ESputnik
========

[![Latest Stable Version](https://poser.pugx.org/ossbrownie/esputnik/v/stable)](https://packagist.org/packages/ossbrownie/esputnik)
[![Total Downloads](https://poser.pugx.org/ossbrownie/esputnik/downloads)](https://packagist.org/packages/ossbrownie/esputnik)
[![Latest Unstable Version](https://poser.pugx.org/ossbrownie/esputnik/v/unstable)](https://packagist.org/packages/ossbrownie/esputnik)
[![License](https://poser.pugx.org/ossbrownie/esputnik/license)](https://packagist.org/packages/ossbrownie/esputnik)

Marketing automation system ESputnik.

## curl
A basic CURL wrapper for PHP (see [http://php.net/curl](http://php.net/curl) for more information about the libcurl extension for PHP)

## Requirements
- **PHP** >= 5.4
- **EXT-CURL** = *

## Installation
Add a line to your "require" section in your composer configuration:

```json
{
    "require": {
        "ossbrownie/esputnik": "0.1.3"
    }
}
```

## Usage
```php
$eSputnik = new ESputnik(
    new HTTPClient(
        new CurlClient(),
        new Config([
            'login' => 'tester',
            'password' => 'passwd'
        ])
    )
);

{
    $version = $eSputnik->version();
}

{
    $contact = new Contact();

    $contact
        ->setFirstName('FName')
        ->setLastName('LName')
        ->setContactKey('contact@site.com');

    $channelList = new ChannelList();
    $channelList->add(new EmailChannel([
        'value' => 'tester@site.com'
    ]));

    $fieldList = new FieldList();
    $fieldList
        ->add(new Field([
            'id' => 12345,
            'value' => 'CustomValue1',
        ]))
        ->add(new Field([
            'id' => 12346,
            'value' => 'CustomValue2',
        ]));

    $contact
        ->setFieldList($fieldList);

    $contact
        ->setChannelList($channelList);

    $subscribe = new Subscribe();
    $subscribe
        ->setFormType('test_type')
        ->getGroups()->add(new Group([
            'name' => 'Test group'
        ]));

    $response = $eSputnik->contactSubscribe($contact, $subscribe);
}

{
    $addressbooks = $eSputnik->addressbooks();
}

{
    $groups = $eSputnik->groups();
}

{
    $params = new ParamList();
    $params
        ->add(new Parameter([
            'name' => 'EmailAddress',
            'value' => 'tester@site.com',
        ]));

    $eSputnik->event(new Event([
        'eventTypeKey' => 'test-test',
        'keyValue' => 'test-' . time(),
        'params' => $params
    ]))
}
```

## Tests
To run the test suite, you need install the dependencies via composer, then run PHPUnit.
```bash
$> composer.phar install
$> ./vendor/bin/phpunit --colors=always --bootstrap ./tests/bootstrap.php ./tests
```

## License
HttpClient is licensed under the [MIT License](https://opensource.org/licenses/MIT)

## Contact
Problems, comments, and suggestions all welcome: [oss.brownie@gmail.com](mailto:oss.brownie@gmail.com)
