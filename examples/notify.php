<?php
$d = new Dbus( Dbus::BUS_SESSION, true );
$n = new DbusObject( $d, "org.freedesktop.Notifications", "/org/freedesktop/Notifications", "org.freedesktop.Notifications");
var_dump( $n->GetCapabilities() );
$o = $n->Notify( 'Testapp', new DBusUInt32( 0 ), 'iceweasel', 'Testing http://ez.no', 'tEST aPPLICATION',
	new DBusArray( DBus::STRING, array() ),
	new DBusDict( DBus::VARIANT, array( 'x' => new DBusVariant( 500 ), 'y' => new DBusVariant( 500 ), 'desktop-entry' => new DBusVariant( 'rhythmbox' ) ) ),
	new DBusInt32( 9000 )
	);
var_dump( $o );
$o = $n->Notify( 'Testapp', 0, 'iceweasel', 'Testing http://ez.no', 'Test Application',
	new DBusArray( DBus::STRING, array() ),
	new DBusDict( DBus::VARIANT, array( 'x' => new DBusVariant( 500 ), 'y' => new DBusVariant( 500 ), 'desktop-entry' => new DBusVariant( 'rhythmbox' ) ) ),
	500
	);
var_dump( $o );
?>
