# Changelog


## 1.1.0
- Bumped Support for Laravel 8
- Added ability to add any further options to `SNSClient` config (i.e. to override `endpoint`)
- *Breaking Change*: Inherited the name to the `Subject` field of an SNS Message. This either comes from `broadcastAs()` or the Class name ([see here](https://laravel.com/docs/8.x/broadcasting#broadcast-name) for more info). The last change is potentially breaking if one did not want the subject set.

## 1.0.1
* Allow using IAM Role

## 1.0.0
* Everything, initial release
