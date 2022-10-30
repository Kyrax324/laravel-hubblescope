# Laravel Hubblescope

## Pre-requisite

Install & Setup the [Laravel Telescope Package](https://github.com/laravel/telescope).

## Introduction

This package is an filter tools aims to assist developers to locate entities from the [Laravel Telescope Package](https://github.com/laravel/telescope).

Features:
- multiple tags search
- json extract search (search through `content` field)
- result's json reader
- dump query (for database querying)

<p align="center"><img src="./art/preview.png" alt="Laravel Hubblescope Preview"></p>

## Installation

```sh
composer require kyrax324/laravel-hubblescope
```

Publish the default interaction UI:

```sh
php artisan hubblescope:publish
```

#### Customization

Currently the supported types of the default interaction UI are limited, but you may modify the `config('hubblescope.modes')` in the `config/hubblescope.php`