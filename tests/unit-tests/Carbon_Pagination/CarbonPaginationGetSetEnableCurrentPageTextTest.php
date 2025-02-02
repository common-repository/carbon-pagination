<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetEnableCurrentPageTextTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_enable_current_page_text
	 * @covers Carbon_Pagination::set_enable_current_page_text
	 */
	public function testNonBool() {
		$this->pagination->set_enable_current_page_text( 0 );
		$this->assertSame( false, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( "" );
		$this->assertSame( false, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( 1 );
		$this->assertSame( true, $this->pagination->get_enable_current_page_text() );

		$this->pagination->set_enable_current_page_text( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_current_page_text() );
	}

}