<?php
namespace NTWIndia;

/**
 * Number to Words in Indian Version
 *
 * PHP Library
 *
 * @author Swashata Ghosh <swashata@iptms.co>
 * @license GPL-v3.0
 */
class NTWIndia {
	/**
	 * Hundred Word
	 *
	 * @var        string
	 */
	public $hundred = 'Hundred';
	/**
	 * Thousand Word
	 *
	 * @var        string
	 */
	public $thousand = 'Thousand';
	/**
	 * Lakh Word
	 *
	 * @var        string
	 */
	public $lakh = 'Lakh';
	/**
	 * Crore Word
	 *
	 * @var        string
	 */
	public $crore = 'Crore';
	/**
	 * And word
	 *
	 * @var string
	 */
	public $and = 'And';
	/**
	 * Number to Words
	 *
	 * These are the presets we will need
	 *
	 * Rest will be calculated automatically
	 *
	 * @var        array
	 */
	public $numToWord = array(
		'0'  => 'Zero',
		'1'  => 'One',
		'2'  => 'Two',
		'3'  => 'Three',
		'4'  => 'Four',
		'5'  => 'Five',
		'6'  => 'Six',
		'7'  => 'Seven',
		'8'  => 'Eight',
		'9'  => 'Nine',
		'10' => 'Ten',
		'11' => 'Eleven',
		'12' => 'Twelve',
		'13' => 'Thirteen',
		'14' => 'Fourteen',
		'15' => 'Fifteen',
		'16' => 'Sixteen',
		'17' => 'Seventeen',
		'18' => 'Eighteen',
		'19' => 'Nineteen',
		'20' => 'Twenty',
		'30' => 'Thirty',
		'40' => 'Forty',
		'50' => 'Fifty',
		'60' => 'Sixty',
		'70' => 'Seventy',
		'80' => 'Eighty',
		'90' => 'Ninety',
	);

	/**
	 * Crore Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $croreDivisor = 10000000;
	/**
	 * Lakh Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $lakhDivisor = 100000;
	/**
	 * Thousand Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $thousandDivisor = 1000;
	/**
	 * Hundred Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $hundredDivisor = 100;
	/**
	 * A flag to properly append AND to the last hundred word
	 *
	 * @var        boolean
	 * @access     private
	 */
	private $firstCall = false;

	/**
	 * Converts a number into words value following indian number system with
	 * lakh and crore
	 *
	 * The number supplied has to be greater than 0. Negative numbers aren't
	 * supported.
	 *
	 * @param      integer|float                     $number  The number to
	 *                                                        convert
	 *
	 * @throws     Exception\NTWIndiaInvalidNumber   When passed variable is not numeric
	 * @throws     Exception\NTWIndiaNumberOverflow  When passed number is greater than system maximum
	 *
	 * @return     string                            The covnerted value
	 */
	public function numToWord( $number ) {
		/**
		 * Check if a valid number is passed
		 *
		 * If not then log a warning
		 */
		if ( ! is_numeric( $number ) ) {
			throw new Exception\NTWIndiaInvalidNumber( 'Valid number not given.' );
		}

		// Check if number is exceeding the system maximum
		if ( $number > PHP_INT_MAX ) {
			throw new Exception\NTWIndiaNumberOverflow( 'Number is greater than system maximum.' );
		}

		// Convert to the absolute value
		$number = abs( $number );

		// Check if zero
		if ( 0 == $number ) {
			return $this->numToWord['0'];
		}

		// Change flag
		$this->firstCall = true;

		// Special consideration for floats
		if ( is_float( $number ) ) {
			$dot = explode( '.', $number );
			// If there is some integer after the dot and not just zero
			// then we consider adding XXX/1000 to it
			if ( isset( $dot[1] ) && $dot[1] > 0 ) {
				// We dont need the and here
				$this->firstCall = false;
				return $this->convertNumber( $dot[0] ) . ' ' . $this->and . ' ' . intval( $dot[1] ) . '/1' . str_repeat( '0', strlen( $dot[1] ) );
			} else {
				return $this->convertNumber( $dot[0] );
			}
		}

		return $this->convertNumber( $number );
	}

	/**
	 * Converts the number into word by breaking into quotients and remainders
	 *
	 * All the calculations happen here and it shouldn't be called directly
	 *
	 * @access     private
	 *
	 * @param      integer  $number  The number
	 *
	 * @return     string   Converted word value of the number
	 */
	private function convertNumber( $number ) {
		// Init the return
		$word = array();
		// Lets start with crore
		$crore_quotient = floor( $number / $this->croreDivisor );
		$crore_remainder = $number % $this->croreDivisor;

		// If more than crore
		if ( $crore_quotient > 0 ) {
			// Modify the flag
			$firstCall = $this->firstCall;
			$this->firstCall = false;
			$word['crore'] = $this->convertNumber( $crore_quotient );
			// Swap the flag
			$this->firstCall = $firstCall;
			unset( $firstCall );
		}

		// Calculate Lakh
		$lakh_quotient = floor( $crore_remainder / $this->lakhDivisor );
		$lakh_remainder = $crore_remainder % $this->lakhDivisor;

		// If more than lakh
		if ( $lakh_quotient > 0 ) {
			$word['lakh'] = $this->numToWordSmall( $lakh_quotient );
		}

		// Calculate thousand
		$thousand_quotient = floor( $lakh_remainder / $this->thousandDivisor );
		$thousand_remainder = $lakh_remainder % $this->thousandDivisor;

		// If more than thousand
		if ( $thousand_quotient > 0 ) {
			$word['thousand'] = $this->numToWordSmall( $thousand_quotient );
		}

		// Calculate hundred
		$hundred_quotient = floor( $thousand_remainder / $this->hundredDivisor );
		$hundred_remainder = $thousand_remainder % $this->hundredDivisor;

		// If more than hundred
		if ( $hundred_quotient > 0 ) {
			$word['hundred'] = $this->numToWordSmall( $hundred_quotient );
		}

		// If less than hundred but more than zero
		if ( $hundred_remainder > 0 ) {
			$word['zero'] = $this->numToWordSmall( $hundred_remainder );
		}

		// Now finalize the return
		$return = '';
		foreach ( $word as $pos => $val ) {
			if ( 'zero' == $pos ) {
				if ( true == $this->firstCall && $number > 99 ) {
					$return .= ' ' . $this->and;
				}
				$return .= ' ' . $val;
			} else {
				$return .= ' ' . $val . ' ' . $this->{$pos};
			}
		}
		return trim( $return );
	}

	/**
	 * Converts a small number to its word value
	 *
	 * The number has to be less than 100 otherwise it will call convertNumber
	 * method
	 *
	 * It can be called when you know the number is less than 100 to reduce
	 * memory and calculation
	 *
	 * @param      int                               $number  The number
	 *
	 * @throws     Exception\NTWIndiaInvalidNumber   When a valid number is not given
	 * @throws     Exception\NTWIndiaNumberOverflow  When number is greater than 99
	 *
	 * @return     string                            Word value of the number
	 */
	public function numToWordSmall( $number ) {
		// Check if number is numeric
		if ( ! is_numeric( $number ) ) {
			throw new Exception\NTWIndiaInvalidNumber( 'Valid number not given.' );
		}
		$number = floor( abs( $number ) );

		// Check if number is greater than 99
		// If so, then just throw an exception
		if ( $number > 99 ) {
			throw new Exception\NTWIndiaNumberOverflow( 'Number is greater than 99. Use numToWord method.' );
		}

		// Calculate the last character beforehand
		$lastCharacter = substr( "$number", -1 );

		// Check if direct mapping is possible
		if ( isset( $this->numToWord[ "$number" ] ) ) {
			return $this->numToWord[ "$number" ];
		} elseif ( $number < 30 ) {
			return $this->numToWord['20'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 40 ) {
			return $this->numToWord['30'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 50 ) {
			return $this->numToWord['40'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 60 ) {
			return $this->numToWord['50'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 70 ) {
			return $this->numToWord['60'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 80 ) {
			return $this->numToWord['70'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 90 ) {
			return $this->numToWord['80'] . ' ' . $this->numToWord[ $lastCharacter ];
		} elseif ( $number < 100 ) {
			return $this->numToWord['90'] . ' ' . $this->numToWord[ $lastCharacter ];
		}
	}
}
