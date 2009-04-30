<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = $d->createProxy( "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");

// Zero return
var_dump( $n->echoZero() );

var_dump( $n->echoOne( 42 ) );
var_dump( $n->echoOne( array( 42, 61, 143 ) ) );
?>
