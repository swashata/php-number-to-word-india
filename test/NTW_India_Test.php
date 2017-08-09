<?php
class NTW_India_Test extends \PHPUnit\Framework\TestCase {
	public $ntw;

	public function setUp() {
		$this->ntw = new \ntwIndia\NTW_India();
	}

	public function test_more_than_crore() {
		$num = 3104007200;
		$word = 'Three Hundred Ten Crore Forty Lakh Seven Thousand Two Hundred';
		$this->assertEquals( $word, $this->ntw->num_to_word( $num ) );
	}

	public function test_more_than_lakh() {
		$num = 4803078;
		$word = 'Forty Eight Lakh Three Thousand And Seventy Eight';
		$this->assertEquals( $word, $this->ntw->num_to_word( $num ) );

		$num = 128503;
		$word = 'One Lakh Twenty Eight Thousand Five Hundred And Three';
		$this->assertEquals( $word, $this->ntw->num_to_word( $num ) );
	}

	public function test_more_than_thousand() {
		$num = 34876;
		$word = 'Thirty Four Thousand Eight Hundred And Seventy Six';
		$this->assertEquals( $word, $this->ntw->num_to_word( $num ) );
	}

	public function test_more_than_hundred() {
		$num = 724;
		$word = 'Seven Hundred And Twenty Four';
		$this->assertEquals( $word, $this->ntw->num_to_word( $num ) );
	}

	public function test_less_than_hundred() {
		$num_to_wd = $this->get_num_to_word();

		foreach ( $num_to_wd as $num => $wd ) {
			$this->assertEquals( $wd, $this->ntw->num_to_word( $num ) );
		}
	}

	public function test_zero_value() {
		$num = 0;
		$word = 'Zero';
		$this->assertEquals( $word, $this->ntw->num_to_word( $num ) );
	}

	public function test_num_to_wd_small() {
		$num_to_wd = $this->get_num_to_word();
		foreach ( $num_to_wd as $num => $wd ) {
			$this->assertEquals( $wd, $this->ntw->num_to_wd_small( $num ) );
		}
	}

	private function get_num_to_word() {
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
