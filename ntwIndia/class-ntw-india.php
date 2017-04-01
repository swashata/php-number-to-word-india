<?php
namespace ntwIndia;
/**
 * Number to Words in Indian Version
 *
 * PHP Library
 *
 * @author Swashata Ghosh <swashata@iptms.co>
 * @license GPLv3
 */
class NTW_India {
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
	 * Number to Words
	 *
	 * These are the presets we will need
	 *
	 * Rest will be calculated automatically
	 *
	 * @var        array
	 */
	public $num_to_wd = array(
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
	private $crore_divisor = 10000000;
	/**
	 * Lakh Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $lakh_divisor = 100000;
	/**
	 * Thousand Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $thousand_divisor = 1000;
	/**
	 * Hundred Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $hundred_divisor = 100;
	/**
	 * Ten Divisor
	 *
	 * @var        integer
	 * @access     private
	 */
	private $ten_divisor = 10;
	/**
	 * A flag to properly append AND to the last hundred word
	 *
	 * @var        boolean
	 * @access     private
	 */
	private $first_call = false;

	/**
	 * Converts a number into words value following indian number system with
	 * lakh and crore
	 *
	 * The number supplied has to be greater than 0. Negative numbers aren't
	 * supported.
	 *
	 * @param      integer|float  $number  The number to convert
	 *
	 * @return     string         The covnerted value
	 */
	public function num_to_word( $number ) {
		/**
		 * Check if a valid number is passed
		 *
		 * If not then log a warning
		 */
		if ( ! is_numeric( $number ) ) {
			trigger_error( 'Valid number not given.', E_USER_WARNING );
			return '';
		}

		// Convert to the absolute value
		$number = abs( $number );

		// Check if zero
		if ( 0 == $number ) {
			return $this->num_to_wd['0'];
		}

		// Change flag
		$this->first_call = true;

		// Special consideration for floats
		if ( is_float( $number ) ) {
			$dot = explode( '.', $number );
			// If there is some integer after the dot and not just zero
			// then we consider adding XXX/1000 to it
			if ( $dot[1] > 0 ) {
				// We dont need the and here
				$this->first_call = false;
				return $this->convert_number( $dot[0] ) . ' And ' . intval( $dot[1] ) . '/1' . str_repeat( '0', strlen( $dot[1] ) );
			} else {
				return $this->convert_number( $dot[0] );
			}
		}

		return $this->convert_number( $number );
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
	private function convert_number( $number ) {
		// Init the return
		$word = array();
		// Lets start with crore
		$crore_quotient = floor( $number / $this->crore_divisor );
		$crore_remainder = $number % $this->crore_divisor;

		// If more than crore
		if ( $crore_quotient > 0 ) {
			// Modify the flag
			$first_call = $this->first_call;
			$this->first_call = false;
			$word['crore'] = $this->convert_number( $crore_quotient );
			// Swap the flag
			$this->first_call = $first_call;
			unset( $first_call );
		}

		// Calculate Lakh
		$lakh_quotient = floor( $crore_remainder / $this->lakh_divisor );
		$lakh_remainder = $crore_remainder % $this->lakh_divisor;

		// If more than lakh
		if ( $lakh_quotient > 0 ) {
			$word['lakh'] = $this->num_to_ind( $lakh_quotient );
		}

		// Calculate thousand
		$thousand_quotient = floor( $lakh_remainder / $this->thousand_divisor );
		$thousand_remainder = $lakh_remainder % $this->thousand_divisor;

		// If more than thousand
		if ( $thousand_quotient > 0 ) {
			$word['thousand'] = $this->num_to_ind( $thousand_quotient );
		}

		// Calculate hundred
		$hundred_quotient = floor( $thousand_remainder / $this->hundred_divisor );
		$hundred_remainder = $thousand_remainder % $this->hundred_divisor;

		// If more than hundred
		if ( $hundred_quotient > 0 ) {
			$word['hundred'] = $this->num_to_ind( $hundred_quotient );
		}

		// If less than hundred but more than zero
		if ( $hundred_remainder > 0 ) {
			$word['zero'] = $this->num_to_ind( $hundred_remainder );
		}

		// Now finalize the return
		$return = '';
		foreach ( $word as $pos => $val ) {
			if ( 'zero' == $pos ) {
				if ( true == $this->first_call ) {
					$return .= ' And';
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
	 * The number has to be less than 100 otherwise it will call convert_number
	 * method
	 *
	 * It can be called when you know the number is less than 100 to reduce
	 * memory and calculation
	 *
	 * @param      int     $number  The number
	 *
	 * @return     string  Word value of the number
	 */
	public function num_to_ind( $number ) {
		$number = floor( abs( $number ) );

		// Check if number is greater than 99
		// If so, then further breaking is needed
		if ( $number > 99 ) {
			return $this->convert_number( $number );
		}

		// Calculate the last character beforehand
		$lc = substr( "$number", -1 );

		// Check if direct mapping is possible
		if ( isset( $this->num_to_wd[ "$number" ] ) ) {
			return $this->num_to_wd[ "$number" ];
		} elseif ( $number < 30 ) {
			return $this->num_to_wd['20'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 40 ) {
			return $this->num_to_wd['30'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 50 ) {
			return $this->num_to_wd['40'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 60 ) {
			return $this->num_to_wd['50'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 70 ) {
			return $this->num_to_wd['60'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 80 ) {
			return $this->num_to_wd['70'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 90 ) {
			return $this->num_to_wd['80'] . ' ' . $this->num_to_wd[ $lc ];
		} elseif ( $number < 100 ) {
			return $this->num_to_wd['90'] . ' ' . $this->num_to_wd[ $lc ];
		}
	}
}
