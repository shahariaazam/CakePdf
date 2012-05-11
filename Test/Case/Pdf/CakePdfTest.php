<?php

App::uses('CakePdf', 'CakePdf.Pdf');
App::uses('AbstractPdfEngine', 'CakePdf.Pdf/Engine');

/**
 * Dummy engine
 */
class PdfTestEngine extends AbstractPdfEngine {

	public function output() {
		return $this->_Pdf->html();
	}
}

/**
 * CakePdfTest class
 *
 * @package       CakePdf.Test.Case.Lib.CakePdf
 */
class CakePdfTest extends CakeTestCase {

/**
 *
 */
	public static function provider() {
		return array(array(array(
				'engine' => 'PdfTest',
				'margin' => array(
					'bottom' => 15,
					'left' => 50,
					'right' => 30,
					'top' => 45
		))));
	}

/**
 * Tests exception to be thrown for a non existing engine
 *
 * @expectedException CakeException
 */
	public function testNonExistingEngineException() {
		$config = array('engine' => 'NonExistingEngine');

		$pdf = new CakePdf($config);
	}

/**
 *
 * @dataProvider provider
 */
	public function testOutput($config) {
		$pdf = new CakePdf($config);
		$html = '<h2>Title</h2>';
		$result = $pdf->output($html);
		$this->assertEquals($html, $result);
	}

/**
 * Tests that engine returns the proper object
 *
 * @dataProvider provider
 */
	public function testEngine($config) {
		$pdf = new CakePdf($config);
		$engine = $pdf->engine();
		$this->assertEqual('PdfTestEngine', get_class($engine));
	}

/**
 *
 * @dataProvider provider
 */
	public function testMargin($config) {
		$pdf = new CakePdf($config);
		$pdf->margin(15, 20, 25, 30);
		$expected = array(
			'bottom' => 15,
			'left' => 20,
			'right' => 25,
			'top' => 30
		);
		$this->assertEqual($expected, $pdf->margin());

		$pdf = new CakePdf($config);
		$pdf->margin(75);
		$expected = array(
			'bottom' => 75,
			'left' => 75,
			'right' => 75,
			'top' => 75
		);
		$this->assertEqual($expected, $pdf->margin());

		$pdf = new CakePdf($config);
		$pdf->margin(20, 50);
		$expected = array(
			'bottom' => 20,
			'left' => 50,
			'right' => 50,
			'top' => 20
		);
		$this->assertEqual($expected, $pdf->margin());

		$pdf = new CakePdf($config);
		$pdf->margin(array('left' => 120, 'right' => 30, 'top' => 34, 'bottom' => 15));
		$expected = array(
			'bottom' => 15,
			'left' => 120,
			'right' => 30,
			'top' => 34
		);
		$this->assertEqual($expected, $pdf->margin());

		$pdf = new CakePdf($config);
		$expected = array(
			'bottom' => 15,
			'left' => 50,
			'right' => 30,
			'top' => 45
		);
		$this->assertEqual($expected, $pdf->margin());
	}
}
