# Changelog

All notable changes to `webhook` will be documented in this file

## 2.4.0 - 2023-01-22

* Added Laravel 10 support
* Added PHP 8.2 support

## 2.3.0 - 2022-02-15

* Added Laravel 9 support

## 2.2.0 - 2020-11-23

* Added PHP 8 support

## 2.1.0 - 2020-09-10

* Added Laravel 8 support
* Dropped Laravel 5.5 support
* Added PHP 7.4 support
* Dropped PHP 7.2 support
* Switched from Travis CI to Github Actions

## 2.0.0 - 2020-03-09

* Added Laravel 7 support
* Added PHP 7.2 support
* Dropped PHP 7.0 and 7.1 support
* Updated channel name to webhook from Webhook [BREAKING CHANGE]
  * This shouldn't actually break anything, assuming you are using the routing provided by laravel, but out of an abundance of caution we are tagging a new major version 
  * We suggest you update any instances of Webhook to webhook in routing statements

## 1.4.0 - 2020-01-07

* Return full response from the request rather than throwing an exception
* Return response on successful webhook
* Added response to CouldNotSendNotification exception
* Updated test PHPDocs and assert exception object
* Fixed broken tests

## 1.3.0 - 2019-09-16

* Added Laravel 6 support
* Dropped Laravel 5.1, 5.2, 5.3 and 5.4 support
* Added PHP 7.0+ support
* Dropped PHP 5.6 support

## 1.2.0 - 2018-05-07

* Added Laravel 5.6 support

## 1.1.0 - 2017-09-25

* Added Laravel 5.5 support

## 1.0.2 - 2017-02-02

* Added Laravel 5.4 support

## 1.0.1 - 2016-10-30

* Fixed issue with other status codes than 200

## 1.0.0 - 2016-08-23

* initial release
