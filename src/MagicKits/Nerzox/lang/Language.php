<?php

namespace MagicKits\Nerzox\lang;

interface Language {
    public CONST EN = [
        'PLUGIN_ENABLED' => "Plugin enabled!",
        'PLUGIN_DISABLED' => 'Plugin disabled!',
        'DESCRIPTION_COMMAND' => 'All the kits than you can use!',
        'USAGE_COMMAND' => '/kit [kit_name]',
        'NOT_A_PLAYER' => 'Please use this command in game.'
    ];
    public CONST FR = [
        'PLUGIN_ENABLED' => "Plugin allumé!",
        'PLUGIN_DISABLED' => 'Plugin éteint!',
        'DESCRIPTION_COMMAND' => 'Tous les kits que vous pouvez utiliser!',
        'USAGE_COMMAND' => '/kit [nom_du_kit]',
        'NOT_A_PLAYER' => 'Veuillez utiliser cette commande en jeu, s\'il vous plaît.'
    ];
}