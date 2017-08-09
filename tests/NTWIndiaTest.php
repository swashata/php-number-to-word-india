<?php
/**
 * PHPUnit test for NTWIndia
 */
class NTWIndiaTest extends \PHPUnit\Framework\TestCase {
	public $ntw;

	public function setUp() {
		$this->ntw = new \NTWIndia\NTWIndia();
	}

	public function testMoreThanCrore() {
		$num = 3104007200;
		$word = 'Three Hundred Ten Crore Forty Lakh Seven Thousand Two Hundred';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
	}

	public function testMoreThanLakh() {
		$num = 4803078;
		$word = 'Forty Eight Lakh Three Thousand And Seventy Eight';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );

		$num = 128503;
		$word = 'One Lakh Twenty Eight Thousand Five Hundred And Three';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
	}

	public function testMoreThanThousand() {
		$num = 34876;
		$word = 'Thirty Four Thousand Eight Hundred And Seventy Six';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
	}

	public function testMoreThanHundred() {
		$num = 724;
		$word = 'Seven Hundred And Twenty Four';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
	}

	public function testLessThanHundred() {
		$num_to_wd = $this->getNumToWord();

		foreach ( $num_to_wd as $num => $wd ) {
			$this->assertEquals( $wd, $this->ntw->numToWord( $num ) );
		}
	}

	public function testZeroValue() {
		$num = 0;
		$word = 'Zero';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
	}

	public function testFloatingValue() {
		$num = 100.24;
		$word = 'One Hundred And 24/100';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
		$num = 123.00;
		$word = 'One Hundred And Twenty Three';
		$this->assertEquals( $word, $this->ntw->numToWord( $num ) );
	}

	public function testNumToWdSmall() {
		$num_to_wd = $this->getNumToWord();
		foreach ( $num_to_wd as $num => $wd ) {
			$this->assertEquals( $wd, $this->ntw->numToWordSmall( $num ) );
		}
	}

	/**
	 * @expectedException NTWIndia\Exception\NTWIndiaInvalidNumber
	 */
	public function testNumToWordException() {
		$this->ntw->numToWord( 'foo' );
	}

	/**
	 * @expectedException NTWIndia\Exception\NTWIndiaNumberOverflow
	 */
	public function testNumToWordOverflowException() {
		$this->ntw->numToWord( 92233720368547758070 );
	}

	/**
	 * @expectedException NTWIndia\Exception\NTWIndiaInvalidNumber
	 */
	public function testNumToWordSmallException() {
		$this->ntw->numToWordSmall( 'bar' );
	}

	/**
	 * @expectedException NTWIndia\Exception\NTWIndiaNumberOverflow
	 */
	public function testNumToWordSmallOverflowException() {
		$this->ntw->numToWordSmall( 200 );
	}

	private function getNumToWord() {
		return array(
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
	}
}
