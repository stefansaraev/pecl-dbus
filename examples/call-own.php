<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = new DbusObject( $d, "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");
var_dump( $n->myFirstMethod() );
?>
