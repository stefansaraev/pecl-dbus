<?php
$d = new Dbus;
$n = $d->createProxy( "im.pidgin.purple.PurpleService", "/im/pidgin/purple/PurpleObject", "im.pidgin.purple.PurpleInterface");
$data = $n->PurpleAccountsGetAllActive();
foreach( $data[0]->getData() as $account )
{
	$buddies = $n->PurpleFindBuddies( $account, '' );
	$protocol = $n->PurpleAccountGetProtocolName( $account );
	echo $protocol[0], "\n";
	foreach ( $buddies[0]->getData() as $buddyId )
	{
		$online = $n->PurpleBuddyIsOnline( $buddyId );
		$alias = $n->PurpleBuddyGetAlias( $buddyId );
		if ( $online[0] )
		{
			printf( "- %s\n", $alias[0] );
		}
	}
}
?>
