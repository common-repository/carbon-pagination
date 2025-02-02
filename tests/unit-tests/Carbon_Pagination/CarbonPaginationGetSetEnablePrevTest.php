<?php
/**
 * @group pagination
 */
class CarbonPaginationGetSetEnablePrevTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination' );
		$this->pagination = $paginationStub;
	}

	public function tearDown() {
		unset( $this->pagination );
	}

	/**
	 * @covers Carbon_Pagination::get_enable_prev
	 * @covers Carbon_Pagination::set_enable_prev
	 */
	public function testNonBool() {
		$this->pagination->set_enable_prev( 0 );
		$this->assertSame( false, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( "" );
		$this->assertSame( false, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( 1 );
		$this->assertSame( true, $this->pagination->get_enable_prev() );

		$this->pagination->set_enable_prev( "foo" );
		$this->assertSame( true, $this->pagination->get_enable_prev() );
	}

}