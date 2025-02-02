<?php
/**
 * @group pagination
 * @group pagination_html
 */
class CarbonPaginationHtmlGetSetWrapperAfterTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination_HTML::get_wrapper_after
	 * @covers Carbon_Pagination_HTML::set_wrapper_after
	 */
	public function testGetSetWrapperAfter() {
		$html = '<span class="foo"></span></div>';
		$this->pagination->set_wrapper_after( $html );
		$this->assertSame( $html, $this->pagination->get_wrapper_after() );
	}

}