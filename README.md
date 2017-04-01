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

## Unit Test

*TODO*
