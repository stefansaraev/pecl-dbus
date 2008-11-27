<?php
$d = new Dbus;
$n = new DbusObject( $d, "im.pidgin.purple.PurpleService", "/im/pidgin/purple/PurpleObject", "org.freedesktop.DBus.Introspectable");
$n = new DbusObject( $d, "org.freedesktop.Notifications", "/org/freedesktop/Notifications", "org.freedesktop.DBus.Introspectable");
$d = $n->Introspect( false );

file_put_contents( 'introspect.xml', $d[0] );
?>
