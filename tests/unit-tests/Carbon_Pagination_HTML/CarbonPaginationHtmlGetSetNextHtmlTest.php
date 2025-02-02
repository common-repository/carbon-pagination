<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlGetSetNextHtmlTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_next_html
	 * @covers Carbon_Pagination_HTML::set_next_html
	 */
	public function testGetSetNextHtml() {
		$html = '<a class="foo">Bar</a>';
		$this->pagination->set_next_html( $html );
		$this->assertSame( $html, $this->pagination->get_next_html() );
	}

}