# davidPredis

This repo contains basic concepts and exercises for Redis Key/Value Database and Laravel using Predis, a flexible and feature-complete Redis client for PHP.

Concepts like Hashes, Lists, Sorted Sets are the principal datatype structures used in the exercises. Their all are located at the `routes/web.php` file.

## Installation

  - Using Homestead: the whole redis setup is already installed
  - Using Laravel Valet: you have to install it using `homebrew`

#### Installing PHP's Predis

  - Just `composer require predis/predis`

But you can use all the dependencies by `composer install` on the root Laravel directory.

## Usage

The best way of using the Redis on Laravel is through the use of the `Illuminate\Support\Facades\Redis` Facade.

`use Illuminate\Support\Facades\Redis;
Redis::incr('visits') // this will be auto incremented
$visits = Redis::incr('visits');
return view('welcome')->with(['visits' => $visits]);`

## Commands Conventions

If the command starts with the letter L, refers to Lists, things like: LRANGE, LPUSH, LPOP are strictly used by Lists (PHP simple array datatype). This also applies for Hashes, Sets, Sorted Sets and more.

## Common DataTypes

  - Hashes: associative array in PHP. It contains some methods for assiging values (hset or hmset)
  - Sets: it's like a List, but with unique values (without any particular order)
  - Sorted Sets: Unique sets sorted by scores (could be: age, timestamp, page views, downloads) a key factor


## Credits
  - [David Lares](https://twitter.com/davidlares3)

## Licence
  - [MIT](https://opensource.org/licenses/MIT)
