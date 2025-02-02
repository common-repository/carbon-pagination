<?php
/**
 * @group renderer
 */
class CarbonPaginationRendererParseTokensTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->renderer);
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseTokenInTheBeginning() {
		$string = '{FOO} lorem ipsum';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'bar lorem ipsum', $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseTokenInTheMiddle() {
		$string = 'Lorem {FOO} ipsum';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'Lorem bar ipsum', $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseTokenInTheEnd() {
		$string = 'Lorem ipsum {FOO}';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'Lorem ipsum bar', $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseMiltipleTokenOccurences() {
		$string = 'Lorem ipsum {FOO} dolor {FOO} sit amet.';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'Lorem ipsum bar dolor bar sit amet.', $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseMiltipleTokens() {
		$string = 'Lorem ipsum {FOO} dolor {BAR} sit amet.';
		$tokens = array(
			'FOO' => 'bar',
			'BAR' => 'foo',
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'Lorem ipsum bar dolor foo sit amet.', $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseUnexistingTokens() {
		$string = 'Lorem ipsum {BAR} dolor {Foo} sit {foo} amet.';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( $string, $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseExistingTokensWithIncorrectSyntax() {
		$string = 'Lorem { FOO}ipsum {FOO } { FOO } {FOO dolor FOO} sit FOO amet.';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( $string, $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseExistingTokensWithDoubleCurlyBrackets() {
		$string = 'Lorem {{FOO}} amet.';
		$tokens = array(
			'FOO' => 'bar'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'Lorem {bar} amet.', $result );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::parse_tokens
	 */
	public function testParseExistingTokensWithDoubleCurlyBracketsRecursion() {
		$string = 'Lorem {{FOO}} amet.';
		$tokens = array(
			'FOO' => 'FOO'
		);

		$result = $this->renderer->parse_tokens( $string, $tokens );
		$this->assertSame( 'Lorem {FOO} amet.', $result );
	}

}