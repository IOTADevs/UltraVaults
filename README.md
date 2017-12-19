# UltraVaults - Vaults in ultra way
[![Poggit](https://poggit.pmmp.io/ci.shield/IOTADevs/UltraVaults/~)](https://poggit.pmmp.io/ci/IOTADevs/UltraVaults/~)

UltraVaults is a private vaults / locker plugin which allows players to have their own private locker / vault,
The plugin is also very customizeable (I think) for server owners

# Installation
Drop the phar downloaded from poggit or compiled zip downloaded from github.
Reload or restart server and done!

# Configuration
I've felt that plugins with fixed or hard coded prefixes suck!
They cannot maintain server prefixes/names! So first of all,
go to config.yml and change prefix to your server's name!

# Permission Configuration
Default free vault is 2, however, you can edit it or give permission to x
vault by giving ***vault.(The Vault ID Here)*** permission to the player.

***I highly recommend leaving permission nodes as it is on config.yml
unless you know what you're doing***

# Admin Advantages
This plugin allows to sneak in throught players vault!
Admins with the perm ***vault.administration*** can
delete and see vaults of other players, by default ops
have the permission.

# Command Usage
> Aliases: /v, /pv, /uv, /vault

> /vault (ID) - Opens vault with ID for the player who executed the command

> /vault seevault [name] [ID] - Allows admins to see [name]'s vault with [ID]

> /vault delvault [namr] [ID] - Allows admins to delete [name]'s vault with [ID] completely with its contents

# Support and more info
If you have any issue about this plugin, feel free to open an issue on github
or tweet/dm me on twitter!

> ***Twitter***: @TheAz928

Thanks! Have a nice night :D [Since I wrote this at 12:16 AM]