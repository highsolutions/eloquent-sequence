Eloquent Sequence
================

[![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](https://opensource.org/licenses/MIT)

Easy creation and management sequence support for Eloquent models with elastic configuration.

![Eloquent-Sequence by HighSolutions](https://raw.githubusercontent.com/highsolutions/eloquent-sequence/master/intro.jpg)

Installation
------------

This package can be installed through Composer:

```bash
composer require highsolutions/eloquent-sequence
```

Or by adding the following line to the `require` section of your Laravel webapp's `composer.json` file:

```javascript
    "require": {
        "HighSolutions/eloquent-sequence": "3.*"
    }
```

Run `composer update` to install the package.

Version Compatibility
----------------------

 Laravel  | Eloquent-Sequence
:---------|:----------
 5.1.x    | 2.1.x
 5.2.x    | 2.2.x
 5.3.x    | 2.3.x
 5.4.x    | 2.4.x
 5.5.x    | 2.5.x
 5.6.x    | 2.6.x
 5.x.x    | 3.3.x  
 6.x.x    | 3.4.x  
 7.x.x    | 3.7.x
 8.x.x    | 3.8.x  

Updating Eloquent models
------------------------

```php
use HighSolutions\EloquentSequence\Sequence;

class Section extends Model {

    use Sequence;

    public function sequence()
    {
        return [
            'group' => 'article_id',
            'fieldName' => 'seq',
        ];
    }
}
```

**Note:** as a field name do not use name of any exisiting method in that class, including `sequence`, as this will not work.

Configuration
-------------

You can specify four parameters:

 - `group` - field name or field names (then input as an array) which narrows list of objects within sequence parameter will be calculated
     - default value: ""
 - `fieldName` - field name in model to store sequence attribute
     - default value: "seq"
- `exceptions` - set this true if you want to catch exceptions during up/down methods
     - default value: false
- `orderFrom1` - set this true if your list starts from 1 not 0 / used for move method
     - default value: false
- `notUpdateOnDelete` - set this true if you don't want to update sequence attributes when delete an object
     - default value: false
- `disableTimestamps` - set this to true if you don't want to update the "updated_at" attribute when using sequence methods
     - default value: false    

Usage
-----

Set sequence attribute
----------------------

Sequence attribute will be set during model creation.

```php
$section = Section::create([
    'article_id' => 1,
    'title' => 'Lorem ipsum',
]);
```
After this metod field values of `$section` will be looking as:
```php
{
    'id' => 1,
    'article_id' => 1,
    'title' => 'Lorem ipsum',
    'seq' => 1
}
```
When we create another Section objects:
```php
Section::create([
    'article_id' => 1,
    'title' => 'Lorem ipsum Second',
]);
Section::create([
    'article_id' => 2,
    'title' => 'Lorem ipsum Third but new',
]);
```
We get list of objects with fields:
```php
[{
    'id' => 1,
    'article_id' => 1,
    'title' => 'Lorem ipsum',
    'seq' => 1
}, {
    'id' => 2,
    'article_id' => 1,
    'title' => 'Lorem ipsum Second',
    'seq' => 2
}, {
    'id' => 3,
    'article_id' => 2,
    'title' => 'Lorem ipsum Third but new',
    'seq' => 1
}]
```

Delete object and update sequence
---------------------------------

But when we delete object:
```php
Section::find(1)->delete();
```
Sequence values will be updated accordingly:
```php
[{
    'id' => 2,
    'article_id' => 1,
    'title' => 'Lorem ipsum Second',
    'seq' => 1
}, {
    'id' => 3,
    'article_id' => 2,
    'title' => 'Lorem ipsum Third but new',
    'seq' => 1
}]
```

Get objects with proper sequence
--------------------------------

To get object just add `->orderBy('seq', 'asc')` method:
```php
Section::where('article_id', 1)->orderBy('seq', 'asc')->get();
```
or with local scope `sequenced`:

```php
Section::where('article_id', 1)->sequenced()->get();
Section::where('article_id', 1)->sequenced('desc')->get();
```

Move object one position higher
-------------------------------

To move object one position higher (swap position with earlier object) you only need to:
```php
Section::find(2)->up();
```

This will set sequence attribute to one position lower and object one position lower will have sequence attribute changed to one position further.

Narrowing groups from configuration will be of course used.

Move object one position lower
------------------------------

The same you can do it to make your object next in line:
```php
Section::find(2)->down();
```

This will set Section ID=2 with sequence attribute like next Section object (based on sequence attribute) and swap their values accordingly.

Move object to the first position
---------------------------------

To move object to the first position, you only need to:
```php
Section::find(2)->moveToFirst();
```

This will set sequence attribute to the first position in the sequence and will reorder the objects between the original position and the first position accordingly.

Narrowing groups from configuration will be of course used.

Move object to the last position
--------------------------------

To move object to the last position, you only need to:
```php
Section::find(2)->moveToLast();
```

This will set sequence attribute to the last position in the sequence and will reorder the objects between the original position and the last position accordingly.

Narrowing groups from configuration will be of course used.

Move object to any position
---------------------------

You are able to move object to another position also. This is very useful when you are implementing drag&drop functionality.
```php
Section::find(2)->move(5);
```

This will set Section ID=2 with sequence attribute to 5th and rest objects' sequence attribute will be updated to match proper order.

Refresh positions in model
---------------------------

Sometimes you may need to recalculate all position for given model (e.g. because of manually manipulating dataset). You can do it easily via:
```php
Section::refreshSequence();
```

This static method will recalculate sequence attributes for every record for this model. Narrowing groups will be used as well as current sequence attribute of every record.

Check if object is first in the collection
---------------------------

You are able to check if object is first in its group.
```php
Section::find(2)->isFirst();
```

This will return true or false regarding is this a first element in the collection.

Check if object is not first in the collection
---------------------------

You are able to check if object is not first in its group.
```php
Section::find(2)->isNotFirst();
```

This will return true or false regarding is this not a first element in the collection.

Check if object is last in the collection
---------------------------

You are able to check if object is last in its group.
```php
Section::find(2)->isLast();
```

This will return true or false regarding is this a last element in the collection.

Check if object is not last in the collection
---------------------------

You are able to check if object is not last in its group.
```php
Section::find(2)->isNotLast();
```

This will return true or false regarding is this not a last element in the collection.

Testing
---------

Run the tests with:

``` bash
vendor/bin/phpunit
```

Changelog
---------

3.7.0
- Laravel 7 support

3.6.0
- Add `isFirst`, `isNotFirst`, `isLast`, `isNotLast` method

3.5.0
- Fix to 3.3.0 relase - improved preventing timepstamp during resequencing

3.4.0
- Support Laravel 6.0 version

3.3.0
- Option to prevent update `updated_at` timestamp during resequencing

3.2.0
- Fix `moveToLast` method

3.1.0
- Possiblity to change group of exisitng object [#16]

3.0.2
- Little performance improvements

3.0.0
- Support all Laravel 5.x versions

2.6.2
- Add `NotUpdateOnDelete` configuration parameter

2.6.0
- Laravel 5.6 support

2.5.0
- Laravel 5.5 support

2.4.0
- Laravel 5.4 support

2.3.0
- Laravel 5.3 support

2.2.0
- Laravel 5.2 support

2.1.0
- Laravel 5.1 support

2.0.3
- add StyleCI and CircleCI support

2.0.2
- add methods `moveToFirst` and `moveToLast`

2.0.1
- add `InvalidArgumentException` when position argument is lower than first possible sequence value for `move` method

2.0.0
- full unit tests
- add `InvalidArgumentException` when position argument is bigger than last possible sequecne value for `move` method
- method `move` with invalid position argument (with exceptions parameter disabled) sets sequence attribute to first possible number (count + 1), instead of setting value from argument / BREAKING CHANGE

1.3.1
- fix `down` method when used on object with seq > 2 (bug introduced in 1.3.0)

1.3.0
- fix `up` method when used on object with seq > 2

1.2.0
- recalculation of sequence attribute on demand

1.1.1
- config for starting index of list (for move method)

1.1.0
- move objects to any position

1.0.0
- Add methods up and down

0.9.0
- Create package
- Create trait for automatic sequence attribute handling

Credits
-------

This package is developed by [HighSolutions](https://highsolutions.org), software house from Poland in love in Laravel.
