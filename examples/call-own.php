<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = new DbusObject( $d, "nl.derickrethans.test", "/nl/derickrethans/test", "nl.derickrethans.test");
var_dump( $n->myFirstMethod( new DBusInt32( 8 ), new DBusUint64( 9 ), 5.44, false ) );
//var_dump( $n->myFirstMethod( new DBusInt32( 8 ), new DBusVariant( new DBusUint64( 9 ) ), 5.44, false ) );
?>
