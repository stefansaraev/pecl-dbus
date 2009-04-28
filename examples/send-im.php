<?php
$d = new Dbus;
$n = $d->createProxy( "im.pidgin.purple.PurpleService", "/im/pidgin/purple/PurpleObject", "im.pidgin.purple.PurpleInterface");
$buddies = $n->PurpleFindBuddies( new DBusInt32( 6849 ), "" );
//$buddies = $n->PurpleFindBuddies( 6849, "" );
foreach( $buddies[0] as $item )
{
	$b = $n->PurpleBuddyGetName( $item );
	echo $b[0], "\n";
}
//var_dump( $n->PurpleFindBuddies( new DBusInt32( 5816 ), 'xxx@jabber.no' ) );
//$c = $n->PurpleConversationNew( new DBusUInt32( 1 ), new DBusInt32( 5816 ), "xx@jabber.no" );
//$im = $n->PurpleConversationGetImData( $c );
//$n->PurpleConvImSend( $im, "Testing sending jabber through dbus from PHP" );
?>
