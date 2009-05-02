<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");

// Zero return
var_dump( $n->echoZero() );

// One return
var_dump( $n->echoOne( 42 ) );
var_dump( $n->echoOne( array( 42, 61, 143 ) ) );

// Two returns
var_dump( $o = $n->echoTwo( false, "foobar" ) );
var_dump( $o->getData() );
var_dump( $o = $n->echoTwo( array( false, false, true ), 85.4 ) );
var_dump( $o->getData() );
?>
