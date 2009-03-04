<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$d->requestName( 'nl.derickrethans.test' );
$s = new DbusSignal( $d, '/nl/derickrethans/SignalObject', 'nl.derickrethans.Interface', 'Test' );
$s->send();
?>
