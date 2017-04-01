# Number to Words PHP Class - Indian Version

This class converts numbers to Indian-English Words. Works for all kinds of
numbers including floats. A few examples.

## Examples

* `10,000,00` - **Ten Lakh**
* `3,478` - **Three Thousand Four Hundred And Seventy Eight**
* `1,234,567,890` - **One Hundred And Twenty Three Crore Forty Five Lakh Sixty Seven Thousand Eight Hundred And Ninty**
* `5,024.78` - **Five Thousand Twenty Four And 78/100**

## Usage

**Clone this repository using git**

```bash
git clone git@github.com:swashata/php-number-to-word-india.git
```

**Include the class**

```php
<?php
require_once 'ntwIndia/class-ntw-india.php';
```

**Create an instance**

```php
<?php
$ntw = new new \ntwIndia\NTW_India();
```

**Convert values**

```php
<?php
echo $ntw->num_to_word( 3104007200 );
// Will print Three Hundred Ten Crore Forty Lakh Seven Thousand Two Hundred
```

If your number is always less than 100, then use `num_to_wd_small` method to
reduce memory usage.

```php
<?php
echo $ntw->num_to_wd_small( 99 );
// Will print Ninty Nine
```

## Methods

Two methods are available

### `num_to_word`

Converts any number to word including decimal values. Decimals are converted as
`... And 986/1000`. You will mostly need to call this method.

#### Parameters

* `$number`: *integer|float* The number whose word value would be generated.

#### Return

Returns `string` The word value of the number. All of the words have uppercased
first letter.

## Unit Test

Unit test is available through composer.

```bash
$ cd /path/to/php-number-to-word-india/
$ composer update
$ vendor/bin/phpunit
```

It will output something like this.

![Test Case](test-case.png)

You are more than welcome to add more test cases and send me a pull request.

Kindly follow [Contribution Guide](CONTRIBUTING.md)

## License

PHP Number to Word in Indian Style is licensed under GPLv3

    Copyright (C) 2017  Swashata Ghosh

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
