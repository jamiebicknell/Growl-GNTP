# Growl GNTP PHP Class

Small and lightweight PHP class for sending notifications to Growl via GNTP.

## Example Usage

```php
include 'growl.gntp.php';

$growl = new Growl('IP Address or Hostname', 'optional-password');
$growl->setApplication('Application Name', 'Notification Name');

// Only need to use the following method on first use or change of icon
$growl->registerApplication('http://dummyimage.com/100/');

// Basic Notification
$growl->notify('Title', 'Content goes here!');
    
// Notification with Image
$growl->notify('Title', 'Content goes here!', 'http://dummyimage.com/100/');
    
// Notification with Image and Link
$growl->notify('Title', 'Content goes here!', 'http://dummyimage.com/100/', 'http://google.com');
```

## Port Forwarding

GNTP runs on TCP port 23053, so you are required to set up port forwarding so that incoming notifications are sent to the computer you have Growl installed on.

## Information

* [Growl Website](http://growl.info/)
* [Growl Notification Transport Protocol (GNTP) Specification](http://growl.info/documentation/developer/gntp.php)
* [Port Forwarding Guides](http://portforward.com/)

##License

Growl GNTP PHP Class is licensed under the [MIT license](http://opensource.org/licenses/MIT), see [LICENSE.md](https://github.com/jamiebicknell/Growl-GNTP/blob/master/LICENSE.md) for details.